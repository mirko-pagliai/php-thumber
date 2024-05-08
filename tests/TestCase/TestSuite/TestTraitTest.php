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
namespace Thumber\Test\TestSuite;

use GdImage;
use PHPUnit\Framework\TestStatus\Skipped;
use PHPUnit\Framework\TestStatus\Success;
use Thumber\Test\SkipTestCase;
use Thumber\TestSuite\TestCase;

/**
 * TestTraitTest class
 */
class TestTraitTest extends TestCase
{
    /**
     * @test
     * @uses \Thumber\TestSuite\TestTrait::assertImageSize()
     */
    public function testAssertImageSize(): void
    {
        $resource = imagecreatetruecolor(120, 20);
        if (!$resource instanceof GdImage) {
            $this->fail('Unable to create a valid resource image');
        }
        imagejpeg($resource, TMP . 'pic.jpg');
        $TestCase = new class ('MyTest') extends TestCase {
            public function testSomeMethod() {
            }
        };

        $TestCase->assertImageSize(120, 20, TMP . 'pic.jpg');
    }

    /**
     * @test
     * @uses \Thumber\TestSuite\TestTrait::skipIfDriverIs()
     */
    public function testSkipIfDriverIs(): void
    {
        $expected = THUMBER_DRIVER === 'imagick' ? ['gd' => false, 'imagick' => true] : ['imagick' => false, 'gd' => true];

        foreach ($expected as $driver => $expectedIsSkipped) {
            $Test = (new SkipTestCase('testSkipIfDriverIs' . ucfirst($driver)));
            $Test->run();
            $this->assertInstanceOf($expectedIsSkipped ? Skipped::class : Success::class, $Test->status());
        }
    }
}
