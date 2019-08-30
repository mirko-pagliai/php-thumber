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
namespace PhpThumber\TestSuite;

use Exception;
use PhpThumber\TestSuite\TestTrait;
use PhpThumber\ThumbsPathTrait;
use Tools\TestSuite\TestCase as BaseTestCase;

/**
 * TestCase class
 */
abstract class TestCase extends BaseTestCase
{
    use TestTrait, ThumbsPathTrait;

    /**
     * Called after every test method
     * @return void
     */
    public function tearDown()
    {
        try {
            unlink_recursive(THUMBER_TARGET);
        } catch (Exception $e) {
        }

        parent::tearDown();
    }
}
