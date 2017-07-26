<?php

namespace Xigen\Bannermanager\Model\Resource\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Xigen\Bannermanager\Model\Banner',
            'Xigen\Bannermanager\Model\Resource\Banner'
        );
    }
}
