<?php
namespace Xigen\Bannermanager\Controller\Adminhtml\Sliders;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\TestFramework\ErrorLog\Logger;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem\Driver\File;

class Save extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */


     protected $fileSystem;

     protected $uploaderFactory;

     protected $allowedExtensions = ['png', 'jpg', 'gif'];

     protected $fileId = 'image';

     protected $_file;



    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Filesystem $fileSystem,
        UploaderFactory $uploaderFactory,
        File $_file

    ) {

        $this->_file = $_file;
        $this->fileSystem = $fileSystem;
        $this->uploaderFactory = $uploaderFactory;
        parent::__construct($context);
        //$this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {

      $postData = $this->getRequest()->getPost();
      $resultRedirect = $this->resultRedirectFactory->create();
      $slider = $this->_objectManager->create('Xigen\Bannermanager\Model\Slider');
      $imageUpdated = 0;

      if($postData['id']){

        $slider->load($postData['id']);

      } else {

        $slider->setCreatedAt($this->_objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime')->gmtTimestamp());

      }

      $slider->setTitle($postData['title']);
      $slider->setIsActive($postData['is_active']);
      $slider->setSort($postData['sort']);
      $slider->setShowTitle($postData['show_title']);

      $this->_eventManager->dispatch(
           'slider_prepare_save',
           ['slider' => $slider, 'request' => $this->getRequest()]
       );

      try {
          $slider->save();
          $this->messageManager->addSuccess(__('Slider Saved.'));
          $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
          if ($this->getRequest()->getParam('back')) {
              return $resultRedirect->setPath('*/*/edit', ['id' => $slider->getId(), '_current' => true]);
          }
          return $resultRedirect->setPath('*/*/');

      } catch (\Exception $e) {

          print_r($e->getMessage());
          $this->messageManager->addException($e, __('Something went wrong while saving the slider.'));
      }


  //return $resultRedirect->setPath('*/*/');


  }//execute

  public function getDestinationPath()
  {
      return $this->fileSystem
          ->getDirectoryWrite(DirectoryList::MEDIA)
          ->getAbsolutePath('/');
  }

  public function deleteFile($fileName){

    $mediaDirectory = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA);
    $mediaRootDir = $mediaDirectory->getAbsolutePath();

    if ($this->_file->isExists($mediaRootDir . $fileName))  {

        $this->_file->deleteFile($mediaRootDir . $fileName);
    }


  }//deleteFile

}//Save
