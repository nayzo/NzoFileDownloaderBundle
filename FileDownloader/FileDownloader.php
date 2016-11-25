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
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class FileDownloader
 * @package Nzo\FileDownloaderBundle\FileDownloader
 */
class FileDownloader
{
    const PATH_DIR = '/../web/';

    private $path;

    public function __construct($rootDir)
    {
        $this->path = $rootDir . self::PATH_DIR;
    }

    /**
     * @param string $path
     * @param bool $absolutePath
     * @return Response
     */
    public function readFile($path, $absolutePath = false)
    {
        $path = $this->getPath($path, $absolutePath);

        $fileName = substr($path, strrpos($path, '/') + 1, strlen($path));

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', mime_content_type($path));
        $response->headers->set('Content-Disposition', 'inline;filename="' . $fileName . '"');
        $response->setContent(file_get_contents($path));

        return $response;
    }

    /**
     * @param string $path
     * @param string|null|bool $newName
     * @param bool $absolutePath
     * @return Response
     * @throws \Exception
     */
    public function downloadFile($path, $newName = null, $absolutePath = false)
    {
        if ((is_bool($newName) && true === $newName)) {
            $path = $this->getPath($path, $newName);
        } else {
            $path = $this->getPath($path, $absolutePath);
        }

        if ((null === $newName) || (is_bool($newName) && true === $newName)) {
            $fileName = substr($path, strrpos($path, '/') + 1, strlen($path));
        } else {
            if (preg_match('/[^"]+\.[a-z|0-9]+$/i', $newName)) {
                $fileName = $newName;
            } else {
                throw new \Exception(sprintf('Not valid File name: %s', $newName));
            }
        }

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->setContent(file_get_contents($path));

        return $response;
    }

    /**
     * @param StreamedResponse $streamedResponse
     * @param string $fileName
     * @return StreamedResponse
     * @throws \Exception
     */
    public function downloadStreamedResponse(StreamedResponse $streamedResponse, $fileName)
    {
        if (empty($fileName)) {
            throw new \Exception(sprintf('Not valid File name: %s', $fileName));
        }
        $streamedResponse->setStatusCode(Response::HTTP_OK);
        $streamedResponse->headers->set('Content-Type', 'application/force-download');
        $streamedResponse->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');

        return $streamedResponse;
    }

    /**
     * @param string $path
     * @param bool $absolutePath
     * @return string
     * @throws \Exception
     */
    private function getPath($path, $absolutePath)
    {
        $path = $absolutePath ? $path : $this->path . $path;

        if (!file_get_contents($path)) {
            throw new \Exception(sprintf('File could not be loaded in: %s', $path));
        }

        if (substr($path, -1) === '/' || substr($path, -1) === '#') {
            $path = substr($path, 0, -1);
        }

        return $path;
    }
}
