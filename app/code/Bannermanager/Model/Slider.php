<?php

namespace Xigen\Bannermanager\Model;

use Xigen\Bannermanager\Api\Data\SliderInterface;

/**
 * Slider
 *
 */
class Slider extends \Magento\Framework\Model\AbstractModel  implements SliderInterface
{

  public function __construct(\Magento\Framework\Model\Context $context,
						        \Magento\Framework\Registry $registry){
    $this->_init('Xigen\Bannermanager\Model\Resource\Slider');

		parent::__construct($context, $registry);

	}//_construct

  public function getId(){//Return primary id

  	return $this->_getData('entity_id');

  }//getId




}//Slider
