<?php
namespace MageModuleCrafters\CustomersCart\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Checkout\Model\Session as CheckoutSession;

class CustomerService extends Template
{
    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * Constructor
     *
     * @param Context $context
     * @param CheckoutSession $checkoutSession
     * @param array $data
     */
    public function __construct(
        Context $context,
        CheckoutSession $checkoutSession,
        array $data = []
    ) {
        $this->checkoutSession = $checkoutSession;
        parent::__construct($context, $data);
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
        // Implement your logic to retrieve and return an abstracted cart ID
        // For example, you could hash the actual cart ID
        return md5($this->checkoutSession->getQuoteId());
    }
}