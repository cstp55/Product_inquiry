<?php
// app/code/Chandan/ProductInquiry/Controller/Adminhtml/Inquiry/SendReply.php
namespace Chandan\ProductInquiry\Controller\Adminhtml\Inquiry;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class SendReply extends Action
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
        $resultPage->getConfig()->getTitle()->prepend(__('Send Reply Email'));
        return $resultPage;
    }
}
