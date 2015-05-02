NzoFileDownloaderBundle
=====================

[![Build Status](https://travis-ci.org/NAYZO/NzoFileDownloaderBundle.svg?branch=master)](https://travis-ci.org/NAYZO/NzoFileDownloaderBundle)

The **NzoFileDownloaderBundle** is a Symfony2 Bundle used to ``Download`` all types of ``files`` from ``servers`` and ``Web application projects`` safely and with ease.

Features include:

- ``Download`` all types of ``files`` from the ``web`` folder
- Change name of the file when downloading


Installation
------------

### Through Composer:

Add the following lines in your `composer.json` file:

``` js
"require": {
    "nzo/file-downloader-bundle": "~1.0"
}
```
Install the bundle:

```
$ composer update
```

### Register the bundle in app/AppKernel.php:

``` php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        // ...
        new Nzo\FileDownloaderBundle\NzoFileDownloaderBundle(),
    );
}
```

Usage
-----

In the controller use the ``FileDownloader`` service and specify the options needed:

- The path to the file must start from the ``Web`` folder.

```php
     public function downloadAction()
     {
        /*
         specify the path to the file from the "Web" folder.
         in this example the "myfile.txt" file exist in "web/myfolder/myfile.txt"
        */

              return $this->get('nzo_file_downloader')->downloadFile('myfolder/myfile.txt');

        // OR change the name of the file when downloading
             return $this->get('nzo_file_downloader')->downloadFile('myfolder/myfile.txt', 'newName.txt');
     }
```

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

See [Resources/doc/LICENSE](https://github.com/NAYZO/NzoFileDownloaderBundle/blob/master/Resources/doc/LICENSE)
