<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Controller\Adminhtml\Popup;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $this->_view->loadLayout();
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Threecommerce Popup'));
        $resultPage->setActiveMenu('Threecommerce_Popup::Popup');
        $resultPage->addBreadcrumb(__('Catalogo'), __('Threecommerce Popup'));
        $this->_addContent($this->_view->getLayout()->createBlock('Threecommerce\Popup\Block\Adminhtml\Grid\Grid'));
        $this->_view->renderLayout();
    }

    protected function _isAllowed()
    {
        return true;
    }
}
