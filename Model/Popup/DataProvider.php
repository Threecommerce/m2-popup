<?php
declare(strict_types=1);

namespace Threecommerce\Popup\Model\Popup;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Psr\Log\LoggerInterface;
use Threecommerce\Popup\Model\ResourceModel\Popup\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    protected $loadedData;
    protected $logger;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        LoggerInterface $logger,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        $this->logger = $logger;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $this->logger->info('getData called');

        if (isset($this->loadedData)) {
            $this->logger->info('Loaded data from cache: ' . print_r($this->loadedData, true));
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
        }

        if (empty($this->loadedData)) {
            $this->loadedData = [
                'items' => [],
                'totalRecords' => 0,
            ];
        }

        $this->logger->info('Loaded data: ' . print_r($this->loadedData, true));
        return $this->loadedData;
    }
}
