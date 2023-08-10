<?php
// app/code/Chandan/ProductInquiry/Controller/Adminhtml/Inquiry/Index.php
namespace Chandan\ProductInquiry\Controller\Adminhtml\Inquiry;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Inquiries'));
        return $resultPage;
    }
}
