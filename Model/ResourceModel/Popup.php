<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Popup extends AbstractDb
{
    public function __construct(
        Context $context
    )
    {
        parent::__construct($context);
    }
    protected function _construct()
    {
        $this->_init('threecommerce_popup', 'id');
    }
}
