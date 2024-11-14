<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Block\Adminhtml\Renderer;

use Magento\Framework\DataObject;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Store\Model\StoreManagerInterface;
use Threecommerce\Popup\Helper\Data as PopupHelper;

class StoreAndPage extends AbstractRenderer
{
    protected $popupHelper;
    protected $storeManager;

    public function __construct(
        StoreManagerInterface $storeManager,
        PopupHelper $popupHelper
    ) {
        $this->storeManager = $storeManager;
        $this->popupHelper = $popupHelper;
    }

    public function render(DataObject $row)
    {
        $columnIndex = $this->getColumn()->getIndex();
        $idsString = $row->getData($columnIndex);
        $ids = explode(',', trim($idsString, ','));
        if ($columnIndex === 'store')
            $options = $this->popupHelper->getStoreOptionsForGrid();
        else
            $options = $this->popupHelper->getPageOptionsForGrid();
        $names = [];
        foreach ($ids as $id) {
            if (isset($options[$id]))
                $names[] = $options[$id];
        }
        return implode(', ', $names);
    }
}
