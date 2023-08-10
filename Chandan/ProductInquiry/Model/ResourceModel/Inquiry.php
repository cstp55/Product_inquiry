<?php
namespace Chandan\ProductInquiry\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Inquiry extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('product_inquiry', 'inquiry_id');
    }
}
