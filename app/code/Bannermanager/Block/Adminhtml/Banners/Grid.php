<?php

namespace Xigen\Bannermanager\Block\Adminhtml\Banners;

use Magento\Backend\Block\Widget\Grid as WidgetGrid;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended {

  /**
   * @var \Xigen\Bannermanager\Model\Resource\Banner\Collection
   */
   protected $_bannerCollection;

   /**
    * @var \Xigen\Bannermanager\Helper\Admin
    */
   protected $_adminHelper;

   public function __construct(
     \Magento\Backend\Block\Template\Context $context,
     \Magento\Backend\Helper\Data $backendHelper,
     \Xigen\Bannermanager\Model\Resource\Banner\Collection $banner_collection,
     \Xigen\Bannermanager\Helper\Admin $adminHelper,
     array $data = []
   ){

     $this->_bannerCollection = $banner_collection;
     $this->_adminHelper = $adminHelper;
     parent::__construct($context, $backendHelper, $data);
     $this->setEmptyText(__('No Banners Found.'));

   }//__construct

   /**
   * Initialise the banner collection
   *
   * @return WidgetGrid
   **/
   protected function _prepareCollection(){

     $this->setCollection($this->_bannerCollection);
     return parent::_prepareCollection();

   }//_prepareCollection

   /**
   * Prepare grid columns
   *
   * @return $this
   */

   protected function _prepareColumns(){

     $this->addColumn(
        'entity_id',
        [
          'header' => __('ID'),
          'index' => 'entity_id'
        ]
     );

     $this->addColumn(
        'title',
        [
          'header' => __('Title'),
          'index' => 'title'
        ]
     );

     $this->addColumn(
        'created_at',
        [
          'header' => __('Created At'),
          'index' => 'created_at',
          'type'  => 'date'
        ]
     );

     $this->addColumn(
       'action',
       [
         'header' => __('Action'),
         'width' => '100',
         'type' => 'action',
         'getter' => 'getId',
         'actions' => array(
                        array(
                           'caption' => 'Edit',
                           'url' => array('base'=> '*/*/edit'),
                           'field' => 'id'
                         )),
               'filter' => false,
               'sortable' => false,
               'index' => 'stores',
               'is_system' => true,
      ]);





    /*$this->addColumn(
        'image',
        [
          'header' => __('Banner Image'),
          'index' => 'image'
        ]
     );
/*
     $this->addColumn(
        'youtube',
        [
          'header' => __('Banner Youtube'),
          'index' => 'youtube'
        ]
     );

     $this->addColumn(
        'show_title',
        [
          'header' => __('Show Title'),
          'index' => 'show_title',
          'type' => 'options',
          'options' => $this->_adminHelper->getYesNo(),
          'frame_callback' => [$this, '_loadYesNo'],
        ]
     );*/

    /* $this->addColumn(
        'created_at',
        [
          'header' => __('Created'),
          'index' => 'created_at'
        ]
     );*/
/*
     $this->addColumn(
        'slider_id',
        [
          'header' => __('Slider'),
          'index' => 'slider_id'
        ]
     );

     $this->addColumn(
        'sort_order',
        [
          'header' => __('Sort Order'),
          'index' => 'sort_order'
        ]
     );

     $this->addColumn(
        'is_active',
        [
          'header' => __('Is Active'),
          'index' => 'is_active',
          'type' => 'options',
          'options' => $this->_adminHelper->getYesNo(),
          'frame_callback' => [$this, '_loadYesNo'],
        ]
     );*/

     return $this;

   }//_prepareColumns

   /**
    * Yes/No
    * @param string $value
    * @return string
    */
   protected function _loadYesNo($value){

     return $this->_adminHelper->loadYesNo(value);

   }//_loadYesNo

}//Grid
