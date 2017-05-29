NzoFileDownloaderBundle
=====================

[![Build Status](https://travis-ci.org/NAYZO/NzoFileDownloaderBundle.svg?branch=master)](https://travis-ci.org/NAYZO/NzoFileDownloaderBundle)
[![Total Downloads](https://poser.pugx.org/nzo/file-downloader-bundle/downloads)](https://packagist.org/packages/nzo/file-downloader-bundle)
[![Latest Stable Version](https://poser.pugx.org/nzo/file-downloader-bundle/v/stable)](https://packagist.org/packages/nzo/file-downloader-bundle)

The **NzoFileDownloaderBundle** is a Symfony Bundle used to ``Download`` all types of ``files`` from ``servers`` and ``Web application projects`` safely and with ease.
You can also ``read/show`` the file content in the Web Browser.

Features include:

- ``Read/Show`` the file content in the Web **Browser**.
- ``Download`` all types of ``files`` from the Symfony ``web`` folder.
- Change the name of the file when downloading.


Installation
------------

### Through Composer:

``` bash
$ composer require nzo/file-downloader-bundle
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

By default the path to the file start from the Symfony ``Web`` folder, but you can specify the path as absolute by adding **true** to the second or the third parameter.

```php
    // In this examples the "myfile.pdf" file exist in "web/myfolder/myfile.pdf".

     public function downloadAction()
     {
        # Read / Show the file content in the Web Browser:

          return $this->get('nzo_file_downloader')->readFile('myfolder/myfile.pdf');

        # Force file download:

          return $this->get('nzo_file_downloader')->downloadFile('myfolder/myfile.pdf');

        # change the name of the file when downloading:

          return $this->get('nzo_file_downloader')->downloadFile('myfolder/myfile.pdf', 'newName.pdf');
     }


     // Absolute PATH:

     public function downloadAction()
      {
         # Read / Show the file content in the Web Browser:

           return $this->get('nzo_file_downloader')->readFile('/home/profile/myfile.pdf', true);  // true: for Absolute PATH

         # Force file download:

           return $this->get('nzo_file_downloader')->downloadFile('/home/profile/myfile.pdf', true);  // true: for Absolute PATH

         # change the name of the file when downloading:

           return $this->get('nzo_file_downloader')->downloadFile('/home/profile/myfile.pdf', 'newName.pdf', true);  // true: for Absolute PATH
      }

```

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

See [Resources/doc/LICENSE](https://github.com/NAYZO/NzoFileDownloaderBundle/blob/master/Resources/doc/LICENSE)
