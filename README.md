Curl class
==========

An object-oriented layer to PHP curl functions.

Introduction
------------

Initialising and configuring a cURL handle in PHP can be sometimes a bit tricky
or time consuming, especially when we just need to retrieve a simple page. The
goal of the Curl class is to abstract the configuration and error handling,
and to offer the user simple methods to do the basic tasks.

How to use it ?
---------------

Here are few ways to use the class. To see all possible actions, refer to the
documentation or source code.

### The GET request

```php
<?php
$Curl = new Curl;
$content = $Curl->get('http://google.com');
```

### Redirecting the output to a file

```php
<?php
$Curl = new Curl;
$Curl->setFile('content.html');
$Curl->get('http://google.com');
```

### Waiting a delay between each request

```php
<?php
$Curl = new Curl;
$Curl->setDelay(2); //wait 2 seconds between each request
$content1 = $Curl->get('http://example.com/page1.html');
$content2 = $Curl->get('http://example.com/page2.html');
```

The user agent
--------------

When performing requests, you will have a user agent by default :

     YourBot/1.0 (+http://yourwebsite.com)

You can either modify this string stored in the DEFAULT_USER_AGENT constant or
set your user agent at execution :

```php
<?php
$Curl = new Curl;
$Curl->setUserAgent('A more legit user agent');
```

Documentation
-------------

The documentation can be generated with doxygen. To do it, just type this :

    doxygen .Doxyfile
