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
namespace PhpThumber\Test;

use PhpThumber\TestSuite\TestCase;
use PhpThumber\ThumbManager;
use Tools\Exception\NotReadableException;

/**
 * ThumbManagerTest class
 */
class ThumbManagerTest extends TestCase
{
    /**
     * @var \PhpThumber\ThumbManager
     */
    protected $ThumbManager;

    /**
     * Called before every test method
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->ThumbManager = new ThumbManager();

        $this->createSomeThumbs();
    }

    /**
     * Test for `clear()` method
     * @ŧest
     */
    public function testClear()
    {
        $this->assertEquals(2, $this->ThumbManager->clear(THUMBER_EXAMPLE_DIR . '400x400.jpg'));

        $this->createSomeThumbs();
        $this->assertEquals(1, $this->ThumbManager->clear(THUMBER_EXAMPLE_DIR . '400x400.png'));
    }

    /**
     * Test for `clear()` method, with error
     * @ŧest
     */
    public function testClearWithError()
    {
        $ThumbManager = $this->getMockBuilder(ThumbManager::class)
            ->setMethods(['get'])
            ->getMock();
        $ThumbManager->method('get')->will($this->returnValue(['noExisting']));
        $this->assertFalse($ThumbManager->clear('noExisting'));
    }

    /**
     * Test for `clearAll()` method
     * @ŧest
     */
    public function testClearAll()
    {
        $this->assertEquals(3, $this->ThumbManager->clearAll());
        $this->assertEmpty($this->ThumbManager->getAll());
    }

    /**
     * Test for `get()` method
     * @ŧest
     */
    public function testGet()
    {
        $this->assertCount(2, $this->ThumbManager->get(THUMBER_EXAMPLE_DIR . '400x400.jpg'));
        $this->assertCount(1, $this->ThumbManager->get(THUMBER_EXAMPLE_DIR . '400x400.png'));

        //With a no existing file
        $this->expectException(NotReadableException::class);
        $this->expectExceptionMessage('File or directory `noExisting` is not readable');
        $this->ThumbManager->get('noExisting');
    }

    /**
     * Test for `getAll()` method
     * @ŧest
     */
    public function testGetAll()
    {
        $result = $this->ThumbManager->getAll();
        $this->assertCount(3, $result);
        //With sorting is the same
        $this->assertEquals($result, $this->ThumbManager->getAll(true));
    }
}
