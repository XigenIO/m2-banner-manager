<?php

namespace Xigen\Bannermanager\Model\Resource;

class Slider extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    protected function _construct()
    {
        $this->_init(
            'xigen_bannermanager_Slider',
            'entity_id'
        );
    }

    /**
     * Save data
     *
     * @param \Magento\Framework\Object $Slider
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $Slider)
    {

        return parent::_afterSave($Slider);

    }//_afterSave

    /**
     * Save data
     *
     * @param \Magento\Framework\Object $Slider
     * @return $this
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $Slider)
    {

        return parent::_beforeSave($Slider);

    }//_beforeSave

  }//Slider
