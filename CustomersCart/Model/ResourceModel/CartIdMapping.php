<?php
namespace MageModuleCrafters\CustomersCart\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CartIdMapping extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('mage_module_crafters_cart_mapping', 'hash');
    }
}
