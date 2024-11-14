<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Model\ResourceModel\Popup;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Threecommerce\Popup\Model\Popup;
use Threecommerce\Popup\Model\ResourceModel\Popup as PopupResource;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'threecommerce_popup_popup_collection';
    protected $_eventObject = 'popup_collection';

    protected function _construct()
    {
        $this->_init(Popup::class, PopupResource::class);
    }
}
