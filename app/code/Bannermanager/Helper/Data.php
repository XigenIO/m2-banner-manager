<?php

namespace Xigen\Bannermanager\Helper;

use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Bannermanager admin helper
 *
 *
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper {

  protected $_file;
  protected $fileSystem;
  protected $_storeManager;

  public function __construct(
      Filesystem $fileSystem,
      StoreManagerInterface $_storeManager,
      File $_file,
      Context $context) {

      $this->_storeManager = $_storeManager;
      $this->_file = $_file;
      $this->fileSystem = $fileSystem;
      parent::__construct($context);
      //$this->resultPageFactory = $resultPageFactory;
  }



  /**
   * Get Image Url
   *
   * @return string
   */
   public function getImageUrl($image){

     $mediaDirectory = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA);
     $mediaRootDir = $mediaDirectory->getAbsolutePath();

     if ($this->_file->isExists($mediaRootDir . $image))  {

       return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $image;

     }


     return false;

   }//getImageUrl

}//Data
