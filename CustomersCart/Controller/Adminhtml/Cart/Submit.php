<?php
namespace MageModuleCrafters\CustomersCart\Controller\Adminhtml\Cart;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Quote\Api\CartRepositoryInterface;
use Psr\Log\LoggerInterface;

class Submit extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'MageModuleCrafters_CustomersCart::submit';

    protected $resultPageFactory;
    protected $cartRepository;
    protected $logger;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        CartRepositoryInterface $cartRepository,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->cartRepository = $cartRepository;
        $this->logger = $logger;
    }

    public function execute()
    {
        $cartId = $this->getRequest()->getParam('cart_id');
        $this->logger->info("Admin Cart Submit: Loading cart with ID: {$cartId}");

        try {
            $quote = $this->cartRepository->get($cartId);
            $this->logger->info("Admin Cart Submit: Cart loaded successfully.");

            $cartData = [
                'total' => $quote->getGrandTotal(),
                'items' => []
            ];

            foreach ($quote->getAllVisibleItems() as $item) {
                $cartData['items'][] = [
                    'name' => $item->getName(),
                    'sku'  => $item->getSku(),
                ];
            }

            $this->logger->info("Admin Cart Submit: Cart data prepared.", ['cartData' => $cartData]);

            $block = $this->_view->getLayout()->getBlock('customerscart_cart_submit');
            if ($block) {
                $block->setData('cartData', $cartData);
                $this->logger->info("Admin Cart Submit: Cart data set to block.");
            } else {
                $this->logger->error("Admin Cart Submit: Block 'customerscart_cart_submit' not found.");
            }
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->messageManager->addError(__('Cart not found.'));
            $this->logger->error('Admin Cart Submit: Error loading cart.', ['exception' => $e->getMessage()]);
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Cart Details'));

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
