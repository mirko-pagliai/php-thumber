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

require_once 'vendor/autoload.php';

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('ROOT', dirname(__DIR__) . DS);
define('TESTS', ROOT . 'tests' . DS);
define('TMP', sys_get_temp_dir() . DS . 'php-thumber' . DS);

@mkdir(TMP, 0777, true);

//Default thumbnails driver
if (!defined('THUMBER_DRIVER') && getenv('THUMBER_DRIVER')) {
    define('THUMBER_DRIVER', getenv('THUMBER_DRIVER'));
}

require_once ROOT . 'config/bootstrap.php';

define('THUMBER_EXAMPLE_DIR', TESTS . 'examples' . DS);
define('THUMBER_COMPARING_DIR', THUMBER_EXAMPLE_DIR . 'comparing_files' . DS . THUMBER_DRIVER . DS);
echo 'Running tests for "' . THUMBER_DRIVER . '" driver ' . PHP_EOL;
