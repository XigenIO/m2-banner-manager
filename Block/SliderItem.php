<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Block;

use Xigen\Bannermanager\Model\Slider as SliderModel;
use Xigen\Bannermanager\Model\Status;

class SliderItem extends \Magento\Framework\View\Element\Template
{

    /**
     * template for custom slider
     */
    const STYLESLIDE_STATIC_TEMPLATE = 'Xigen_Bannermanager::slider/static.phtml';
    const STYLESLIDE_BOOTSTRAP_TEMPLATE = 'Xigen_Bannermanager::slider/bootstrap.phtml';

    /**
     * Date conversion model.
     *
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_stdlibDateTime;

    /**
     * slider factory.
     *
     * @var \Xigen\Bannermanager\Model\SliderFactory
     */
    protected $_sliderFactory;

    /**
     * slider model.
     *
     * @var \Xigen\Bannermanager\Model\Slider
     */
    protected $_slider;

    /**
     * slider id.
     *
     * @var int
     */
    protected $_sliderId;

    /**
     * banner slider helper.
     *
     * @var \Xigen\Bannermanager\Helper\Data
     */
    protected $_bannermanagerHelper;

    /**
     * @var \Xigen\Bannermanager\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $_bannerCollectionFactory;

    /**
     * scope config.
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * stdlib timezone.
     *
     * @var \Magento\Framework\Stdlib\DateTime\Timezone
     */
    protected $_stdTimezone;

    /**
     * Constructor
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Xigen\Bannermanager\Model\ResourceModel\Banner\Collection $bannerCollectionFactory
     * @param \Xigen\Bannermanager\Model\SliderFactory $sliderFactory
     * @param SliderModel $slider
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $stdlibDateTime
     * @param \Xigen\Bannermanager\Helper\Data $bannermanagerHelper
     * @param \Magento\Framework\Stdlib\DateTime\Timezone $_stdTimezone
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Xigen\Bannermanager\Model\ResourceModel\Banner\Collection $bannerCollectionFactory,
        \Xigen\Bannermanager\Model\SliderFactory $sliderFactory,
        SliderModel $slider,
        \Magento\Framework\Stdlib\DateTime\DateTime $stdlibDateTime,
        \Xigen\Bannermanager\Helper\Data $bannermanagerHelper,
        \Magento\Framework\Stdlib\DateTime\Timezone $_stdTimezone,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_sliderFactory = $sliderFactory;
        $this->_slider = $slider;
        $this->_stdlibDateTime = $stdlibDateTime;
        $this->_bannermanagerHelper = $bannermanagerHelper;
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_stdTimezone = $_stdTimezone;
    }

    /**
     * @return
     */
    protected function _toHtml()
    {
        $store = $this->_storeManager->getStore()->getId();

        $configEnable = $this->_scopeConfig->getValue(
            SliderModel::XML_CONFIG_BANNERSLIDER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
        
        $show = true;
        if($this->_slider->getStoreId() > 0) {
            if($store != $this->_slider->getStoreId()) {
                $show = false;
            }
        }

        if (!$configEnable
            || !$show
            || $this->_slider->getStatus() === Status::STATUS_DISABLED
            || !$this->_slider->getId()
            || !$this->getBannerCollection()->getSize()) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * set slider Id and set template.
     *
     * @param int $sliderId
     */
    public function setSliderId($sliderId)
    {
        $this->_sliderId = $sliderId;

        $slider = $this->_sliderFactory->create()->load($this->_sliderId);
        if ($slider->getId()) {
            $this->setSlider($slider);
            $this->setStyleSlideTemplate($slider->getStyleSlide());
        }

        return $this;
    }

    /**
     * set style slide template.
     *
     * @param int $styleSlideId
     *
     * @return string
     */
    public function setStyleSlideTemplate($styleSlideId)
    {
        switch ($styleSlideId) {
            case 2:
                $this->setTemplate(self::STYLESLIDE_BOOTSTRAP_TEMPLATE);
                break;
            case 1:
            default:
                $this->setTemplate(self::STYLESLIDE_STATIC_TEMPLATE);
                break;
        }
    }

    public function isShowTitle()
    {
        return $this->_slider->getShowTitle() == SliderModel::SHOW_TITLE_YES ? TRUE : FALSE;
    }

    /**
     * get banner collection of slider.
     *
     * @return \Xigen\Bannermanager\Model\ResourceModel\Banner\Collection
     */
    public function getBannerCollection()
    {
        $sliderId = $this->_slider->getId();
        return $this->_bannerCollectionFactory->getBannerCollection($sliderId);
    }

    /**
     * get first banner.
     *
     * @return \Xigen\Bannermanager\Model\Banner
     */
    public function getFirstBannerItem()
    {
        return $this->getBannerCollection()
            ->setPageSize(1)
            ->setCurPage(1)
            ->getFirstItem();
    }

    /**
     * get position note.
     *
     * @return string
     */
    public function getPositionNote()
    {
        return $this->_slider->getPositionNoteCode();
    }

    /**
     * set slider model.
     *
     * @param \Xigen\Bannermanager\Model\Slider $slider 
     */
    public function setSlider(\Xigen\Bannermanager\Model\Slider $slider)
    {
        $this->_slider = $slider;

        return $this;
    }

    /**
     * @return \Xigen\Bannermanager\Model\Slider
     */
    public function getSlider()
    {
        return $this->_slider;
    }

    /**
     * get banner image url.
     *
     * @param \Xigen\Bannermanager\Model\Banner $banner
     *
     * @return string
     */
    public function getBannerImageUrl(\Xigen\Bannermanager\Model\Banner $banner)
    {
        return $this->_bannermanagerHelper->getBaseUrlMedia($banner->getImage());
    }

}
