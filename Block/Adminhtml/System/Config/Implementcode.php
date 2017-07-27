<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Block\Adminhtml\System\Config;

class Implementcode extends \Magento\Config\Block\System\Config\Form\Field
{
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return '
        <div class="notices-wrapper">
                <div class="messages">
                    <div class="message" style="margin-top: 10px;">
                        <strong>'.__('Add code below to a template file.').'</strong><br />
                        $this->getLayout()->createBlock("Xigen\Bannermanager\Block\SliderItem")->setSliderId(your_slider_id)->toHtml();
                    </div>
                    <div class="message" style="margin-top: 10px;">
                        <strong>'.__('You can put a slider on a cms page. Below is an example which we put a slider with slider_id is your_slider_id on a cms page.').'</strong><br />
                        {{block class="Xigen\Bannermanager\Block\SliderItem" name="bannermanager.slidercustom" slider_id="your_slider_id"}}
                    </div>
                    <div class="message" style="margin-top: 10px;">
                        <strong>'.__('Please copy and paste the code below on one of xml layout files where you want to show the banner. Please replace the your_slider_id variable with your own slider Id.').'</strong><br />
                        &lt;block class="Xigen\Bannermanager\Block\SliderItem"&gt;<br />
                           &nbsp;&nbsp;&lt;action method="setSliderId"&gt;<br />
                               &nbsp;&nbsp;&nbsp;&nbsp;&lt;argument name="sliderId" xsi:type="string"&gt;your_slider_id&lt;/argument&gt;<br />
                           &nbsp;&nbsp;&lt;/action&gt;<br />
                       &lt;/block>
                    </div>
                </div>
        </div>';
    }
}
