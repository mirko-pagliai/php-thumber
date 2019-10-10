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
namespace Thumber\Test\Exception;

use Thumber\Exception\UnsupportedImageTypeException;
use Thumber\TestSuite\TestCase;

/**
 * UnsupportedImageTypeExceptionTest class
 */
class UnsupportedImageTypeExceptionTest extends TestCase
{
    /**
     * Test for the exception
     * @ŧest
     */
    public function testException()
    {
        try {
            throw new UnsupportedImageTypeException();
        } catch (UnsupportedImageTypeException $e) {
            $this->assertSame('Image type not supported by this driver', $e->getMessage());
            $this->assertNull($e->getImageType());
        }

        try {
            throw new UnsupportedImageTypeException('', 0, null, 'example');
        } catch (UnsupportedImageTypeException $e) {
            $this->assertSame('Image type `example` is not supported by this driver', $e->getMessage());
            $this->assertSame('example', $e->getImageType());
        }
    }
}
