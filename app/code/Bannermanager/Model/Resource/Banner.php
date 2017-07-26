<?php

namespace Xigen\Bannermanager\Model\Resource;

class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    protected function _construct()
    {
        $this->_init(
            'xigen_bannermanager_banner',
            'entity_id'
        );
    }

    /**
     * Save data
     *
     * @param \Magento\Framework\Object $banner
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $banner)
    {

        return parent::_afterSave($banner);

    }//_afterSave

    /**
     * Save data
     *
     * @param \Magento\Framework\Object $banner
     * @return $this
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $banner)
    {

        return parent::_beforeSave($banner);

    }//_beforeSave

  }//Banner
