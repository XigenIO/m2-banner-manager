<?php

namespace Xigen\Bannermanager\Controller\Adminhtml\Banners;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{

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
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Xigen_Bannermanager::banners');
        $resultPage->addBreadcrumb(__('Banner Manager'), __('Banner Manager'));
        $resultPage->addBreadcrumb(__('Manage Banners'), __('Manage Banners'));
        $resultPage->getConfig()->getTitle()->prepend(__('Banners'));

        return $resultPage;
    }

    /**
     * Is the user allowed to view the banners grid.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Xigen_Bannermanager::banners');
    }

    protected function _initAction(){

        $this->_view->loadLayout();
        $this->setActiveMenu('Xigen_Bannermanager::banners')
                ->addBreadcrumb(__('Banners'),
                                __('Manage Banners')
                                );

        return $this;

    }


}
