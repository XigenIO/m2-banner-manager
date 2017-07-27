<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Model\Config\Source;

class Slider implements \Magento\Framework\Option\ArrayInterface
{
    protected $sliderFactory;

    public function __construct(
        \Xigen\Bannermanager\Model\SliderFactory $sliderFactory
    ) {
        $this->sliderFactory = $sliderFactory;
    }

    public function getSliders()
    {
        $sliderModel = $this->sliderFactory->create();
        return $sliderModel->getCollection()->getData();
    }

    public function toOptionArray()
    {
        $sliders = [];
        foreach ($this->getSliders() as $slider) {
            array_push($sliders,[
                'value' => $slider['slider_id'],
                'label' => $slider['title']
            ]);
        }
        return $sliders;
    }
}