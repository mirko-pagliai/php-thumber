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

use Thumber\Test\SkipTestCase;
use Thumber\TestSuite\TestCase;

/**
 * TestTraitTest class
 */
class TestTraitTest extends TestCase
{
    /**
     * Test for `skipIfDriverIs()` method
     * @test
     */
    public function testSkipIfDriverIs(): void
    {
        $expected = THUMBER_DRIVER === 'imagick' ? ['gd' => 0, 'imagick' => 1] : ['imagick' => 0, 'gd' => 1];

        foreach ($expected as $driver => $skippedCount) {
            $test = new SkipTestCase('testSkipIfDriverIs' . ucfirst($driver));
            $this->assertSame($skippedCount, $test->run()->skippedCount());
        }
    }
}
