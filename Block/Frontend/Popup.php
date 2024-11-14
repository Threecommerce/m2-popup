<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Block\Frontend;

use Threecommerce\Popup\Model\ResourceModel\Popup\CollectionFactory as PopupCollectionFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;

class Popup extends Template
{
    protected $popupCollectionFactory;
    protected $storeManager;
    protected $dateTime;

    public function __construct(
        Template\Context       $context,
        PopupCollectionFactory $popupCollectionFactory,
        StoreManagerInterface  $storeManager,
        DateTime               $dateTime,
        array                  $data = []
    )
    {
        $this->popupCollectionFactory = $popupCollectionFactory;
        $this->storeManager = $storeManager;
        $this->dateTime = $dateTime;
        parent::__construct($context, $data);
    }

    /**
     * Recupera la collection dei popup filtrata in base ai criteri specificati.
     *
     * @return \Threecommerce\Popup\Model\ResourceModel\Popup\Collection
     */
    public function getFilteredPopups()
    {
        $currentStoreId = $this->storeManager->getStore()->getId();
        $currentDate = $this->dateTime->gmtDate('Y-m-d');
        $currentPage = $this->getRequest()->getFullActionName();

        $collection = $this->popupCollectionFactory->create();
        $collection->addFieldToFilter('attivo', 1)
            ->addFieldToFilter('store', [
                ['finset' => '0'],
                ['finset' => $currentStoreId]
            ])
            ->addFieldToFilter(
                ['mostra_da', 'mostra_da'],
                [
                    ['lteq' => $currentDate],
                    ['null' => true]
                ]
            )
            ->addFieldToFilter(
                ['mostra_a', 'mostra_a'],
                [
                    ['gteq' => $currentDate],
                    ['null' => true]
                ]
            )
            ->addFieldToFilter(
                ['mostra_in_pagina', 'mostra_in_pagina', 'mostra_in_pagina'],
                [
                    ['finset' => $currentPage],
                    ['null' => true],
                    ['eq' => '']
                ]
            );

        return $collection;
    }
}
