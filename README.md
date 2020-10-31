NzoFileDownloaderBundle
=======================

[![Build Status](https://travis-ci.org/nayzo/NzoFileDownloaderBundle.svg?branch=master)](https://travis-ci.org/nayzo/NzoFileDownloaderBundle)
[![Total Downloads](https://poser.pugx.org/nzo/file-downloader-bundle/downloads)](https://packagist.org/packages/nzo/file-downloader-bundle)
[![Latest Stable Version](https://poser.pugx.org/nzo/file-downloader-bundle/v/stable)](https://packagist.org/packages/nzo/file-downloader-bundle)

The **NzoFileDownloaderBundle** is a Symfony Bundle used to ``Download`` all types of ``files`` from ``servers`` and ``Web application projects`` safely and with ease.
You can also ``read/show`` the file content in the Web Browser.

Features include:

- This version of the bundle is compatible with Symfony >= v4.4
- ``Read/Show`` the file content in the Web **Browser**.
- ``Download`` all types of ``files`` from the Symfony ``public`` folder or from a custom path.
- Change the name of the file when downloading.
- Download Files From Url
- Get Files Extension From Url

Installation
------------

### Through Composer:

``` bash
$ composer require nzo/file-downloader-bundle
```

#### Register the bundle in config/bundles.php (without Flex)


``` php
// config/bundles.php

return [
    // ...
    Nzo\FileDownloaderBundle\NzoFileDownloaderBundle::class => ['all' => true],
];
```

Usage
-----

#### Read / Show the file content in the Web Browser:

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

// In this examples the "myfile.pdf" file exist in "public/myfolder/myfile.pdf".

     public function readFilesFromPublicFolder()
     {
          return $this->fileDownloader->readFile('myfolder/myfile.pdf');
     }

     // Absolute PATH:

     public function readFilesFromAbsolutePath()
      {
           return $this->fileDownloader->readFileFromAbsolutePath('/home/user/myfile.pdf');
      }
}    
```

#### Download the Files:

```php
     public function downloadFileFromPublicFolder()
     {
          return $this->fileDownloader->downloadFile('myfolder/myfile.pdf');

        # change the name of the file when downloading:

          return $this->fileDownloader->downloadFile('myfolder/myfile.pdf', 'newName.pdf');
     }


     // Absolute PATH:

     public function downloadFilesFromAbsolutePath()
      {
           return $this->fileDownloader->downloadFileFromAbsolutePath('/home/user/myfile.pdf');

         # change the name of the file when downloading:

           return $this->fileDownloader->downloadFileFromAbsolutePath('/home/user/myfile.pdf', 'newName.pdf');
      }
}    
```

##### Download Files from **URL**:

```php
    public function downloadFileFromUrl(string $url, string $pathWhereToDownloadTheFile, ?string $customUserAgent = null)
    {
        $response =  $this->fileDownloader->downloadFileFromUrl($url, $pathWhereToDownloadTheFile, /** You can pass an optional custom User-Agent as third argument ($customUserAgent) */);
    
        if (false !== $response) {
            // File downloaded successfully !
        } else {
            // Error occurred ! 
        }   
    }
```

##### Get Files Extension From **URL**:

```php
public function getFileExtensionFromUrl(string $url)
{
    $fileExtension = $this->fileDownloader->getFileExtensionFromUrl($url);

    if (null === $fileExtension) {
        // Error occurred ! 
    }
}
```

##### Download a Symfony **StreamedResponse**:

```php
    use Symfony\Component\HttpFoundation\StreamedResponse;

    // ...

    public function downloadStreamedResponse()
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

See [Resources/doc/LICENSE](https://github.com/nayzo/NzoFileDownloaderBundle/blob/master/LICENSE)
