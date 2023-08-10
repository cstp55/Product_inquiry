<?php
// app/code/Chandan/ProductInquiry/Model/ResourceModel/Inquiry/Grid/DataProvider.php
namespace Chandan\ProductInquiry\Model\ResourceModel\Inquiry\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\Search\AggregationInterface;
use Chandan\ProductInquiry\Model\ResourceModel\Inquiry\Collection as InquiryCollection;
use Chandan\ProductInquiry\Model\ResourceModel\Inquiry\CollectionFactory as InquiryCollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        InquiryCollectionFactory $collectionFactory,
        AggregationInterface $aggregation,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $aggregation, $meta, $data);
    }

    public function getData()
    {
        $items = $this->collection->getItems();
        $data = [];
        foreach ($items as $item) {
            $data[$item->getId()] = $item->getData();
        }
        return $data;
    }
}
