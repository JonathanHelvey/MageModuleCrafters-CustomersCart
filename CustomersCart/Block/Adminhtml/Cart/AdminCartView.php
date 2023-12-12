<?php
namespace MageModuleCrafters\CustomersCart\Block\Adminhtml\Cart;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class AdminCartView extends Template
{
    protected $data = [];

    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function setData($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = $key;
        } else {
            $this->data[$key] = $value;
        }
    }

    public function getData($key = '', $index = null)
    {
        if ('' === $key) {
            return $this->data;
        }

        return $this->data[$key] ?? null;
    }
}
