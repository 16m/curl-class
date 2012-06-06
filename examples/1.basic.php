#!/usr/bin/php
<?php

require_once '../curl.class.php';

try
{
  // instantiation of the curl class
  $curl = new Curl();

  // we request a page and we get the result in $ret
  $ret = $curl->get('http://www.google.fr');

  echo $ret;
}
catch (Exception $e)
{
  echo 'Error : '.$e->getMessage().PHP_EOL;
}
?>
