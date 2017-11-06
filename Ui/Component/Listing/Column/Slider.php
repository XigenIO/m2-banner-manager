<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;

use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Slider extends \Xigen\Bannermanager\Ui\Component\Listing\Column\AbstractColumn
{

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Xigen\Bannermanager\Model\SliderFactory
     */
    protected $_sliderFactory;
    
    /**
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Xigen\Bannermanager\Model\SliderFactory $sliderFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Xigen\Bannermanager\Model\SliderFactory $sliderFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_storeManager = $storeManager;
        $this->_sliderFactory = $sliderFactory;
    }

    /**
     * prepare item.
     * @param array $item
     * @return array
     */
    protected function _prepareItem(array & $item)
    {
        $slider = $this->_sliderFactory->create()->load($item[$this->getData('name')]);

        if (isset($item[$this->getData('name')])) {
            if ($item[$this->getData('name')]) {
                $item[$this->getData('name')] = sprintf(
                    '%s',
                    $slider->getTitle()
                );
            } else {
                $item[$this->getData('name')] = '';
            }
        }
        return $item;
    }
}
