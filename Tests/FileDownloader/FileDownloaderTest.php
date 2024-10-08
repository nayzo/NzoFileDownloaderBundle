<?php

/**
 * This file is part of the NzoFileDownloaderBundle package.
 *
 * (c) Ala Eddine Khefifi <alakfpro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nzo\FileDownloaderBundle\Tests\FileDownloader;

use Nzo\FileDownloaderBundle\FileDownloader\FileDownloader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileDownloaderTest extends TestCase
{
    private $projectDir;
    private $fileDownloader;

    protected function setUp(): void
    {
        $this->projectDir = __DIR__;
        $this->fileDownloader = new FileDownloader($this->projectDir);
    }

    public function testReadFile()
    {
        $filePath = $this->projectDir.FileDownloader::PUBLIC_DIR.'test.txt';

        file_put_contents($filePath, 'Test content');

        $response = $this->fileDownloader->readFile('test.txt');

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('Test content', $response->getContent());

        // Clean up
        unlink($filePath);
    }

    public function testDownloadFile()
    {
        $filePath = $this->projectDir.FileDownloader::PUBLIC_DIR.'test.txt';
        file_put_contents($filePath, 'Test content');

        $response = $this->fileDownloader->downloadFile('test.txt', 'newname.txt');

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertStringContainsString(
            'attachment;filename="newname.txt"',
            $response->headers->get('Content-Disposition')
        );

        // Clean up
        unlink($filePath);
    }

    public function testDownloadStreamedResponse()
    {
        $streamedResponse = new StreamedResponse();

        $response = $this->fileDownloader->downloadStreamedResponse($streamedResponse, 'downloadedFile.txt');

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/force-download', $response->headers->get('Content-Type'));
        $this->assertStringContainsString(
            'attachment;filename="downloadedFile.txt"',
            $response->headers->get('Content-Disposition')
        );
    }

    public function testGetFileExtensionFromUrl()
    {
        $url = 'http://example.com/file.txt';
        $extension = $this->fileDownloader->getFileExtensionFromUrl($url);

        $this->assertEquals('txt', $extension);
    }

    public function testInvalidReadFile()
    {
        $this->expectException(\Exception::class);
        $this->fileDownloader->readFile('nonexistent.txt');
    }

    public function testInvalidDownloadFile()
    {
        $this->expectException(\Exception::class);
        $this->fileDownloader->downloadFile('nonexistent.txt');
    }
}
