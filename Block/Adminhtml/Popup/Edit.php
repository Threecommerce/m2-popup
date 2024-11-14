<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Block\Adminhtml\Popup;

use Magento\Backend\Block\Widget\Form\Container;

class Edit extends Container
{
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Threecommerce_Popup';
        $this->_controller = 'adminhtml_popup';

        parent::_construct();
        $this->buttonList->update('back', 'label', __('Back'));
        $this->buttonList->add(
            'delete',
            [
                'label' => __('Delete Popup'),
                'class' => 'delete',
                'onclick' => "deleteConfirm(
            '" . __('Are you sure you want to delete this popup?') . "',
            '" . $this->getUrl('*/*/delete', ['id' => $this->getRequest()->getParam('id')]) . "'
        )"
            ]
        );
        $this->buttonList->add(
            'save_and_continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form',
                            'action' => [
                                'args' => [
                                    'back' => 'edit'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        );
        $this->buttonList->update('save', 'label', __('Save Popup'));
    }

    public function getHeaderText()
    {
        return __('Add New Popup');
    }
}
