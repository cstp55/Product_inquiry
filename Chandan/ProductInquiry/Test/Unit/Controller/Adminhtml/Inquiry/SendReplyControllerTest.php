<?php
namespace Chandan\ProductInquiry\Test\Unit\Controller\Adminhtml\Inquiry;

use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Company\ProductInquiry\Controller\Adminhtml\Inquiry\SendReply;
use Company\ProductInquiry\Model\InquiryFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;

class SendReplyControllerTest extends TestCase
{
    protected $objectManager;
    protected $contextMock;
    protected $pageFactoryMock;
    protected $inquiryFactoryMock;
    protected $resultFactoryMock;
    protected $inlineTranslationMock;
    protected $transportBuilderMock;
    protected $scopeConfigMock;

    protected function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);

        $this->contextMock = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pageFactoryMock = $this->getMockBuilder(PageFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->inquiryFactoryMock = $this->getMockBuilder(InquiryFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultFactoryMock = $this->getMockBuilder(ResultFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->inlineTranslationMock = $this->getMockBuilder(StateInterface::class)
            ->getMock();

        $this->transportBuilderMock = $this->getMockBuilder(TransportBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->scopeConfigMock = $this->getMockBuilder(ScopeConfigInterface::class)
            ->getMock();
    }

    public function testExecute()
    {
        $inquiryId = 123; // Replace with your test inquiry ID
        $subject = "Test the inquiry";
        $message = "tesing this case";

        $inquiryMock = $this->getMockBuilder(\Company\ProductInquiry\Model\Inquiry::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $inquiryMock->method('getId')
            ->willReturn($inquiryId);

        $this->inquiryFactoryMock->method('create')
            ->willReturn($inquiryMock);

        $transportMock = $this->getMockBuilder(\Magento\Framework\Mail\TransportInterface::class)
            ->getMock();

        $this->transportBuilderMock->method('setTemplateIdentifier')
            ->willReturnSelf();

        $this->transportBuilderMock->method('setTemplateOptions')
            ->willReturnSelf();

        $this->transportBuilderMock->method('setTemplateVars')
            ->willReturnSelf();

        $this->transportBuilderMock->method('setFrom')
            ->willReturnSelf();

        $this->transportBuilderMock->method('addTo')
            ->willReturnSelf();

        $this->transportBuilderMock->method('getTransport')
            ->willReturn($transportMock);

        $this->inlineTranslationMock->expects($this->once())
            ->method('suspend');

        $this->inlineTranslationMock->expects($this->once())
            ->method('resume');

        $controller = new SendReply(
            $this->contextMock,
            $this->pageFactoryMock,
            $this->transportBuilderMock,
            $this->scopeConfigMock,
            $this->inlineTranslationMock,
            $this->inquiryFactoryMock
        );

        $result = $controller->execute();

        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $result);
    }
}

