<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'banner_id';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * added table
     * @var array
     */
    protected $_addedTable = [];

    /**
     * @var bool
     */
    protected $_isLoadSliderTitle = false;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\Timezone
     */
    protected $_stdTimezone;

    /**
     * @var \Xigen\Bannermanager\Model\Slider
     */
    protected $_slider;
    /**
     * _construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Xigen\Bannermanager\Model\Banner', 'Xigen\Bannermanager\Model\ResourceModel\Banner');
    }

    /**
     *
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Stdlib\DateTime\Timezone $stdTimezone
     * @param \Xigen\Bannermanager\Model\Slider $slider
     * @param type $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\Timezone $stdTimezone,
        \Xigen\Bannermanager\Model\Slider $slider,
        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_storeManager = $storeManager;
        $this->_stdTimezone = $stdTimezone;
        $this->_slider = $slider;
    }

    /**
     * @param $isLoadSliderTitle
     * @return $this
     */
    public function setIsLoadSliderTitle($isLoadSliderTitle)
    {
        $this->_isLoadSliderTitle = $isLoadSliderTitle;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLoadSliderTitle()
    {
        return $this->_isLoadSliderTitle;
    }

    /**
     * Before load action.
     *
     * @return $this
     */
    protected function _beforeLoad()
    {
        if ($this->isLoadSliderTitle()) {
            $this->joinSliderTitle();
        }

        return parent::_beforeLoad();
    }

    /**
     * join table to get Slider Title of Banner
     * @return $this
     */
    public function joinSliderTitle()
    {
        $this->getSelect()->joinLeft(
            ['sliderTable' => $this->getTable('xigen_bannermanager_slider')],
            'main_table.slider_id = sliderTable.slider_id',
            ['title' => 'sliderTable.title', 'slider_status' => 'sliderTable.status']
        );

        return $this;
    }

    /**
     * set order random by banner id
     *
     * @return $this
     */
    public function setOrderRandByBannerId()
    {
        $this->getSelect()->orderRand('main_table.banner_id');

        return $this;
    }

    /**
     * @param $firstCondition
     * @param $secondCondition
     * @param $type
     * @return string
     */
    protected function _implodeCondition($firstCondition, $secondCondition, $type)
    {
        return '(' . implode(') ' . $type . ' (', [$firstCondition, $secondCondition]) . ')';
    }

    /**
     * get read connnection.
     */
    public function getConnection()
    {
        return $this->getResource()->getConnection();
    }


    public function getBannerCollection($sliderId)
    {
        /** @var \Xigen\Bannermanager\Model\ResourceModel\Banner\Collection $bannerCollection */
        $bannerCollection = $this->addFieldToFilter('slider_id', $sliderId)
            ->addFieldToFilter('status', \Xigen\Bannermanager\Model\Status::STATUS_ENABLED)
            ->setOrder('order_banner', 'ASC');

        if ($this->_slider->getSortType() == \Xigen\Bannermanager\Model\Slider::SORT_TYPE_RANDOM) {
            $bannerCollection->setOrderRandByBannerId();
        }

        return $bannerCollection;
    }
}
