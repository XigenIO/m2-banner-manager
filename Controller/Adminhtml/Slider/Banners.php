<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Controller\Adminhtml\Slider;

class Banners extends \Xigen\Bannermanager\Controller\Adminhtml\Slider
{
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('bannermanager.slider.edit.tab.banners')
                     ->setInBanner($this->getRequest()->getPost('banner', null));

        return $resultLayout;
    }
}
