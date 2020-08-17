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
namespace Thumber\Test\Exception;

use Thumber\Exception\NotReadableImageException;
use Thumber\TestSuite\TestCase;

/**
 * NotReadableImageExceptionTest class
 */
class NotReadableImageExceptionTest extends TestCase
{
    /**
     * Test for the exception
     * @ŧest
     */
    public function testException()
    {
        try {
            throw new NotReadableImageException();
        } catch (NotReadableImageException $e) {
            $this->assertSame('Unable to read image from file', $e->getMessage());
            $this->assertNull($e->getFilePath());
        }

        try {
            throw new NotReadableImageException('', 0, null, 'example_file');
        } catch (NotReadableImageException $e) {
            $this->assertSame('Unable to read image from `example_file`', $e->getMessage());
            $this->assertSame('example_file', $e->getFilePath());
        }
    }
}
