<?php
namespace MageModuleCrafters\CustomersCart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use MageModuleCrafters\CustomersCart\Model\CartIdMappingFactory;
use MageModuleCrafters\CustomersCart\Model\ResourceModel\CartIdMapping as CartIdMappingResource;

class CartIdMapping extends AbstractHelper
{
    /**
     * @var CartIdMappingFactory
     */
    protected $cartIdMappingFactory;

    /**
     * @var CartIdMappingResource
     */
    protected $resourceModel;

    public function __construct(
        Context $context,
        CartIdMappingFactory $cartIdMappingFactory,
        CartIdMappingResource $resourceModel
    ) {
        parent::__construct($context);
        $this->cartIdMappingFactory = $cartIdMappingFactory;
        $this->resourceModel = $resourceModel;
    }

  public function saveCartIdMapping($quoteId) {
      $hash = md5($quoteId);
  }

  public function saveMapping($quoteId, $hash) {
      $mapping = $this->cartIdMappingFactory->create();
      $mapping->setData('hash', $hash);
      $mapping->setData('quote_id', $quoteId);
      $this->resourceModel->save($mapping);
  }

  public function getQuoteIdByHash($hash) {
      $mapping = $this->cartIdMappingFactory->create();
      $this->resourceModel->load($mapping, $hash);
      return $mapping->getQuoteId();
  }
}
