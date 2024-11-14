<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Block\Adminhtml\Grid;

use Threecommerce\Popup\Model\ResourceModel\Popup\CollectionFactory as PopupCollection;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Context as Widget;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface as UrlInterface;
use Threecommerce\Popup\Helper\Data as PopupHelper;

class Grid extends Extended
{
    protected $buttonList;
    protected $toolbar;
    protected $registry;
    protected $popupFactory;
    protected $popupHelper;

    public function __construct(
        Context         $context,
        Data            $backendHelper,
        Registry        $registry,
        PopupCollection $popupFactory,
        UrlInterface    $urlInterface,
        Widget          $widget,
        PopupHelper     $popupHelper,
        array           $data = []
    )
    {
        $this->popupHelper = $popupHelper;
        $this->urlInterface = $urlInterface;
        $this->registry = $registry;
        $this->popupFactory = $popupFactory;
        $this->buttonList = $widget->getButtonList();
        $this->toolbar = $widget->getButtonToolbar();
        $buttonUrl = $this->urlInterface->getUrl('threecommerce_popup/popup/edit');
        $this->buttonList->add(
            'assign',
            [
                'label' => 'Crea Popup',
                'onclick' => "setLocation('$buttonUrl')",
                'class' => 'action-primary'
            ]
        );
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _prepareLayout()
    {
        $this->toolbar->pushButtons($this, $this->buttonList);
        return parent::_prepareLayout();
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('id');
        $this->setDefaultSort('id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $this->setCollection($this->popupFactory->create()->addFieldToSelect('*'));
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'id',
                'align' => 'center',
                'index' => 'id',
            ]
        );
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $listColumn = [
            [
                'code' => 'store',
                'type' => 'text',
                'renderer' => \Threecommerce\Popup\Block\Adminhtml\Renderer\StoreAndPage::class,
            ],
            [
                'code' => 'mostra_in_pagina',
                'type' => 'text',
                'renderer' => \Threecommerce\Popup\Block\Adminhtml\Renderer\StoreAndPage::class,
            ],
            ['code' => 'name', 'type' => 'text'],
            ['code' => 'timing', 'type' => 'text'],
            ['code' => 'mostra_da', 'type' => 'date'],
            ['code' => 'mostra_a', 'type' => 'date'],
            ['code' => 'attivo', 'type' => 'options', 'options' => [0 => __('No'), 1 => __('Yes')]]
        ];

        foreach ($listColumn as $column) {
            $infoCol = [
                'header' => __(ucwords(str_replace('_', ' ', $column['code']))),
                'type' => $column['type'],
                'index' => $column['code'],
                'header_css_class' => 'col-' . $column['code'],
                'column_css_class' => 'col-' . $column['code']
            ];
            if (isset($column['options'])) {
                $infoCol['options'] = $column['options'];
            }
            if (isset($column['renderer'])) {
                $infoCol['renderer'] = $column['renderer'];
            }
            $this->addColumn($column['code'], $infoCol);
        }
        $this->addColumn(
            'action',
            [
                'header' => __('Action'),
                'width' => '100px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => ['base' => 'threecommerce_popup/popup/edit'],
                        'field' => 'id'
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'id',
                'is_system' => true
            ]
        );
        return parent::_prepareColumns();
    }

    public function getMainButtonsHtml()
    {
        return;
    }

    public function canRender()
    {
        return true;
    }
}
