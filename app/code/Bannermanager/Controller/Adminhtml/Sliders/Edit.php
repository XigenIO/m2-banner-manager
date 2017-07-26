<?php
namespace Xigen\Bannermanager\Controller\Adminhtml\Sliders;

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
        $resultPage->setActiveMenu('Xigen_Bannermanager::sliders')
            ->addBreadcrumb(__('Sliders'), __('Slider'))
            ->addBreadcrumb(__('Manage Sliders'), __('Manage Slider'));
        return $resultPage;
    }




    public function execute()
    {

        $id = $this->getRequest()->getParam('id');
         $model = $this->_objectManager->create('Xigen\Bannermanager\Model\Slider');

         if ($id) {

             $model->load($id);
             if (!$model->getId()) {
                 $this->messageManager->addError(__('This Slider no longer exists.'));
                 /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                 $resultRedirect = $this->resultRedirectFactory->create();

                 return $resultRedirect->setPath('*/*/');
             }
         }

         $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
         if (!empty($data)) {
             $model->setData($data);
         }

         $this->_coreRegistry->register('slider', $model);

         /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
         $resultPage = $this->_initAction();
         $resultPage->addBreadcrumb(
             $id ? __('Edit Blog') : __('New Blog'),
             $id ? __('Edit Blog') : __('New Blog')
         );
         $resultPage->getConfig()->getTitle()->prepend(__('Sliders'));
         $resultPage->getConfig()->getTitle()
             ->prepend($model->getId() ? $model->getTitle() : __('New Slider'));

         return $resultPage;

    }//execute




}//Edit
