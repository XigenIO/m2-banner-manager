<?php
namespace Xigen\Bannermanager\Controller\Adminhtml\Banners;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;

class NewAction extends \Magento\Backend\App\Action
{

  /**
   * @var PageFactory
   */
  protected $resultForwardFactory;


  /**
  * @param \Magento\Backend\App\Action\Context $context
  * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
  */
  public function __construct(
      Context $context,
      ForwardFactory $resultForwardFactory
  ) {

      $this->resultForwardFactory = $resultForwardFactory;
      parent::__construct($context);

  }//_construct

  /**
   * {@inheritdoc}
   */
  protected function _isAllowed()
  {

      return $this->_authorization->isAllowed('Xigen_Bannermanager::save');

  }//_isAllowed

  /**
  * Forward to edit
  *
  * @return \Magento\Backend\Model\View\Result\Forward
  */
  public function execute()
  {
      /** @var \Magento\Backend\Model\View\Result\Forward $resultPage */
      $resultForward = $this->resultForwardFactory->create();
      return $resultForward->forward('edit');

  }//execute

}//New
