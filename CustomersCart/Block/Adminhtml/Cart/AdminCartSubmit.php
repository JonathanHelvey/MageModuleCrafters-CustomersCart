<?php
namespace MageModuleCrafters\CustomersCart\Block\Adminhtml\Cart;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;

class AdminCartSubmit extends Template
{
    protected $_coreRegistry;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        Registry $coreRegistry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_coreRegistry = $coreRegistry;
    }

    /**
     * Get cart data from the registry.
     *
     * @return array|null
     */
    public function getCartData()
    {
        return $this->_coreRegistry->registry('cartData');
    }
}
