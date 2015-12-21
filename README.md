NzoFileDownloaderBundle
=====================

[![Build Status](https://travis-ci.org/NAYZO/NzoFileDownloaderBundle.svg?branch=master)](https://travis-ci.org/NAYZO/NzoFileDownloaderBundle)
[![Latest Stable Version](https://poser.pugx.org/nzo/file-downloader-bundle/v/stable)](https://packagist.org/packages/nzo/file-downloader-bundle)

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

        // In this example the "myfile.txt" file exist in "web/myfolder/myfile.txt":
            return $this->get('nzo_file_downloader')->downloadFile('myfolder/myfile.txt');

        // OR change the name of the file when downloading:
            return $this->get('nzo_file_downloader')->downloadFile('myfolder/myfile.txt', 'newName.txt');

        // You can Force download (it's appreciated if you want to force download PDF file and prevent the web browser from reading it):
            return $this->get('nzo_file_downloader')->downloadFile('myfolder/myfile.txt', null, true);

            // OR by changing the name:
                return $this->get('nzo_file_downloader')->downloadFile('myfolder/myfile.pdf', 'file.pdf', true);
     }
```

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

See [Resources/doc/LICENSE](https://github.com/NAYZO/NzoFileDownloaderBundle/blob/master/Resources/doc/LICENSE)
