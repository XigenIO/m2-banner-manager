<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Model;

class Slider extends \Magento\Framework\Model\AbstractModel
{
    const XML_CONFIG_BANNERSLIDER = 'bannermanager/general/enable_frontend';

    /**
     * Allow to show title or not.
     */
    const SHOW_TITLE_YES = 1;
    const SHOW_TITLE_NO = 2;

    /**
     * sort type of banners in a slider.
     */
    const SORT_TYPE_RANDOM = 1;
    const SORT_TYPE_ORDERLY = 2;


    const STYLESLIDE_STATIC_TEMPLATE = 1;
    const STYLESLIDE_BOOTSTRAP_TEMPLATE = 2;

    /**
     * banner collection factory.
     * @var \Xigen\Bannermanager\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $_bannerCollectionFactory;

    /**
     * 
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Xigen\Bannermanager\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     * @param \Xigen\Bannermanager\Model\ResourceModel\Slider $resource
     * @param \Xigen\Bannermanager\Model\ResourceModel\Slider\Collection $resourceCollection
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Xigen\Bannermanager\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        \Xigen\Bannermanager\Model\ResourceModel\Slider $resource,
        \Xigen\Bannermanager\Model\ResourceModel\Slider\Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
    }

    /**
     * get banner collection of slider.
     * @return \Xigen\Bannermanager\Model\ResourceModel\Banner\Collection
     */
    public function getOwnBanerCollection()
    {
        return $this->_bannerCollectionFactory->create()->addFieldToFilter('slider_id', $this->getId());
    }

}
