<?php
namespace MageModuleCrafters\CustomersCart\Block\Adminhtml\Cart;

use Magento\Framework\View\Element\Template;

class AdminCartSubmit extends Template
{
    protected $cartData = [];

    /**
     * Set cart data.
     *
     * @param array $cartData
     */
    public function setCartData(array $cartData)
    {
        $this->cartData = $cartData;
    }

    /**
     * Get cart data.
     *
     * @return array
     */
    public function getCartData()
    {
        return $this->cartData;
    }


}
