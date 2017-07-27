<?php

/**
 * Xigen
 */

namespace Xigen\Bannermanager\Controller\Adminhtml\Banner;

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportCsv extends \Xigen\Bannermanager\Controller\Adminhtml\Banner
{
    public function execute()
    {
        $fileName = 'banners.csv';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Xigen\Bannermanager\Block\Adminhtml\Banner\Grid')->getCsv();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}
