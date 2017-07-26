<?php

namespace Xigen\Bannermanager\Block\Adminhtml;

class Sliders extends \Magento\Backend\Block\Widget\Grid\Container {

	protected function _construct(){

		$this->_controller = 'adminhtml_sliders';
		$this->_blockGroup = 'Xigen_Bannermanager';
		$this->_headerText = "Sliders";

		parent::_construct();

	}


}//Sliders

?>
