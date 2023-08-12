<?php

namespace Chandan\ProductInquiry\Test\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;
use Company\ProductInquiry\Controller\ProductInquiry;
use Company\ProductInquiry\Model\InquiryFactory;

class ProductInquiryControllerTest extends TestCase
{
    protected $objectManager;
    protected $resultFactoryMock;
    protected $requestMock;
    protected $messageManagerMock;
    protected $inquiryFactoryMock;

    protected function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);

        $this->resultFactoryMock = $this->getMockBuilder(ResultFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestMock = $this->getMockForAbstractClass(RequestInterface::class);

        $this->messageManagerMock = $this->getMockForAbstractClass(ManagerInterface::class);

        $this->inquiryFactoryMock = $this->getMockBuilder(InquiryFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testExecute()
    {
        $postData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'subject' => 'Product Inquiry',
            'message' => 'I have a question about this product.',
        ];

        $controller = new ProductInquiry(
            $this->resultFactoryMock,
            $this->requestMock,
            $this->messageManagerMock,
            $this->inquiryFactoryMock
        );

        $this->requestMock->expects($this->once())
            ->method('getPostValue')
            ->willReturn($postData);

        $this->inquiryFactoryMock->expects($this->once())
            ->method('create')
            ->willReturnSelf();

        $result = $controller->execute();

        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $result);
    }
}

