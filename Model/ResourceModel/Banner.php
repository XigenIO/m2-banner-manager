<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Model\ResourceModel;

class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('xigen_bannermanager_banner', 'banner_id');
    }
}
