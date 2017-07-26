<?php

namespace Xigen\Bannermanager\Model\Resource\Slider;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Xigen\Bannermanager\Model\Slider',
            'Xigen\Bannermanager\Model\Resource\Slider'
        );
    }
}
