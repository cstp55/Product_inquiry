<?php 
namespace Chandan\ProductInquiry\Model;

use Magento\Framework\Model\AbstractModel;
use Chandan\ProductInquiry\Api\InquiryManagementInterface;

class Inquiry  extends AbstractModel  implements InquiryManagementInterface
{

        /**
     * No route page id.
     */
    public const NOROUTE_ENTITY_ID = 'no-route';

    public const CACHE_TAG = 'product_inquiry';

    /**
     * @var string
     */
    protected $_cacheTag = 'product_inquiry';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'product_inquiry';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(
            \Chandan\ProductInquiry\Model\ResourceModel\Inquiry::class
        );
    }

    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRouteInquiry();
        }

        return parent::load($id, $field);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    public function noRouteInquiry()
    {
        return $this->load(self::NOROUTE_ENTITY_ID, $this->getIdFieldName());
    }
    public function setInquiryId($enquiry_id)
    {
        return $this->setData('inquiry_id', $enquiry_id);
    }
    
    public function getInquiryId()
    {
        return $this->getData('inquiry_id');
    }

    public function setProductId($product_id)
    {
        return $this->setData('product_id', $product_id);
    }
    
    public function getproductId()
    {
        return $this->getData('product_id');
    }
    /**
     * Set Inquiry Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    /**
     * Get Inquiry Name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * Set Inquiry Email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        return $this->setData('email', $email);
    }

    /**
     * Get Inquiry Email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getData('email');
    }

    /**
     * Set Inquiry Subject
     *
     * @param string $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        return $this->setData('subject', $subject);
    }

    /**
     * Get Inquiry Subject
     *
     * @return string|null
     */
    public function getSubject()
    {
        return $this->getData('subject');
    }

    /**
     * Set Inquiry Message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        return $this->setData('message', $message);
    }

    /**
     * Get Inquiry Message
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getData('message');
    }
}
