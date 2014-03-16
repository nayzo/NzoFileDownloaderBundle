<?php

namespace Nzo\FileDownloaderBundle\FileDownloader;
use Symfony\Component\HttpFoundation\Response;

/**
 * FileDownloader.
 *
 * @author Ala Eddine Khefifi <alakhefifi@gmail.com>
 * Website   www.alakhefifi.com
 */
class FileDownloader {

    private $path;
    private $fileName;
    public function __controler($rootDir){
        $this->path = $rootDir . '/../web/';
    }

    public function downloadFile($path, $newName=null){
        $this->path = $this->path . $path;
        if (!file_get_contents($this->path))
            return false;
        if(substr($this->path, -1) === '/' || substr($this->path, -1) === '#')
            $this->path = substr($this->path, 0, -1);

        if($newName){
            if(preg_match('/[^"]+\.[a-z|0-9]+$/i', $newName))
                $this->fileName = $newName;
            else
                return false;
        }
        else
            $this->fileName = substr($this->path, strrpos($this->path, '/')+1, strlen($this->path));

        $response = new Response();

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', mime_content_type($this->path));
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $this->fileName . '"');
        $response->setContent(file_get_contents($this->path));
        return $response;
    }
}