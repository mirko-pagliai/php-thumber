<?php
/**
 * This file is part of php-thumber.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Mirko Pagliai
 * @link        https://github.com/mirko-pagliai/php-thumber
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
namespace PhpThumber\Test\TestCase;

use Intervention\Image\Exception\NotReadableException as InterventionNotReadableException;
use Intervention\Image\ImageManager;
use PhpThumber\Exception\NotReadableImageException;
use PhpThumber\Exception\UnsupportedImageTypeException;
use PhpThumber\TestSuite\TestCase;
use Tools\Exception\NotReadableException;

/**
 * ThumbCreatorTest class
 */
class ThumbCreatorTest extends TestCase
{
    /**
     * Test for `__construct()` method, passing a no existing file
     * @test
     */
    public function testConstructNoExistingFile()
    {
        $this->expectException(NotReadableException::class);
        $this->getThumbCreatorInstance('noExistingFile.gif');
    }

    /**
     * Test for `getImageInstance()` method, with a not readable image
     * @ŧest
     */
    public function testGetImageInstanceNotReadableImageException()
    {
        $expectedException = NotReadableImageException::class;
        $expectedExceptionMessage = 'Unable to read image from file `tests/bootstrap.php`';
        if (THUMBER_DRIVER != 'imagick') {
            $expectedException = UnsupportedImageTypeException::class;
            $expectedExceptionMessage = 'Image type `text/x-php` is not supported by this driver';
        }
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);
        $this->getThumbCreatorInstanceWithSave(TESTS . 'bootstrap.php');
    }

    /**
     * Test for `getImageInstance()` method, with unsupported image type for GD driver
     * @ŧest
     */
    public function testGetImageInstanceUnsupportedImageType()
    {
        $this->expectException(UnsupportedImageTypeException::class);
        $this->expectExceptionMessage('Image type `image/jpeg` is not supported by this driver');
        $exception = new InterventionNotReadableException('Unsupported image type. GD driver is only able to decode JPG, PNG, GIF or WebP files.');
        $thumbCreator = $this->getThumbCreatorInstance();
        $thumbCreator->ImageManager = $this->getMockBuilder(ImageManager::class)
            ->setMethods(['make'])
            ->getMock();
        $thumbCreator->ImageManager->method('make')->will($this->throwException($exception));
        $this->invokeMethod($thumbCreator, 'getImageInstance');
    }

    /**
     * Test for `$path` property
     * @ŧest
     */
    public function testPath()
    {
        //From remote
        $file = 'http://example.com.png';
        $thumber = $this->getThumbCreatorInstance($file);
        $this->assertEquals($this->getProperty($thumber, 'path'), $file);
    }
}
