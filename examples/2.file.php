#!/usr/bin/php
<?php

require_once '../curl.class.php';

try
{
  // instantiation of the curl class
  $curl = new Curl();

  // we define a file where to write results
  $curl->setFile('index.html');

  // we request a page. The result will be written in the file
  $curl->get('http://www.google.fr');

  // we close the file
  $curl->unsetFile();
}
catch (Exception $e)
{
  echo 'Error : '.$e->getMessage().PHP_EOL;
}
?>
