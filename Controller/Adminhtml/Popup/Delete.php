<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Controller\Adminhtml\Popup;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Threecommerce\Popup\Model\PopupFactory;
use Magento\Framework\Message\ManagerInterface;

class Delete extends Action
{
    protected $popupFactory;
    protected $messageManager;

    public function __construct(
        Action\Context $context,
        PopupFactory $popupFactory,
        ManagerInterface $messageManager
    ) {
        parent::__construct($context);
        $this->popupFactory = $popupFactory;
        $this->messageManager = $messageManager;
    }

    public function execute(): Redirect
    {
        $id = (int) $this->getRequest()->getParam('id');
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $popup = $this->popupFactory->create();
                $popup->load($id);
                if (!$popup->getId()) {
                    throw new LocalizedException(__('This popup no longer exists.'));
                }
                $popup->delete();
                $this->messageManager->addSuccessMessage(__('The popup has been deleted.'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('An error occurred while deleting the popup.'));
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        } else {
            $this->messageManager->addErrorMessage(__('We can\'t find a popup to delete.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
