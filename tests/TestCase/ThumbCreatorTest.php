<?php
declare(strict_types=1);

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
namespace Thumber\Test\TestCase;

use Intervention\Image\Exception\NotReadableException as InterventionNotReadableException;
use Intervention\Image\ImageManager;
use Thumber\Exception\NotReadableImageException;
use Thumber\Exception\UnsupportedImageTypeException;
use Thumber\TestSuite\TestCase;
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
        $expectedMessage = 'Unable to read image from `tests/bootstrap.php`';
        if (THUMBER_DRIVER != 'imagick') {
            $expectedException = UnsupportedImageTypeException::class;
            $expectedMessage = 'Image type `text/x-php` is not supported by this driver';
        }
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedMessage);
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
