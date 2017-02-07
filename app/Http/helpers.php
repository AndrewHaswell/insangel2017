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

if (!function_exists('show_social_link')) {

  /**
   * @param $link
   *
   * @author Andrew Haswell
   */

  function show_social_link($link)
  {
    $parts = parse_url($link);
    if (strpos($parts['host'], 'instagram.com') !== false) {
      echo '<a href = "' . $link . '" target="_blank"><img src="' . URL::asset('images/instagram.png') . '"/></a>';
    }
    if (strpos($parts['host'], 'facebook.com') !== false) {
      echo '<a href = "' . $link . '" target="_blank"><img src="' . URL::asset('images/facebook.png') . '"/></a>';
    }
    if (strpos($parts['host'], 'twitter.com') !== false) {
      echo '<a href = "' . $link . '" target="_blank"><img src="' . URL::asset('images/twitter.png') . '"/></a>';
    }
  }
}