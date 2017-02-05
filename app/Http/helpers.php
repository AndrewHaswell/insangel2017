<?php

if (!function_exists('insangel_case')) {

  /**
   * Return an seo friendly version of the string
   *
   * @param $string
   *
   * @return string
   * @author Andrew Haswell
   */

  function insangel_case($string)
  {

    return strtolower(preg_replace('/[^a-z0-9]/i', '-', preg_replace('/[\']/i', '', trim($string))));
  }
}