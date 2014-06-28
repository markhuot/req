<?php

if (!function_exists('slug_case')) {
  function slug_case($str)
  {
    return strtolower(trim(preg_replace('/[^a-z0-9_-]+/i', '-', $str), '-'));
  }
}
