<?php
namespace MageModuleCrafters\CustomersCart\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Checkout\Model\Session as CheckoutSession;
use Psr\Log\LoggerInterface;

class CustomerService extends Template
{
    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    
    protected $cartIdMappingHelper;

    /**
     * Constructor
     *
     * @param Context $context
     * @param CheckoutSession $checkoutSession
     * @param LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        Context $context,
        CheckoutSession $checkoutSession,
        LoggerInterface $logger,
        \MageModuleCrafters\CustomersCart\Helper\CartIdMapping $cartIdMappingHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->checkoutSession = $checkoutSession;
        $this->cartIdMappingHelper = $cartIdMappingHelper;
        $this->logger = $logger;
    }

    /**
     * Check if the customer has a cart
     *
     * @return bool
     */
    public function hasCart()
    {
        return (bool) $this->checkoutSession->getQuoteId();
    }

    /**
     * Get abstracted Cart ID
     *
     * @return string
     */
    public function getCartId()
    {
        $quoteId = $this->checkoutSession->getQuoteId();
        if ($quoteId !== null) {
            $this->cartIdMappingHelper->saveCartIdMapping($quoteId);
            return md5($quoteId);
        }
    }

    /**
     * Get the total amount of the current cart.
     *
     * @return float
     */
    public function getCartTotal()
    {
        $cart = $this->checkoutSession->getQuote();
        return $cart ? $cart->getGrandTotal() : 0;
    }

    /**
     * Get details of items in the current cart.
     *
     * @return array
     */
    public function getCartItems()
    {
        $items = [];
        $cart = $this->checkoutSession->getQuote();
        if ($cart) {
            foreach ($cart->getAllVisibleItems() as $item) {
                $items[] = [
                    'name' => $item->getName(),
                    'sku'  => $item->getSku()
                ];
            }
        }
        return $items;
    }
}
