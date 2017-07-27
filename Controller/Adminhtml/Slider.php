<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Controller\Adminhtml;

abstract class Slider extends \Xigen\Bannermanager\Controller\Adminhtml\AbstractAction
{
    const PARAM_CRUD_ID = 'slider_id';

    /**
     * Check if admin has permissions to visit related pages.
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Xigen_Bannermanager::bannermanager_sliders');
    }
}
