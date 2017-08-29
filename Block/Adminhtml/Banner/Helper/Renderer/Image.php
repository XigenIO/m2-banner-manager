<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Block\Adminhtml\Banner\Helper\Renderer;

class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * Store manager.
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * banner factory.
     * @var \Xigen\Bannermanager\Model\BannerFactory
     */
    protected $_bannerFactory;

    /**
     * Constructor
     * @param \Magento\Backend\Block\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Xigen\Bannermanager\Model\BannerFactory $bannerFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Xigen\Bannermanager\Model\BannerFactory $bannerFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
        $this->_bannerFactory = $bannerFactory;
    }

    /**
     * Render action.
     * @param \Magento\Framework\DataObject $row
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        $storeViewId = $this->getRequest()->getParam('store');
        $banner = $this->_bannerFactory->create()->load($row->getId());
        $srcImage = $this->_storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . $banner->getImage();

        return '<image width="150" height="50" src ="'.$srcImage.'" alt="'.$banner->getImage().'" >';
    }
}
