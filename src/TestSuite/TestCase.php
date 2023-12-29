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
namespace Thumber\TestSuite;

use Tools\Filesystem;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * TestCase class
 */
abstract class TestCase extends PHPUnitTestCase
{
    use TestTrait;

    /**
     * Called after every test method
     * @return void
     * @throws \Throwable
     */
    protected function tearDown(): void
    {
        Filesystem::instance()->unlinkRecursive(THUMBER_TARGET);

        parent::tearDown();
    }
}
