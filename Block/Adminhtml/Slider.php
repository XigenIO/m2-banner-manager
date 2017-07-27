<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Block\Adminhtml;

class Slider extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_slider';
        $this->_blockGroup = 'Xigen_Bannermanager';
        $this->_headerText = __('Sliders');
        $this->_addButtonLabel = __('Add New Group');
        parent::_construct();
    }
}
