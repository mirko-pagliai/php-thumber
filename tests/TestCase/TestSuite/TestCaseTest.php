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

use Exception;
use PhpThumber\TestSuite\TestCase;
use PhpThumber\ThumbCreator;

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