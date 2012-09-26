#!/usr/bin/php
<?php

require_once '../Curl.php';

try
{
  // instantiation of the curl class
  $Curl = new Curl();

  // we set a file where the output will be redirected
  $Curl->setFile('index.html');

  // we request a page. The output will be redirected in the file
  $Curl->get('http://www.google.fr');

  // we explictly close the file
  $Curl->unsetFile();
}
catch (Exception $e)
{
  echo 'Error : '.$e->getMessage().PHP_EOL;
}
?>
