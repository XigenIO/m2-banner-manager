<?php
namespace Xigen\Bannermanager\Controller\Adminhtml\Banners;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\App\Action
{
  /**
   * Core registry
   *
   * @var \Magento\Framework\Registry
   */
   protected $_coreRegistry = null;

    /**
    * @var PageFactory
    */
    protected $resultPageFactory;

    /**
    * @param Context $context
    * @param PageFactory $resultPageFactory
    */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry
    ) {

        $this->_coreRegistry = $registry;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);

    }//_construct

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Xigen_Bannermanager::banners')
            ->addBreadcrumb(__('Banners'), __('Banner'))
            ->addBreadcrumb(__('Manage Banners'), __('Manage Banner'));
        return $resultPage;
    }




    public function execute()
    {

        $id = $this->getRequest()->getParam('id');
         $model = $this->_objectManager->create('Xigen\Bannermanager\Model\Banner');

         if ($id) {

             $model->load($id);
             if (!$model->getId()) {
                 $this->messageManager->addError(__('This Banner no longer exists.'));
                 /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                 $resultRedirect = $this->resultRedirectFactory->create();

                 return $resultRedirect->setPath('*/*/');
             }
         }

         $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
         if (!empty($data)) {
             $model->setData($data);
         }

         $this->_coreRegistry->register('banner', $model);

         /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
         $resultPage = $this->_initAction();
         $resultPage->addBreadcrumb(
             $id ? __('Edit Blog') : __('New Blog'),
             $id ? __('Edit Blog') : __('New Blog')
         );
         $resultPage->getConfig()->getTitle()->prepend(__('Banners'));
         $resultPage->getConfig()->getTitle()
             ->prepend($model->getId() ? $model->getTitle() : __('New Banner'));

         return $resultPage;

    }//execute




}//Edit
