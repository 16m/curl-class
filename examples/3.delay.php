#!/usr/bin/php
<?php

require_once '../Curl.php';

// This is to avoid problems with the date function on some configurations
date_default_timezone_set('Europe/Paris');

try
{
  // instantiation of the curl class
  $Curl = new Curl();

  // to avoid being banned from a website, we can define a
  // delay in second between each request
  $Curl->setDelay(3);

  for ($i = 0; $i < 5; ++$i)
    {
      $Curl->get('http://google.fr');
      echo 'Request finished at '.date('H:i:s').PHP_EOL;
    }
}
catch (Exception $e)
{
  echo 'Error : '.$e->getMessage().PHP_EOL;
}
