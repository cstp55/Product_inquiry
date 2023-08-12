<?php
// app/code/Chandan/ProductInquiry/Controller/Adminhtml/Inquiry/SendReply.php
namespace Chandan\ProductInquiry\Controller\Adminhtml\Inquiry;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Area;
use Magento\Framework\Controller\ResultFactory;
use Company\ProductInquiry\Model\InquiryFactory;

class SendReply extends Action
{
    protected $resultPageFactory;
    protected $transportBuilder;
    protected $scopeConfig;
    protected $inlineTranslation;
    protected $inquiryFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        StateInterface $inlineTranslation,
        InquiryFactory $inquiryFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->inlineTranslation = $inlineTranslation;
        $this->inquiryFactory = $inquiryFactory;
    }

    public function execute()
    {
        $inquiryId = $this->getRequest()->getParam('id');
        $inquiry = $this->inquiryFactory->create()->load($inquiryId);

        if (!$inquiry->getId()) {
            $this->messageManager->addError(__('Inquiry not found.'));
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        $this->inlineTranslation->suspend();
        try {
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('product_inquiry_admin_notification')
                ->setTemplateOptions([
                    'area' => Area::AREA_ADMINHTML,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ])
                ->setTemplateVars([
                    'subject' => $this->getRequest()->getPost('subject'),
                    'message' => $this->getRequest()->getPost('message'),
                    'name' => $inquiry->getCustomerName(),
                ])
                ->setFrom('general') // Set your sender identity here
                ->addTo($inquiry->getEmail())
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();

            $this->messageManager->addSuccess(__('Reply email sent successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error sending reply email: %1', $e->getMessage()));
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
}

