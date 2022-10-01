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

use PHPUnit\Framework\ExpectationFailedException;
use Thumber\TestSuite\TestCase;
use Thumber\ThumbCreator;
use Tools\Filesystem;

/**
 * TestCaseTest class
 */
class TestCaseTest extends TestCase
{
    /**
     * Test for `assertImageFileEquals()` method
     * @test
     */
    public function testAssertImageFileEquals(): void
    {
        $Filesystem = new Filesystem();

        $original = THUMBER_EXAMPLE_DIR . '400x400.jpg';
        $copy = $this->createCopy($original);
        $this->assertImageFileEquals($original, $copy);

        $Filesystem->remove($copy);
        $this->expectException(ExpectationFailedException::class);
        $this->assertImageFileEquals($original, $Filesystem->createTmpFile());
    }

    /**
     * Test for `getThumbCreatorInstance()` method
     * @test
     */
    public function testGetThumbCreatorInstance(): void
    {
        $this->assertInstanceOf(ThumbCreator::class, $this->getThumbCreatorInstance());
    }

    /**
     * Test for `getThumbCreatorInstanceWithSave()` method
     * @test
     */
    public function testGetThumbCreatorInstanceWithSave(): void
    {
        $this->assertInstanceOf(ThumbCreator::class, $this->getThumbCreatorInstanceWithSave());
    }
}
