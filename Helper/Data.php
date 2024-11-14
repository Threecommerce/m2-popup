<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Helper;

use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as PageCollectionFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
    protected $pageCollectionFactory;
    protected $storeManager;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        PageCollectionFactory                 $pageCollectionFactory,
        StoreManagerInterface                 $storeManager
    )
    {
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->pageCollectionFactory = $pageCollectionFactory;
    }

    /**
     * Recupera un array di opzioni Store ID => Nome Store
     *
     * @return array
     */
    public function getStoreOptionsForForm(): array
    {
        $options = [
            ['value' => 0, 'label' => __('All Store Views')]
        ];
        $stores = $this->storeManager->getStores(true);
        foreach ($stores as $store) {
            $options[] = ['value' => $store->getId(), 'label' => $store->getCode()];
        }

        return $options;
    }

    /**
     * Recupera un array di opzioni Store ID => Nome Store
     *
     * @return array
     */
    public function getStoreOptionsForGrid(): array
    {
        $options = [
            0 => __('All Store Views')
        ];

        $stores = $this->storeManager->getStores(true);
        foreach ($stores as $store) {
            $options[$store->getId()] = $store->getCode();
        }

        return $options;
    }

    /**
     * Recupera le opzioni delle pagine CMS come array per il multiselect.
     * Usato per il form.
     *
     * @return array
     */
    public function getPageOptionsForForm(): array
    {
        $options = $this->getStaticPagesForForm();
        $pages = $this->pageCollectionFactory->create()->addFieldToSelect(['page_id', 'identifier'])->addFieldToFilter('is_active', 1);
        foreach ($pages as $page) {
            $options[] = ['value' => $page->getId(), 'label' => $page->getIdentifier()];
        }
        return $options;
    }

    /**
     * Recupera le opzioni delle pagine CMS per la griglia.
     * Usato per la griglia.
     *
     * @return array
     */
    public function getPageOptionsForGrid(): array
    {
        $options = $this->getStaticPagesForGrid();
        $pages = $this->pageCollectionFactory->create()->addFieldToSelect(['page_id', 'identifier'])->addFieldToFilter('is_active', 1);
        foreach ($pages as $page) {
            $options[$page->getId()] = $page->getIdentifier();
        }
        return $options;
    }

    /**
     * Definisce le pagine standard di Magento per il form.
     *
     * @return array
     */
    protected function getStaticPagesForForm(): array
    {
        return [
            ['value' => '', 'label' => __('All Pages')],
            ['value' => 'cart', 'label' => __('Cart')],
            ['value' => 'checkout', 'label' => __('Checkout')],
            ['value' => 'customer_account', 'label' => __('My Account')],
            ['value' => 'customer_login', 'label' => __('Customer Login')],
        ];
    }

    /**
     * Definisce le pagine standard di Magento per la griglia.
     *
     * @return array
     */
    protected function getStaticPagesForGrid(): array
    {
        return [
            '' => __('All Pages'),
            'cart' => __('Cart'),
            'checkout' => __('Checkout'),
            'customer_account' => __('My Account'),
            'customer_login' => __('Customer Login'),
            // Aggiungi altre pagine personalizzate qui, se necessario
        ];
    }
}
