NzoFileDownloaderBundle
=====================

[![Build Status](https://travis-ci.org/nayzo/NzoFileDownloaderBundle.svg?branch=master)](https://travis-ci.org/nayzo/NzoFileDownloaderBundle)
[![Total Downloads](https://poser.pugx.org/nzo/file-downloader-bundle/downloads)](https://packagist.org/packages/nzo/file-downloader-bundle)
[![Latest Stable Version](https://poser.pugx.org/nzo/file-downloader-bundle/v/stable)](https://packagist.org/packages/nzo/file-downloader-bundle)

The **NzoFileDownloaderBundle** is a Symfony Bundle used to ``Download`` all types of ``files`` from ``servers`` and ``Web application projects`` safely and with ease.
You can also ``read/show`` the file content in the Web Browser.

Features include:

- Compatible Symfony version 2, 3 & 4
- ``Read/Show`` the file content in the Web **Browser**.
- ``Download`` all types of ``files`` from the Symfony ``web`` folder.
- Change the name of the file when downloading.
- Compatible php version 5 & 7


Installation
------------

### Through Composer:

``` bash
$ composer require nzo/file-downloader-bundle
```

### Register the bundle in app/AppKernel.php (Symfony V2 or V3):

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
use Nzo\FileDownloaderBundle\FileDownloader\FileDownloader;

class MyController extends AbstractController
{
    private $fileDownloader;

    public function __construct(FileDownloader $fileDownloader)
    {
        $this->fileDownloader = $fileDownloader;
        
        // without autowiring use: $this->get('nzo_file_downloader')
    }

// In this examples the "myfile.pdf" file exist in "web/myfolder/myfile.pdf".

     public function downloadAction()
     {
        # Read / Show the file content in the Web Browser:

          return $this->fileDownloader->readFile('myfolder/myfile.pdf');

        # Force file download:

          return $this->fileDownloader->downloadFile('myfolder/myfile.pdf');

        # change the name of the file when downloading:

          return $this->fileDownloader->downloadFile('myfolder/myfile.pdf', 'newName.pdf');
     }


     // Absolute PATH:

     public function downloadAction()
      {
         # Read / Show the file content in the Web Browser:

           return $this->fileDownloader->readFile('/home/profile/myfile.pdf', true);  // true: for Absolute PATH

         # Force file download:

           return $this->fileDownloader->downloadFile('/home/profile/myfile.pdf', true);  // true: for Absolute PATH

         # change the name of the file when downloading:

           return $this->fileDownloader->downloadFile('/home/profile/myfile.pdf', 'newName.pdf', true);  // true: for Absolute PATH
      }
}    
```


- Download a Symfony **StreamedResponse**:

``` php

    use Symfony\Component\HttpFoundation\StreamedResponse;

    // ...

    public function someFunctionAction()
    {
        $streamedResponse = new StreamedResponse();
        // ...

        $fileName = 'someFileName.csv';

        return $this->fileDownloader->downloadStreamedResponse($streamedResponse, $fileName);
    }

```

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

See [Resources/doc/LICENSE](https://github.com/nayzo/NzoFileDownloaderBundle/blob/master/Resources/doc/LICENSE)
