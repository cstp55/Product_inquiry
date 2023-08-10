<?php
// app/code/Chandan/ProductInquiry/Block/Product/Inquiry.php
namespace Chandan\ProductInquiry\Block\Product;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Customer\Model\Session;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Inquiry extends Template
{
    protected $formKeyValidator;
    protected $customerSession;
    protected $productRepository;

    public function __construct(
        Template\Context $context,
        Validator $formKeyValidator,
        Session $customerSession,
        ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->formKeyValidator = $formKeyValidator;
        $this->customerSession = $customerSession;
        $this->productRepository = $productRepository;
    }

    public function isCustomerLoggedIn()
    {
        return $this->customerSession->isLoggedIn();
    }

    public function getFormAction()
    {
        return $this->getUrl('productinquiry/inquiry/save', ['_secure' => true]);
    }

    
}
