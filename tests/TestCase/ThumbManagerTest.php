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
use Thumber\ThumbManager;
use Tools\Exception\NotReadableException;

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
     * Called before every test method
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->ThumbManager ??= new ThumbManager();

        $this->createSomeThumbs();
    }

    /**
     * Test for `clear()` method
     * @test
     */
    public function testClear(): void
    {
        $this->assertEquals(2, $this->ThumbManager->clear(THUMBER_EXAMPLE_DIR . '400x400.jpg'));

        $this->createSomeThumbs();
        $this->assertEquals(1, $this->ThumbManager->clear(THUMBER_EXAMPLE_DIR . '400x400.png'));
    }

    /**
     * Test for `clearAll()` method
     * @test
     */
    public function testClearAll(): void
    {
        $this->assertEquals(3, $this->ThumbManager->clearAll());
        $this->assertEmpty($this->ThumbManager->getAll());
    }

    /**
     * Test for `get()` method
     * @test
     */
    public function testGet(): void
    {
        $this->assertCount(2, $this->ThumbManager->get(THUMBER_EXAMPLE_DIR . '400x400.jpg'));
        $this->assertCount(1, $this->ThumbManager->get(THUMBER_EXAMPLE_DIR . '400x400.png'));

        //With a no existing file
        $this->expectException(NotReadableException::class);
        $this->expectExceptionMessage('File or directory `noExisting` does not exist');
        $this->ThumbManager->get('noExisting');
    }

    /**
     * Test for `getAll()` method
     * @test
     */
    public function testGetAll(): void
    {
        $result = $this->ThumbManager->getAll();
        $this->assertCount(3, $result);
        //With sorting is the same
        $this->assertEquals($result, $this->ThumbManager->getAll(true));
    }
}
