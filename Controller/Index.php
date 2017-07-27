<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Controller;

abstract class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Slider factory.
     * @var \Xigen\Bannermanager\Model\SliderFactory
     */
    protected $_sliderFactory;

    /**
     * banner factory.
     * @var \Xigen\Bannermanager\Model\BannerFactory
     */
    protected $_bannerFactory;

    /**
     * A result that contains raw response - may be good for passing through files
     * returning result of downloads or some other binary contents.
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $_resultRawFactory;


    /**
     * logger.
     * @var \Magento\Framework\Logger\Monolog
     */
    protected $_monolog;

    /**
     * stdlib timezone.
     * @var \Magento\Framework\Stdlib\DateTime\Timezone
     */
    protected $_stdTimezone;

    /**
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Xigen\Bannermanager\Model\SliderFactory $sliderFactory
     * @param \Xigen\Bannermanager\Model\BannerFactory $bannerFactory
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     * @param \Magento\Framework\Logger\Monolog $monolog
     * @param \Magento\Framework\Stdlib\DateTime\Timezone $stdTimezone
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Xigen\Bannermanager\Model\SliderFactory $sliderFactory,
        \Xigen\Bannermanager\Model\BannerFactory $bannerFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\Logger\Monolog $monolog,
        \Magento\Framework\Stdlib\DateTime\Timezone $stdTimezone
    ) {
        parent::__construct($context);
        $this->_sliderFactory = $sliderFactory;
        $this->_bannerFactory = $bannerFactory;
        $this->_resultRawFactory = $resultRawFactory;
        $this->_monolog = $monolog;
        $this->_stdTimezone = $stdTimezone;
    }

}
