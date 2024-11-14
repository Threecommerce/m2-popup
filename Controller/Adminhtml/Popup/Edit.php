<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Controller\Adminhtml\Popup;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Threecommerce\Popup\Model\PopupFactory;
use Magento\Framework\Registry;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $popupFactory;
    protected $coreRegistry;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        PopupFactory $popupFactory,
        Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->popupFactory = $popupFactory;
        $this->coreRegistry = $coreRegistry;
    }

    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $popup = $this->popupFactory->create();

        if ($id) {
            $popup->load($id);
            if (!$popup->getId()) {
                $this->messageManager->addErrorMessage(__('This popup no longer exists.'));
                return $this->resultRedirectFactory->create()->setPath('*/*/');
            }
        }

        $this->coreRegistry->register('threecommerce_popup', $popup);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Popup') : __('New Popup'));

        return $resultPage;
    }
}
