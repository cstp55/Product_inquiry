<?php
// app/code/Chandan/ProductInquiry/Controller/Product/Save.php
namespace Chandan\ProductInquiry\Controller\Product;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class Save extends Action
{
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $postData = $this->getRequest()->getPostValue();

        try {
            $inquiry = $this->inquiryFactory->create();
            $inquiry->setProductId($postData['product_id']);
            $inquiry->setName($postData['name']);
            $inquiry->setEmail($postData['email']);
            $inquiry->setSubject($postData['subject']);
            $inquiry->setMessage($postData['message']);
            $inquiry->save();
    
            // Log a success message
            $this->logger->info('Inquiry saved successfully.');
            //send mail after save the inquiry to product
            
            $result->setData(['success' => true, 'message' => __('Inquiry submitted successfully.')]);
        } catch (\Exception $e) {
            // Log an error message
            $this->logger->error('An error occurred while submitting the inquiry: ' . $e->getMessage());
    
            $result->setData(['success' => false, 'message' => __('An error occurred while submitting the inquiry.')]);
        }
        return $result;
    }
}
