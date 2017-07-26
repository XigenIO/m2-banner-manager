<?php

namespace Xigen\Bannermanager\Helper;

/**
 * Bannermanager admin helper
 *
 *
 */
class Admin extends \Magento\Framework\App\Helper\AbstractHelper {

  /**
   * Yes/No Grid array
   *
   * @return array
   */
  public function getYesNo() {

      return ['0' => __('No'),
              '1' => __('Yes')
              ];

  }//getYesNo

  /**
   * Yes/No Grid value
   * @param $value
   * @return string
   */
  public function getYesNoValue($value) {

      $array = $this->getYesNo();
      return $array[$value];

  }//getYesNoValue

  /**
   * Style Grid array
   *
   * @return array
   */
  public function getStyle() {
      return [
          'static'        => __('Static'),
          'single-static' => __('Single Static'),
          'bootstrap'     => __('Bootstrap'),
      ];
  }

  /**
   * Style Grid value
   * @param $value
   * @return string
   */
  public function getStyleValue($value) {
      $array = $this->getYesNo();
      return $array[$value];
  }

  /**
   * Random/orderly Grid array
   *
   * @return array
   */
  public function getRandomOrderly() {
      return [
          'random'    => __('Random'),
          'orderly'   => __('Orderly'),
      ];
  }



}//Admin
