<?php
/** @noinspection PhpUnhandledExceptionInspection */
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
namespace Thumber\Test;

use Intervention\Image\Exception\NotReadableException as InterventionNotReadableException;
use Intervention\Image\ImageManager;
use Thumber\Exception\NotReadableImageException;
use Thumber\Exception\UnsupportedImageTypeException;
use Thumber\TestSuite\TestCase;
use Tools\TestSuite\ReflectionTrait;

/**
 * ThumbCreatorTest class
 */
class ThumbCreatorTest extends TestCase
{
    use ReflectionTrait;

    /**
     * Test for `__construct()` method, passing a no existing file
     * @test
     * @uses \Thumber\ThumbCreator::__construct()
     */
    public function testConstructNoExistingFile(): void
    {
        $this->expectExceptionMessageMatches('/^File or directory `[\w\-\/\.]+` is not readable$/');
        $this->getThumbCreatorInstance('noExistingFile.gif');
    }

    /**
     * Test for `getImageInstance()` method, with a not readable image
     * @test
     * @uses \Thumber\ThumbCreator::getImageInstance()
     */
    public function testGetImageInstanceNotReadableImageException(): void
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
     * @test
     * @uses \Thumber\ThumbCreator::getImageInstance()
     */
    public function testGetImageInstanceUnsupportedImageType(): void
    {
        $this->expectException(UnsupportedImageTypeException::class);
        $this->expectExceptionMessage('Image type `image/jpeg` is not supported by this driver');
        $exception = new InterventionNotReadableException('Unsupported image type. GD driver is only able to decode JPG, PNG, GIF or WebP files.');
        $thumbCreator = $this->getThumbCreatorInstance();
        $thumbCreator->ImageManager = $this->createPartialMock(ImageManager::class, ['make']);
        $thumbCreator->ImageManager->method('make')->willThrowException($exception);
        $this->invokeMethod($thumbCreator, 'getImageInstance');
    }
}
