#!/usr/bin/php
<?php

require_once '../Curl.php';

try
{
  // instation of the curl class
  $Curl = new Curl();

  $postfields = array(
		      'info1' => 'value1',
		      'info2' => 'value2',
		      'info3' => 'value3',
		      'info4' => 'value4',
		      'info5' => 'value5'
		      );
  $Curl->setFile('result.html');
  $Curl->post('http://www.htmlcodetutorial.com/cgi-bin/mycgi.pl', $postfields);
  $Curl->unsetFile();
}
catch (Exception $e)
{
  echo 'Error : '.$e->getMessage().PHP_EOL;
}
?>
