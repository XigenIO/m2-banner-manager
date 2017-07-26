<?php
namespace Xigen\Bannermanager\Model\Config\Source;




class Categories implements \Magento\Framework\Option\ArrayInterface
{
    protected $_entityType;
    protected $_store;

    public function __construct(
        \Magento\Store\Model\Store $store,
        \Magento\Eav\Model\Entity\Type $entityType
    ) {
        $this->_store = $store;
        $this->_entityType = $entityType;
    }

    public function toOptionArray()
    {
        $category_ids = [];


        return $result;
    }

}
