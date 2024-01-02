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
namespace Thumber\Test;

use Thumber\TestSuite\TestCase;

/**
 * This class helps in testing the `skip()` methods
 */
class SkipTestCase extends TestCase
{
    /**
     * Test that a test is marked as skipped if the driver is `gd`
     * @test
     * @uses \Thumber\TestSuite\TestTrait::skipIfDriverIs()
     */
    public function testSkipIfDriverIsGd(): void
    {
        $this->skipIfDriverIs('gd');
        $this->assertTrue(true);
    }

    /**
     * Test that a test is marked as skipped if the driver is `imagick`
     * @test
     * @uses \Thumber\TestSuite\TestTrait::skipIfDriverIs()
     */
    public function testSkipIfDriverIsImagick(): void
    {
        $this->skipIfDriverIs('imagick');
        $this->assertTrue(true);
    }
}
