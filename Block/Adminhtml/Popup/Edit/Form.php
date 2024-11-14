<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Block\Adminhtml\Popup\Edit;

use Threecommerce\Popup\Helper\Data as PopupHelper;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;

class Form extends Generic
{
    protected $popupHelper;

    public function __construct(
        Registry                                $registry,
        FormFactory                             $formFactory,
        \Magento\Backend\Block\Template\Context $context,
        PopupHelper                             $popupHelper,
        array                                   $data = []
    )
    {
        $this->popupHelper = $popupHelper;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );
        $form->setHtmlIdPrefix('popup_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Popup Information'), 'class' => 'fieldset-wide']
        );
        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            'contenuto',
            'textarea',
            [
                'name' => 'contenuto',
                'label' => __('Content'),
                'title' => __('Content'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            'css',
            'textarea',
            [
                'name' => 'css',
                'label' => __('Css'),
                'title' => __('Css')
            ]
        );
        $fieldset->addField(
            'timing',
            'text',
            [
                'name' => 'timing',
                'label' => __('Timing'),
                'title' => __('Timing'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            'mostra_in_pagina',
            'multiselect',
            [
                'label' => __('Show In Page'),
                'title' => __('Show In Page'),
                'name' => 'mostra_in_pagina',
                'required' => false,
                'values' => $this->popupHelper->getPageOptionsForForm()
            ]
        );
        $fieldset->addField(
            'attivo',
            'select',
            [
                'label' => __('Active'),
                'title' => __('Active'),
                'name' => 'attivo',
                'required' => true,
                'options' => [0 => __('No'), 1 => __('Yes')]
            ]
        );

        $fieldset->addField(
            'store',
            'multiselect',
            [
                'label' => __('Store View'),
                'title' => __('Store View'),
                'name' => 'store',
                'required' => true,
                'values' => $this->popupHelper->getStoreOptionsForForm()
            ]
        );

        $fieldset->addField(
            'mostra_da',
            'date',
            [
                'name' => 'mostra_da',
                'label' => __('Show From Date'),
                'title' => __('Show From Date'),
                'required' => false,
                'date_format' => 'yyyy-MM-dd',
                'time_format' => 'HH:mm:ss',
            ]
        );

        $fieldset->addField(
            'mostra_a',
            'date',
            [
                'name' => 'mostra_a',
                'label' => __('Show To Date'),
                'title' => __('Show To Date'),
                'required' => false,
                'date_format' => 'yyyy-MM-dd',
                'time_format' => 'HH:mm:ss',
            ]
        );

        // Campo Nascosto per l'ID
        $popup = $this->_coreRegistry->registry('threecommerce_popup');
        if ($popup && $popup->getId()) {
            $fieldset->addField(
                'id',
                'hidden',
                [
                    'name' => 'id',
                    'value' => $popup->getId(),
                ]
            );
        }
        if ($popup)
            $form->setValues($popup->getData());

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
