<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Model;

class Banner extends \Magento\Framework\Model\AbstractModel
{
    const BASE_MEDIA_PATH = 'xigen/bannermanager/images';

    const BANNER_TARGET_SELF = 0;
    const BANNER_TARGET_PARENT = 1;
    const BANNER_TARGET_BLANK = 2;

    /**
     * slider collection factory
     * @var \Xigen\Bannermanager\Model\ResourceModel\Slider\CollectionFactory
     */
    protected $_sliderCollectionFactory;

    /**
     * banner factory
     * @var \Xigen\Bannermanager\Model\BannerFactory
     */
    protected $_bannerFactory;

    /**
     * [$_formFieldHtmlIdPrefix description].
     * @var string
     */
    protected $_formFieldHtmlIdPrefix = 'page_';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * logger.
     * @var \Magento\Framework\Logger\Monolog
     */
    protected $_monolog;

    /**
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Xigen\Bannermanager\Model\ResourceModel\Banner $resource
     * @param \Xigen\Bannermanager\Model\ResourceModel\Banner\Collection $resourceCollection
     * @param \Xigen\Bannermanager\Model\BannerFactory $bannerFactory
     * @param \Xigen\Bannermanager\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Logger\Monolog $monolog
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Xigen\Bannermanager\Model\ResourceModel\Banner $resource,
        \Xigen\Bannermanager\Model\ResourceModel\Banner\Collection $resourceCollection,
        \Xigen\Bannermanager\Model\BannerFactory $bannerFactory,
        \Xigen\Bannermanager\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Logger\Monolog $monolog
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_bannerFactory = $bannerFactory;
        $this->_storeManager = $storeManager;
        $this->_sliderCollectionFactory = $sliderCollectionFactory;

        $this->_monolog = $monolog;

        if ($storeViewId = $this->_storeManager->getStore()->getId()) {
            $this->_storeViewId = $storeViewId;
        }
    }

    /**
     * get form field html id prefix.
     * @return string
     */
    public function getFormFieldHtmlIdPrefix()
    {
        return $this->_formFieldHtmlIdPrefix;
    }

    /**
     * get availabe slide.
     * @return []
     */
    public function getAvailableSlides()
    {
        $option[] = [
            'value' => '',
            'label' => __('-------- Please select a slider --------'),
        ];

        $sliderCollection = $this->_sliderCollectionFactory->create();
        foreach ($sliderCollection as $slider) {
            $option[] = [
                'value' => $slider->getId(),
                'label' => $slider->getTitle(),
            ];
        }

        return $option;
    }

    /**
     * get store attributes.
     * @return array
     */
    public function getStoreAttributes()
    {
        return array(
            'name',
            'status',
            'click_url',
            'target',
            'image_alt',
            'image',
            'caption'
        );
    }

    /**
     * get target value.
     * @return string
     */
    public function getTargetValue()
    {
        switch ($this->getTarget()) {
            case self::BANNER_TARGET_SELF:
                return '_self';
            case self::BANNER_TARGET_PARENT:
                return '_parent';

            default:
                return '_blank';
        }
    }
}
