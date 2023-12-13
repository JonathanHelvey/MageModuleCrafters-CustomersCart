<?php
namespace MageModuleCrafters\CustomersCart\Controller\Adminhtml\Cart;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Quote\Api\CartRepositoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Registry;

class Submit extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'MageModuleCrafters_CustomersCart::submit';

    protected $resultPageFactory;
    protected $cartRepository;
    protected $logger;
    protected $coreRegistry; 

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        CartRepositoryInterface $cartRepository,
        LoggerInterface $logger,
        Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->cartRepository = $cartRepository;
        $this->logger = $logger;
        $this->coreRegistry = $coreRegistry;
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

            // Register cart data in Magento registry
            $this->coreRegistry->register('cartData', $cartData);

        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->messageManager->addError(__('Cart not found.'));
            $this->logger->error('Admin Cart Submit: Error loading cart.', ['exception' => $e->getMessage()]);
        } catch (\Exception $e) {
            // Catch any other exceptions that might occur
            $this->logger->critical('Admin Cart Submit: An unexpected error occurred.', ['exception' => $e->getMessage()]);
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
