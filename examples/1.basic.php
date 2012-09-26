#!/usr/bin/php
<?php

require_once '../Curl.php';

try
{
  // instantiation of the curl class
  $Curl = new Curl();

  // we request a page and we get the result in $ret
  $ret = $Curl->get('http://www.google.fr');

  echo $ret;
}
catch (Exception $e)
{
  echo 'Error : '.$e->getMessage().PHP_EOL;
}
?>
