<?php
namespace Xigen\Bannermanager\Controller\Adminhtml\Banners;

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
      $banner = $this->_objectManager->create('Xigen\Bannermanager\Model\Banner');
      $imageUpdated = 0;

      if(isset($postData['image']['delete'])){

        $imgName = $postData['image']['value'];
        $postData['image'] = null;
        $this->deleteFile($imgName);
        $imageUpdated = 1;
      }

      if (! empty($_FILES) && !$imageUpdated){

        if($_FILES['image']['size'] > 0){//If size is 0, assume no image was uploaded

          try {

              $destinationPath = $this->getDestinationPath();
              $uploader = $this->uploaderFactory->create(['fileId' => $this->fileId])
                                                ->setAllowCreateFolders(true)
                                                ->setAllowedExtensions($this->allowedExtensions)
                                                ->addValidateCallback('validate', $this, 'validateFile');

                if (!$uploader->save($destinationPath)) {

                  throw new LocalizedException(
                      __('File cannot be saved to path: $1', $destinationPath)
                  );

                } else {

                  $postData['image'] = $uploader->getUploadedFileName();
                  $imageUpdated = 1;
                }

          } catch (\Exception $e) {

              $this->messageManager->addError(
                  __($e->getMessage())
              );
          }

        }

      }

      if($postData['id']){

        $banner->load($postData['id']);

      } else {

        $banner->setCreatedAt($this->_objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime')->gmtTimestamp());

      }

      $banner->setSliderId($postData['slider_id']);
      $banner->setTitle($postData['title']);
      $banner->setLink($postData['link']);
      $banner->setCaption($postData['caption']);
      $banner->setIsActive($postData['is_active']);

      if($imageUpdated){

        $banner->setImage($postData['image']);

      }

      $this->_eventManager->dispatch(
           'banner_prepare_save',
           ['banner' => $banner, 'request' => $this->getRequest()]
       );

      try {
          $banner->save();
          $this->messageManager->addSuccess(__('Banner Saved.'));
          $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
          if ($this->getRequest()->getParam('back')) {
              return $resultRedirect->setPath('*/*/edit', ['id' => $banner->getId(), '_current' => true]);
          }
          return $resultRedirect->setPath('*/*/');

      } catch (\Exception $e) {

          print_r($e->getMessage());
          $this->messageManager->addException($e, __('Something went wrong while saving the banner.'));
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
