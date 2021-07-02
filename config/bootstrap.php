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

use Tools\Filesystem;

//Default thumbnails driver
if (!defined('THUMBER_DRIVER')) {
    define('THUMBER_DRIVER', extension_loaded('imagick') ? 'imagick' : 'gd');
}
if (!in_array(THUMBER_DRIVER, ['imagick', 'gd'])) {
    trigger_error(sprintf('The driver `%s` is not supported', THUMBER_DRIVER), E_USER_ERROR);
}

//Default thumbnails directory
if (!defined('THUMBER_TARGET')) {
    define('THUMBER_TARGET', Filesystem::instance()->concatenate(defined('TMP') ? TMP : sys_get_temp_dir(), 'php-thumber', 'thumbs'));
}
if (!file_exists(THUMBER_TARGET)) {
    mkdir(THUMBER_TARGET, 0777, true);
}
if (!is_dir(THUMBER_TARGET) || !is_writeable(THUMBER_TARGET)) {
    trigger_error(sprintf('The directory `%s` is not writable or is not a directory', THUMBER_TARGET), E_USER_ERROR);
}
