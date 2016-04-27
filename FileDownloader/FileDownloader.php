<?php

/*
 * FileDownloader file.
 *
 * (c) Ala Eddine Khefifi <alakhefifi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nzo\FileDownloaderBundle\FileDownloader;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class FileDownloader
 * @package Nzo\FileDownloaderBundle\FileDownloader
 */
class FileDownloader
{
    const PATH_DIR = '/../web/';

    private $path;
    private $fileName;

    public function __controler($rootDir)
    {
        $this->path = $rootDir . self::PATH_DIR;
    }

    public function downloadFile($path, $newName = null, $forceDownload = false)
    {
        $this->path = $this->path . $path;
        if (!file_get_contents($this->path)) {
            return;
        }

        if (substr($this->path, -1) === '/' || substr($this->path, -1) === '#') {
            $this->path = substr($this->path, 0, -1);
        }

        if (null === $newName) {
            $this->fileName = substr($this->path, strrpos($this->path, '/') + 1, strlen($this->path));
        } else {
            if (preg_match('/[^"]+\.[a-z|0-9]+$/i', $newName)) {
                $this->fileName = $newName;
            } else {
                return;
            }
        }

        $response = new Response();
        $response->setStatusCode(200);

        if ($forceDownload) {
            $response->headers->set('Content-Type', 'application/force-download');
            $response->headers->set('Content-Disposition', 'attachment;filename="' . $this->fileName . '"');
        } else {
            $response->headers->set('Content-Type', mime_content_type($this->path));
            $response->headers->set('Content-Disposition', 'inline;filename="' . $this->fileName . '"');
        }
        $response->setContent(file_get_contents($this->path));

        return $response;
    }
}
