<?php
namespace MageModuleCrafters\CustomersCart\Block\Adminhtml\Cart;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class AdminCartView extends Template
{
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }
}
