<?php

namespace Xigen\Bannermanager\Block\Adminhtml;

class Banners extends \Magento\Backend\Block\Widget\Grid\Container {

	protected function _construct(){

		$this->_controller = 'adminhtml_banners';
		$this->_blockGroup = 'Xigen_Bannermanager';
		$this->_headerText = "Banners";

		parent::_construct();

	}


}//Banners

?>
