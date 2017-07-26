<?php

namespace Xigen\Bannermanager\Model;

use Xigen\Bannermanager\Api\Data\BannerInterface;

/**
 * Banner
 *
 */
class Banner extends \Magento\Framework\Model\AbstractModel  implements BannerInterface
{

  public function __construct(\Magento\Framework\Model\Context $context,
						        \Magento\Framework\Registry $registry){
    $this->_init('Xigen\Bannermanager\Model\Resource\Banner');
                      
		parent::__construct($context, $registry);

	}//_construct

  public function getId(){//Return primary id

  	return $this->_getData('entity_id');

  }//getId




}//Banner
