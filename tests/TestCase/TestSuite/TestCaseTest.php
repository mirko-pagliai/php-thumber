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
namespace Thumber\Test\TestCase;

use Exception;
use PHPUnit\Framework\ExpectationFailedException;
use Thumber\TestSuite\TestCase;
use Thumber\ThumbCreator;

/**
 * TestCaseTest class
 */
class TestCaseTest extends TestCase
{
    /**
     * Test for `tearDown()` method
     * @test
     */
    public function testTearDown()
    {
        $test = $this->getMockBuilder(TestCaseTest::class)
            ->setMethods(['getPath'])
            ->getMock();

        $test->method('getPath')->willThrowException(new Exception());
        $this->assertNull($test->tearDown());
    }

    /**
     * Test for `assertImageFileEquals()` method
     * @test
     */
    public function testAssertImageFileEquals()
    {
        $original = THUMBER_EXAMPLE_DIR . '400x400.jpg';
        $copy = $this->createCopy($original);
        $this->assertImageFileEquals($original, $copy);
        @unlink($copy);

        $this->expectException(ExpectationFailedException::class);
        $this->assertImageFileEquals($original, create_tmp_file());
    }

    /**
     * Test for `getThumbCreatorInstance()` method
     * @test
     */
    public function testGetThumbCreatorInstance()
    {
        $this->assertInstanceOf(ThumbCreator::class, $this->getThumbCreatorInstance());
    }

    /**
     * Test for `getThumbCreatorInstanceWithSave()` method
     * @test
     */
    public function testGetThumbCreatorInstanceWithSave()
    {
        $this->assertInstanceOf(ThumbCreator::class, $this->getThumbCreatorInstanceWithSave());
    }
}
