<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Block\Adminhtml\Slider\Edit\Tab;

use Xigen\Bannermanager\Model\Status;

class Banners extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * banner factory.
     * @var \Xigen\Bannermanager\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $_bannerCollectionFactory;

    /**
     * Constructor
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Xigen\Bannermanager\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Xigen\Bannermanager\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        array $data = []
    ) {
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * _construct
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('bannerGrid');
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('id')) {
            $this->setDefaultFilter(array('in_banner' => 1));
        }
    }

    /**
     * prepare collection
     */
    protected function _prepareCollection()
    {
        /** @var \Xigen\Bannermanager\Model\ResourceModel\Banner\Collection $collection */
        $collection = $this->_bannerCollectionFactory->create();
        $collection->setIsLoadSliderTitle(TRUE);

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_banner',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_banner',
                'align' => 'center',
                'index' => 'banner_id',
                'values' => $this->_getSelectedBanners(),
            ]
        );

        $this->addColumn(
            'banner_id',
            [
                'header' => __('Banner ID'),
                'type' => 'number',
                'index' => 'banner_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'filter' => false,
                'width' => '50px',
                'renderer' => 'Xigen\Bannermanager\Block\Adminhtml\Banner\Helper\Renderer\Image',
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Slider'),
                'index' => 'title',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'filter_index' => 'main_table.status',
                'options' => Status::getAvailableStatuses(),
            ]
        );
        
        $this->addColumn(
            'order_banner_slider',
            [
                'header' => __('Order'),
                'name' => 'order_banner_slider',
                'index' => 'order_banner_slider',
                'width' => '50px',
                'editable' => true,
            ]
        );

        $this->addColumn(
            'edit',
            [
                'header' => __('Edit'),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
                'renderer' => 'Xigen\Bannermanager\Block\Adminhtml\Slider\Edit\Tab\Helper\Renderer\EditBanner',
            ]
        );

     

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/bannersgrid', ['_current' => true]);
    }

    /**
     * get row url
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return '';
    }

    public function getSelectedSliderBanners()
    {
        $sliderId = $this->getRequest()->getParam('slider_id');
        if (!isset($sliderId)) {
            return [];
        }
        $bannerCollection = $this->_bannerCollectionFactory->create();
        $bannerCollection->addFieldToFilter('slider_id', $sliderId);

        $bannerIds = [];
        foreach ($bannerCollection as $banner) {
            $bannerIds[$banner->getId()] = ['order_banner_slider' => $banner->getOrderBanner()];
        }

        return $bannerIds;
    }

    protected function _getSelectedBanners()
    {
        $banners = $this->getRequest()->getParam('banner');
        if (!is_array($banners)) {
            $banners = array_keys($this->getSelectedSliderBanners());
        }

        return $banners;
    }

    /**
     * Prepare label for tab.
     * @return string
     */
    public function getTabLabel()
    {
        return __('Banners');
    }

    /**
     * Prepare title for tab.
     * @return string
     */
    public function getTabTitle()
    {
        return __('Banners');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return true;
    }
}
