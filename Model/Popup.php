<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class Popup extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'threecommerce_label_popup';

    protected $_cacheTag = 'threecommerce_label_popup';

    protected $_eventPrefix = 'threecommerce_label_popup';

    protected function _construct()
    {
        $this->_init('Threecommerce\Popup\Model\ResourceModel\Popup');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}
