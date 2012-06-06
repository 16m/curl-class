#!/usr/bin/php
<?php

require_once '../curl.class.php';

try
{
  // instation of the curl class
  $curl = new Curl();

  $postfields = array(
		      'info1' => 'value1',
		      'info2' => 'value2',
		      'info3' => 'value3',
		      'info4' => 'value4',
		      'info5' => 'value5'
		      );
  $curl->setFile('result.html');
  $curl->post('http://www.htmlcodetutorial.com/cgi-bin/mycgi.pl', $postfields);
  $curl->unsetFile();
}
catch (Exception $e)
{
  echo 'Error : '.$e->getMessage().PHP_EOL;
}
?>
