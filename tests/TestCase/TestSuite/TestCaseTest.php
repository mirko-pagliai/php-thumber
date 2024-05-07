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
     * @var \Thumber\TestSuite\TestCase
     */
    protected TestCase $TestCase;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->TestCase ??= new class ('myTest') extends TestCase {
        };
    }

    /**
     * @test
     * @uses \Thumber\TestSuite\TestCase::assertImageFileEquals()
     */
    public function testAssertImageFileEquals(): void
    {
        $Filesystem = new Filesystem();

        $original = THUMBER_EXAMPLE_DIR . '400x400.jpg';
        $copy = $this->createCopy($original);
        $this->TestCase->assertImageFileEquals($original, $copy);

        $Filesystem->remove($copy);
        $this->expectException(ExpectationFailedException::class);
        $this->TestCase->assertImageFileEquals($original, $Filesystem->createTmpFile());
    }

    /**
     * @test
     * @uses \Thumber\TestSuite\TestCase::getThumbCreatorInstance()
     */
    public function testGetThumbCreatorInstance(): void
    {
        $this->assertInstanceOf(ThumbCreator::class, $this->TestCase->getThumbCreatorInstance());
    }

    /**
     * @test
     * @uses \Thumber\TestSuite\TestCase::getThumbCreatorInstanceWithSave()
     */
    public function testGetThumbCreatorInstanceWithSave(): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->assertInstanceOf(ThumbCreator::class, $this->TestCase->getThumbCreatorInstanceWithSave());
    }
}
