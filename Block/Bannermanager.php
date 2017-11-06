<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Block;

use Xigen\Bannermanager\Model\Slider as SliderModel;
use Xigen\Bannermanager\Model\Status;

class Bannermanager extends \Magento\Framework\View\Element\Template
{
    /**
     * banner slider template
     * @var string
     */
    protected $_template = 'Xigen_Bannermanager::bannermanager.phtml';

    /**
     * Registry object.
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * slider collecion factory.
     * @var \Xigen\Bannermanager\Model\ResourceModel\Slider\CollectionFactory
     */
    protected $_sliderCollectionFactory;

    /**
     * Constructor
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Xigen\Bannermanager\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory
     * @param \Xigen\Bannermanager\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Xigen\Bannermanager\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory,
        \Xigen\Bannermanager\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_coreRegistry = $coreRegistry;
        $this->_sliderCollectionFactory = $sliderCollectionFactory;
    }

    /**
     * @return
     */
    protected function _toHtml()
    {
        $store = $this->_storeManager->getStore()->getId();

        if ($this->_scopeConfig->getValue(
            SliderModel::XML_CONFIG_BANNERSLIDER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        )
        ) {
            return parent::_toHtml();
        }

        return '';
    }

    /**
     * add child block slider.
     *
     * @param \Xigen\Bannermanager\Model\ResourceModel\Slider\Collection $sliderCollection
     *
     * @return \Xigen\Bannermanager\Block\Bannermanager
     */
    public function appendChildBlockSliders(
        \Xigen\Bannermanager\Model\ResourceModel\Slider\Collection $sliderCollection
    ) {
        foreach ($sliderCollection as $slider) {
            $this->append(
                $this->getLayout()->createBlock(
                    'Xigen\Bannermanager\Block\SliderItem'
                )->setSliderId($slider->getId())
            );
        }

        return $this;
    }

    /**
     * set position for banner slider.
     *
     * @param mixed string|array $position
     */
    public function setPosition($position)
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('position', $position)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);
        $this->appendChildBlockSliders($sliderCollection);

        return $this;
    }

    /**
     * set position for banner slider.
     *
     * @param mixed string|array $position
     */
    public function setCategoryPosition($position)
    {
        $sliderCollection = $this->_sliderCollectionFactory
            ->create()
            ->addFieldToFilter('position', $position)
            ->addFieldToFilter('status', Status::STATUS_ENABLED);
        $category = $this->_coreRegistry->registry('current_category');
        if (!is_null($category)) {
            $categoryPathIds = $category->getPathIds();
    
            foreach ($sliderCollection as $slider) {
                $sliderCategoryIds = explode(',', $slider->getCategoryIds());
                if (count(array_intersect($categoryPathIds, $sliderCategoryIds)) > 0) {
                    $this->append(
                        $this->getLayout()->createBlock(
                            'Xigen\Bannermanager\Block\SliderItem'
                        )->setSliderId($slider->getId())
                    );
                }
            }
        }
        return $this;
    }
}
