<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Controller\Adminhtml\Popup;

use Threecommerce\Popup\Model\PopupFactory;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    protected $popupFactory;

    public function __construct(
        Action\Context $context,
        PopupFactory   $popupFactory
    )
    {
        parent::__construct($context);
        $this->popupFactory = $popupFactory;
    }

    public function execute(): Redirect
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $id = $this->getRequest()->getParam('id');
            $popup = $this->popupFactory->create();
            $data['store'] = ',' . implode(',', $data['store']) . ',';
            $data['mostra_in_pagina'] = isset($data['mostra_in_pagina']) && !$data['mostra_in_pagina'] ? ',' . implode(',', $data['mostra_in_pagina']) . ',' : '';
            if ($id) {
                $popup->load($id);
                if (!$popup->getId()) {
                    $this->messageManager->addErrorMessage(__('This popup no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $popup->setData($data);
            try {
                $popup->save();
                $this->messageManager->addSuccessMessage(__('The popup has been saved.'));

                if ($this->getRequest()->getParam('back') === 'edit') {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $popup->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the popup.'));
            }
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
