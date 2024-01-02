<?php
/** @noinspection PhpDocMissingThrowsInspection,PhpUnhandledExceptionInspection */
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
use Thumber\ThumbManager;
use Tools\Filesystem;

/**
 * ThumbManagerTest class
 */
class ThumbManagerTest extends TestCase
{
    /**
     * @var \Thumber\ThumbManager
     */
    protected ThumbManager $ThumbManager;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        Filesystem::instance()->unlinkRecursive(THUMBER_TARGET);

        $this->ThumbManager ??= new ThumbManager();

        $this->createSomeThumbs();
    }

    /**
     * @test
     * @uses \Thumber\ThumbManager::clear()
     */
    public function testClear(): void
    {
        $this->assertEquals(2, $this->ThumbManager->clear(THUMBER_EXAMPLE_DIR . '400x400.jpg'));

        $this->createSomeThumbs();
        $this->assertEquals(1, $this->ThumbManager->clear(THUMBER_EXAMPLE_DIR . '400x400.png'));
    }

    /**
     * @test
     * @uses \Thumber\ThumbManager::clearAll()
     */
    public function testClearAll(): void
    {
        $this->assertEquals(3, $this->ThumbManager->clearAll());
        $this->assertEmpty($this->ThumbManager->getAll());
    }

    /**
     * @test
     * @uses \Thumber\ThumbManager::get()
     */
    public function testGet(): void
    {
        $this->assertCount(2, $this->ThumbManager->get(THUMBER_EXAMPLE_DIR . '400x400.jpg'));
        $this->assertCount(1, $this->ThumbManager->get(THUMBER_EXAMPLE_DIR . '400x400.png'));

        //With a no existing file
        $this->expectExceptionMessage('File or directory `noExisting` is not readable');
        $this->ThumbManager->get('noExisting');
    }

    /**
     * @test
     * @uses \Thumber\ThumbManager::getAll()
     */
    public function testGetAll(): void
    {
        $result = $this->ThumbManager->getAll();
        $this->assertCount(3, $result);
        //With sorting is the same
        $this->assertEquals($result, $this->ThumbManager->getAll(true));
    }
}
