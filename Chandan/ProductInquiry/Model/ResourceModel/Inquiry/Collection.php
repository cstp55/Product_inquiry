<?php
namespace Chandan\ProductInquiry\Model\ResourceModel\Inquiry;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Chandan\ProductInquiry\Model\Inquiry;
use Chandan\ProductInquiry\Model\ResourceModel\Inquiry as InquiryResource;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'inquiry_id';

    protected function _construct()
    {
        $this->_init(Inquiry::class, InquiryResource::class);
    }
}
