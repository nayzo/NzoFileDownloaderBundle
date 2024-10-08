<?php

/**
 * This file is part of the NzoFileDownloaderBundle package.
 *
 * (c) Ala Eddine Khefifi <alakfpro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nzo\FileDownloaderBundle\FileDownloader;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Mime\MimeTypes;

class FileDownloader
{
    const PUBLIC_DIR = '/public/';

    private $path;

    public function __construct(string $projectDir)
    {
        $this->path = $projectDir.self::PUBLIC_DIR;
    }

    public function readFile(string $path)
    {
        $path = $this->getPath($path, false);

        return $this->readFileHandler($path);
    }

    public function readFileFromAbsolutePath(string $path)
    {
        $path = $this->getPath($path, true);

        return $this->readFileHandler($path);
    }

    public function downloadFile(string $path, ?string $newName = null)
    {
        $path = $this->getPath($path, false);

        return $this->downloadFileHandler($path, $newName);
    }

    public function downloadFileFromAbsolutePath($path, $newName = null)
    {
        $path = $this->getPath($path, true);

        return $this->downloadFileHandler($path, $newName);
    }

    public function downloadFileFromUrl(
        string $url,
        string $fullDistPathWithFileName,
        array $headers = [],
        ?string $customUser = ''
    ): bool {

        try {
            $userAgent = trim(
                sprintf(
                    'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:15.0) Gecko/20100101 Firefox/15.0.1 %s',
                    $customUser
                )
            );

            $httpHeaders = array_merge([$userAgent], $headers);

            $context = stream_context_create(
                ['http' => ['header' => $httpHeaders]]
            );
            $response = file_put_contents($fullDistPathWithFileName, file_get_contents($url, false, $context));

            return $response !== false && $response !== 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function downloadFileFromUrlWithCurl(string $url, string $filePathDest): bool
    {
        $fh = fopen($filePathDest, 'wb');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fh);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // this will follow redirects
        curl_setopt(
            $ch,
            CURLOPT_USERAGENT,
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:15.0) Gecko/20100101 Firefox/15.0.1'
        );
        curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fh);

        return 200 == $responseCode;
    }

    public function getFileExtensionFromUrl(string $url): ?string
    {
        try {
            $mime = MimeTypes::getDefault();

            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (!empty($extension) && !empty($mime->getMimeTypes($extension))) {
                return $extension;
            }

            $fileType = $this->getFileTypeWithoutDownload($url);
            if (!$fileType) {
                return null;
            }

            $extensions = $mime->getExtensions($fileType);

            return !empty($extensions[0]) ? $extensions[0] : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function downloadStreamedResponse(StreamedResponse $streamedResponse, string $fileName)
    {
        if (empty($fileName)) {
            throw new \Exception(sprintf('Not valid File name: %s', $fileName));
        }
        $streamedResponse->setStatusCode(Response::HTTP_OK);
        $streamedResponse->headers->set('Content-Type', 'application/force-download');
        $streamedResponse->headers->set('Content-Disposition', 'attachment;filename="'.$fileName.'"');

        return $streamedResponse;
    }

    public function getFileTypeWithoutDownload(string $url): ?string
    {
        $extension = get_headers($url, 1)['Content-Type'];
        if (\is_array($extension)) {
            $extension = end($extension);
        }

        return $extension;
    }


    private function readFileHandler(string $path)
    {
        $fileName = substr($path, strrpos($path, '/') + 1, strlen($path));

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', mime_content_type($path));
        $response->headers->set('Content-Disposition', 'inline;filename="'.$fileName.'"');
        $response->setContent(file_get_contents($path));

        return $response;
    }

    private function downloadFileHandler(string $path, ?string $newName = null)
    {
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
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$fileName.'"');
        $response->setContent(file_get_contents($path));

        return $response;
    }

    private function getPath(string $path, bool $absolutePath): string
    {
        $path = $absolutePath ? $path : $this->path.$path;

        if (!file_exists($path) || !file_get_contents($path)) {
            throw new \Exception(sprintf('File could not be loaded in: %s', $path));
        }

        if (\in_array(substr($path, -1), ['/', '#'])) {
            $path = substr($path, 0, -1);
        }

        return $path;
    }
}
