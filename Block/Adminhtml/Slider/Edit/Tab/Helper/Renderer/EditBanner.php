<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Block\Adminhtml\Slider\Edit\Tab\Helper\Renderer;

class EditBanner extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
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
        return '<a href="' . $this->getUrl('*/banner/edit', ['_current' => FALSE, 'banner_id' => $row->getId()]) . '" target="_blank">Edit</a> ';
    }
}
