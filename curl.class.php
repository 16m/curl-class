<?php

class	Curl
{

  public function __construct()
  {
    $this->initCurl();
  }

  public function __destruct()
  {
    curl_close($this->_ch);
  }

  /*****************************************************************************
   **		Initialisations						      **
   ****************************************************************************/

  private function initCurl()
  {
    if (!extension_loaded('curl'))
      throw new Exception(self::ERR_CURL_LOADED);
    if (!($this->_ch = curl_init()))
      throw new Exception(self::ERR_CURL_INIT);
  }

  /*****************************************************************************
   **		Error messages						      **
   ****************************************************************************/

  const ERR_CURL_LOADED = 'cURL extension is not loaded';
  const ERR_CURL_INIT = 'a valid cUrl handle could not be created';

  /*****************************************************************************
   **		Properties						      **
   ****************************************************************************/

  private $_ch;
};
?>