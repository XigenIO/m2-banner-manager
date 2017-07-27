<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Controller\Adminhtml\Slider;

use Xigen\Bannermanager\Model\Slider;

class Save extends \Xigen\Bannermanager\Controller\Adminhtml\Slider
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $formPostValues = $this->getRequest()->getPostValue();

        if (isset($formPostValues['slider'])) {
            $sliderData = $formPostValues['slider'];
            $sliderId = isset($sliderData['slider_id']) ? $sliderData['slider_id'] : null;

            if (isset($sliderData['store_ids'])) {
                $sliderData['store_id'] = implode(',', $sliderData['store_ids']);
                unset($sliderData['store_ids']);
            }
            
            $model = $this->_sliderFactory->create();

            $model->load($sliderId);

            $model->setData($sliderData);

            try {
                $model->save();

                if (isset($formPostValues['slider_banner'])) {
                    $bannerGridSerializedInputData = $this->_jsHelper->decodeGridSerializedInput($formPostValues['slider_banner']);
                    $bannerIds = [];
                    foreach ($bannerGridSerializedInputData as $key => $value) {
                        $bannerIds[] = $key;
                        $bannerOrders[] = $value['order_banner_slider'];
                    }

                    $unSelecteds = $this->_bannerCollectionFactory
                        ->create()
                        ->addFieldToFilter('slider_id', $model->getId());
                    if (count($bannerIds)) {
                        $unSelecteds->addFieldToFilter('banner_id', array('nin' => $bannerIds));
                    }

                    foreach ($unSelecteds as $banner) {
                        $banner->setSliderId(0)
                            ->setOrderBanner(0)->save();
                    }

                    $selectBanner = $this->_bannerCollectionFactory
                        ->create()
                        ->addFieldToFilter('banner_id', array('in' => $bannerIds));
                    $i = -1;
                    foreach ($selectBanner as $banner) {
                        $banner->setSliderId($model->getId())
                            ->setOrderBanner($bannerOrders[++$i])->save();
                    }
                }

                $this->messageManager->addSuccess(__('The slider has been saved.'));
                $this->_getSession()->setFormData(false);

                return $this->_getBackResultRedirect($resultRedirect, $model->getId());
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException($e, __('Something went wrong while saving the slider.'));
            }

            $this->_getSession()->setFormData($formPostValues);

            return $resultRedirect->setPath('*/*/edit', [static::PARAM_CRUD_ID => $sliderId]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
