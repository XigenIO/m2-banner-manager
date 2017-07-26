<?php

	namespace Xigen\Bannermanager\Block;

	/**
	* Main Banner Block Class
	*/
	class Page extends \Magento\Framework\View\Element\Template {

		protected $_banner_collection;


		public function __construct(
			\Magento\Framework\View\Element\Template\Context $context,
			\Xigen\Bannermanager\Model\Resource\Banner\Collection $banner_collection
		){

			$this->_banner_collection = $banner_collection;
			parent::__construct($context);

		}


		public function testMe(){

			return __('Test Me Here Now!!!');

		}//testMe

		public function getBlockData(){

      $banners = $this->_banner_collection->addFieldToFilter('is_active', 1);
      return $banners;

		}//getBlockData


	}
