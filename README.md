NzoFileDownloaderBundle
=====================

[![Build Status](https://travis-ci.org/NAYZO/NzoFileDownloaderBundle.svg?branch=master)](https://travis-ci.org/NAYZO/NzoFileDownloaderBundle)
[![Latest Stable Version](https://poser.pugx.org/nzo/file-downloader-bundle/v/stable)](https://packagist.org/packages/nzo/file-downloader-bundle)

The **NzoFileDownloaderBundle** is a Symfony2/3 Bundle used to ``Download`` all types of ``files`` from ``servers`` and ``Web application projects`` safely and with ease.
You can also ``read/show`` the file content in the Web Browser.

Features include:

- ``Read/Show`` the file content in the Web **Browser**.
- ``Download`` all types of ``files`` from the Symfony ``web`` folder.
- Change the name of the file when downloading.


Installation
------------

### Through Composer:

Add the following lines in your `composer.json` file:

``` js
"require": {
    "nzo/file-downloader-bundle": "~2.0"
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

In the controller use the ``FileDownloader`` Service and specify the function you want to use:

The path to the file must start from the Symfony ``Web`` folder.

```php
    // In this examples the "myfile.txt" file exist in "web/myfolder/myfile.txt".

     public function downloadAction()
     {
        # Read / Show the file content in the Web Browser:

          return $this->get('nzo_file_downloader')->readFile('myfolder/myfile.txt');

        # Force file download:

          return $this->get('nzo_file_downloader')->downloadFile('myfolder/myfile.txt');

        # change the name of the file when downloading:

          return $this->get('nzo_file_downloader')->downloadFile('myfolder/myfile.txt', 'newName.txt');
     }
```

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

See [Resources/doc/LICENSE](https://github.com/NAYZO/NzoFileDownloaderBundle/blob/master/Resources/doc/LICENSE)
