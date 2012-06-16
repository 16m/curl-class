<?php

/** An object oriented layer to cURL functions in PHP
 */
class	Curl
{
  /** Constructor - initialise all properties
   */
  public function __construct()
  {
    $this->initProperties();
    $this->initCurl();
    $this->initHandle();
  }

  /** Destructor - destroy the curl handle
   */
  public function __destruct()
  {
    curl_close($this->_ch);
    $this->closeFile();
  }

  /*****************************************************************************
   **   Initialisations							      **
   ****************************************************************************/

  /** Initialise a cURL handle
   **
   ** @exception Exception is thrown if the cURL extension is not
   ** loaded or if the cURL handle could not be created
   */
  private function initCurl()
  {
    if (!extension_loaded('curl'))
      throw new Exception(self::ERR_CURL_LOADED);
    if (!($this->_ch = curl_init()))
      throw new Exception(self::ERR_CURL_INIT);
  }

  /** Initialise the properties of the object
   */
  private function initProperties()
  {
    $this->_ch = null;
    $this->_delay = self::DEFAULT_DELAY;
    $this->_fileHandle = null;
    $this->_lastTime = 0;
    $this->_userAgent = self::DEFAULT_USER_AGENT;
  }

  /** Initialise the properties of the cURL handle
   */
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

  /** Download a page using the HTTP GET request
   **
   ** @param string $url The url pointing to the page to download
   ** @return string The source code of the downloaded page
   */
  public function &get($url)
  {
    curl_setopt($this->_ch, CURLOPT_HTTPGET, true);
    return $this->exec($url);
  }

  /** Download a page using the HTTP POST request
   **
   ** @param string $url The url pointing to the page to download
   ** @param array $postFields The array containing the data to be posted
   ** @return string The source code of the downloaded page
   */
  public function &post($url, $postFields)
  {
    curl_setopt($this->_ch, CURLOPT_POST, true);
    curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $postFields);
    return $this->exec($url);
  }

  /*****************************************************************************
   **		Setters							      **
   ****************************************************************************/

  /** Set a file where will be written the content of the downloaded pages
   **
   ** @param string $filename The filename of the file to write
   ** @exception Exception is thrown if the file could not be open
   */
  public function setFile($filename)
  {
    if (!($this->_fileHandle = fopen($filename, 'w')))
      throw new Exception(ERR_FILE_OPEN);
    curl_setopt($this->_ch, CURLOPT_FILE, $this->_fileHandle);
  }

  /** Stop recording in a file if the setFile() method was called before
   */
  public function unsetFile()
  {
    curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
    $this->closeFile();
  }

  /** Set a specific user-agent and avoid using the default one
   **
   ** @param string $userAgent The user-agent to use
   */
  public function setUserAgent($userAgent)
  {
    $this->_userAgent = $userAgent;
  }

  /** Set a delay to wait between each download
   **
   ** @param float $delay The number of second to wait between each download
   ** @throw Exception is thrown if the specified delay is
   ** not numeric
   */
  public function setDelay($delay)
  {
    if (!is_numeric($delay))
      throw new Exception(self::ERR_DELAY_NUM);
    $this->_delay = $delay;
  }

  /** Set a cookie file
   **
   ** @param string $filename The filename of the the file to use as a cookie
   */
  public function setCookieFile($filename)
  {
    curl_setopt($this->_ch, CURLOPT_COOKIEFILE, $filename);
    curl_setopt($this->_ch, CURLOPT_COOKIEJAR, $filename);
  }

  /*****************************************************************************
   **		Requests delay						      **
   ****************************************************************************/

  /** Wait a delay if any and download the given page
   **
   ** @param string $url The url pointing to the page to download
   ** @exception Exception is thrown if the download fails
   ** @return string The source code of the downloaded page
   */
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

  /** Close the file handle if it is open
   **
   ** @exception Exception is thrown if the file handle could not
   ** be closed
   **/
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