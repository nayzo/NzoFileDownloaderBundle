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

    public function __controler($rootDir)
    {
        $this->path = $rootDir . self::PATH_DIR;
    }

    /**
     * @param string $path
     * @return Response
     */
    public function readFile($path)
    {
        $path = $this->getPath($path);

        $fileName = substr($path, strrpos($path, '/') + 1, strlen($path));

        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', mime_content_type($path));
        $response->headers->set('Content-Disposition', 'inline;filename="' . $fileName . '"');
        $response->setContent(file_get_contents($path));

        return $response;
    }

    /**
     * @param string $path
     * @param string|null $newName
     * @return Response
     * @throws \Exception
     */
    public function downloadFile($path, $newName = null)
    {
        $path = $this->getPath($path);

        if (null === $newName) {
            $fileName = substr($path, strrpos($path, '/') + 1, strlen($path));
        } else {
            if (preg_match('/[^"]+\.[a-z|0-9]+$/i', $newName)) {
                $fileName = $newName;
            } else {
                throw new \Exception(sprintf('Not valid File name: %s', $newName));
            }
        }

        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->setContent(file_get_contents($path));

        return $response;
    }

    /**
     * @param string $path
     * @return string
     * @throws \Exception
     */
    private function getPath($path)
    {
        $path = $this->path . $path;
        if (!file_get_contents($path)) {
            throw new \Exception(sprintf('File could not be loaded in: %s', $path));
        }

        if (substr($path, -1) === '/' || substr($path, -1) === '#') {
            $path = substr($path, 0, -1);
        }

        return $path;
    }
}
