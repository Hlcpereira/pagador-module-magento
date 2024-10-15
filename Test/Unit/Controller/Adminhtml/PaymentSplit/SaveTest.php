<?php

namespace Braspag\BraspagPagador\Test\Unit\Controller\Adminhtml\PaymentSplit;

use Braspag\BraspagPagador\Controller\Adminhtml\PaymentSplit\Save;
use Braspag\BraspagPagador\Gateway\Transaction\Boleto\Config\ConfigInterface as SplitPaymentBoletoConfig;
use Braspag\BraspagPagador\Gateway\Transaction\CreditCard\Config\ConfigInterface as SplitPaymentCreditCardConfig;
use Braspag\BraspagPagador\Gateway\Transaction\DebitCard\Config\ConfigInterface as SplitPaymentDebitCardConfig;
use Braspag\BraspagPagador\Gateway\Transaction\PaymentSplit\Command\TransactionPostCommand as SplitPaymentTransactionPostCommand;
use Braspag\BraspagPagador\Model\SplitManager;

class SaveTest extends \PHPUnit\Framework\TestCase
{
    private $controller;
    private $registry;
    private $resultForwardFactory;
    private $resultPageFactory;
    private $resultPageMock;
    private $resultPageConfigMock;
    private $resultPageTitleMock;
    private $resultRedirectFactory;
    private $resultRedirectMock;
    private $fileFactory;
    private $splitFactory;
    private $splitMock;
    private $orderRepository;
    private $orderModel;
    private $orderPayment;
    private $context;
    private $splitPaymentTransactionPostCommand;
    private $splitManager;
    private $configCreditCardInterface;
    private $configDebitCardInterface;
    private $configBoletoInterface;
    private $requestMock;
    private $messageManagerMock;

    public function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->registry = $this->createMock(\Magento\Framework\Registry::class);

        $this->resultPageMock = $this->createMock(\Magento\Backend\Model\View\Result\Page::class);

        $this->resultPageConfigMock = $this->createMock(\Magento\Framework\View\Page\Config::class);

        $this->resultPageTitleMock = $this->createMock(\Magento\Framework\View\Page\Title::class);

        $this->resultForwardFactory = $this->getMockBuilder('\Magento\Backend\Model\View\Result\ForwardFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->resultPageFactory = $this->getMockBuilder('\Magento\Framework\View\Result\PageFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->resultRedirectMock = $this->createMock(\Magento\Framework\Controller\Result\Redirect::class);

        $this->resultRedirectFactory = $this->getMockBuilder('\Magento\Framework\Controller\Result\RedirectFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->resultRedirectFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->resultRedirectMock);

        $this->fileFactory = $this->getMockBuilder('\Magento\Framework\App\Response\Http\FileFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->splitMock = $this->createMock(\Braspag\BraspagPagador\Model\Split::class);

        $this->splitFactory = $this->getMockBuilder('\Braspag\BraspagPagador\Model\SplitFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->orderRepository = $this->createMock(\Magento\Sales\Model\OrderRepository::class);

        $this->orderModel = $this->createMock(\Magento\Sales\Model\Order::class);

        $this->orderPayment = $this->createMock(\Magento\Sales\Model\Order\Payment::class);

        $this->context = $this->createMock(\Magento\Backend\App\Action\Context::class);
        $this->context->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->requestMock);

        $this->splitPaymentTransactionPostCommand = $this->createMock(SplitPaymentTransactionPostCommand::class);

        $this->splitManager = $this->createMock(SplitManager::class);

        $this->configCreditCardInterface = $this->createMock(SplitPaymentCreditCardConfig::class);

        $this->configDebitCardInterface = $this->createMock(SplitPaymentDebitCardConfig::class);

        $this->configBoletoInterface = $this->createMock(SplitPaymentBoletoConfig::class);

        $this->requestMock = $this->getMockBuilder('\Magento\Framework\App\RequestInterface')
            ->disableOriginalConstructor()
            ->setMethods(['getPost', 'getParam', 'getModuleName', 'setModuleName', 'getActionName', 'setActionName', 'setParams', 'getParams', 'getCookie', 'isSecure'])
            ->getMock();

        $this->messageManagerMock = $this->createMock(\Magento\Framework\Message\Manager::class);

        $this->controller = $objectManager->getObject(
            Save::class,
            [
                'registry' => $this->registry,
                'resultForwardFactory' => $this->resultForwardFactory,
                'resultPageFactory' => $this->resultPageFactory,
                'resultRedirectFactory' => $this->resultRedirectFactory,
                'fileFactory' => $this->fileFactory,
                'splitFactory' => $this->splitFactory,
                'orderRepository' => $this->orderRepository,
                'context' => $this->context,
                'splitPaymentTransactionPostCommand' => $this->splitPaymentTransactionPostCommand,
                'splitManager' => $this->splitManager,
                'configCreditCardInterface' => $this->configCreditCardInterface,
                'configDebitCardInterface' => $this->configDebitCardInterface,
                'configBoletoInterface' => $this->configBoletoInterface,
            ]
        );

        $objectManager->setBackwardCompatibleProperty($this->controller, '_request', $this->requestMock);
        $objectManager->setBackwardCompatibleProperty($this->controller, 'resultRedirectFactory', $this->resultRedirectFactory);
        $objectManager->setBackwardCompatibleProperty($this->controller, 'messageManager', $this->messageManagerMock);
    }

    public function testExecuteShouldNotSaveWhenInvalidPost()
    {
        $this->requestMock->expects($this->once())
            ->method('getPost')
            ->willReturn(false);

        $resultPage = $this->controller->execute();
    }

    public function testExecuteShouldReturnAnErrorMessageAfterAnException()
    {
        $post = ['id' => '123'];

        $this->requestMock->expects($this->once())
            ->method('getPost')
            ->willReturn($post);

        $this->splitFactory->expects($this->once())
            ->method('create')
            ->willThrowException(new \Exception('Error'));

        $this->messageManagerMock->expects($this->once())
            ->method('addError')
            ->willReturn(__('Error'));

        $resultPage = $this->controller->execute();
    }
}