<?php

class	Curl
{
  public function __construct()
  {
    $this->initProperties();
    $this->initCurl();
    $this->initHandle();
  }

  public function __destruct()
  {
    curl_close($this->_ch);
    $this->closeFile();
  }

  /*****************************************************************************
   **   Initialisations							      **
   ****************************************************************************/

  private function initCurl()
  {
    if (!extension_loaded('curl'))
      throw new Exception(self::ERR_CURL_LOADED);
    if (!($this->_ch = curl_init()))
      throw new Exception(self::ERR_CURL_INIT);
  }

  private function initProperties()
  {
    $this->_ch = null;
    $this->_delay = self::DEFAULT_DELAY;
    $this->_fileHandle = null;
    $this->_lastTime = 0;
    $this->_userAgent = self::DEFAULT_USER_AGENT;
  }

  private function initHandle()
  {
    curl_setopt($this->_ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($this->_ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($this->_ch, CURLOPT_HTTPGET, true);
    curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
  }

  /*****************************************************************************
   **		Actions							      **
   ****************************************************************************/

  public function &get($url)
  {
    curl_setopt($this->_ch, CURLOPT_HTTPGET, true);
    return $this->exec($url);
  }

  public function &post($url, $postFields)
  {
    curl_setopt($this->_ch, CURLOPT_POST, true);
    curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $postFields);
    return $this->exec($url);
  }

  /*****************************************************************************
   **		Setters							      **
   ****************************************************************************/

  public function setFile($filename)
  {
    if (!($this->_fileHandle = fopen($filename, 'w')))
      throw new Exception(ERR_FILE_OPEN);
    curl_setopt($this->_ch, CURLOPT_FILE, $this->_fileHandle);
  }

  public function unsetFile()
  {
    curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
    $this->closeFile();
  }

  public function setUserAgent($userAgent)
  {
    $this->_userAgent = $userAgent;
  }

  public function setDelay($delay)
  {
    if (!is_numeric($delay))
      throw new Exception(self::ERR_DELAY_NUM);
    $this->_delay = $delay;
  }

  /*****************************************************************************
   **		Requests delay						      **
   ****************************************************************************/

  private function &exec($url)
  {
    curl_setopt($this->_ch, CURLOPT_URL, $url);
    while (microtime(true) - $this->_lastTime < $this->_delay);
    if (!($ret = curl_exec($this->_ch)))
      throw new Exception(self::ERR_CURL_EXEC);
    $this->_lastTime = microtime(true);
    return $ret;
  }

  /*****************************************************************************
   **		Tools							      **
   ****************************************************************************/

  private function closeFile()
  {
    if ($this->_fileHandle != null &&
	!fclose($this->_fileHandle))
      throw new Exception(self::ERR_FILE_CLOSE);
    $this->_fileHandle = null;
  }

  /*****************************************************************************
   **		Error messages						      **
   ****************************************************************************/

  const ERR_CURL_EXEC = 'cURL failed to download a page';
  const ERR_CURL_LOADED = 'cURL extension is not loaded';
  const ERR_CURL_INIT = 'a valid cUrl handle could not be created';
  const ERR_DELAY_NUM = 'delay must be a number';
  const ERR_FILE_CLOSE = 'the file could not be closed';
  const ERR_FILE_OPEN = 'the file could not be open';

  /*****************************************************************************
   **		Constants						      **
   ****************************************************************************/

  const DEFAULT_USER_AGENT = 'YourBot/1.0 (+http://yourwebsite.com)';
  const DEFAULT_DELAY = 0;

  /*****************************************************************************
   **		Properties						      **
   ****************************************************************************/

  private $_ch;
  private $_delay;
  private $_fileHandle;
  private $_lastTime;
  private $_userAgent;
};
?>