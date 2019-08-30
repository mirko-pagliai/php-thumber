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

//Default thumbnails driver
if (!defined('THUMBER_DRIVER')) {
    define('THUMBER_DRIVER', 'imagick');
}
if (!in_array(THUMBER_DRIVER, ['imagick', 'gd'])) {
    trigger_error(sprintf('The driver `%s` is not supported', THUMBER_DRIVER), E_USER_ERROR);
}

//Default thumbnails directory
if (!defined('THUMBER_TARGET')) {
    define('THUMBER_TARGET', TMP . 'thumbs');
}
@mkdir(THUMBER_TARGET, 0777, true);
if (!is_writeable(THUMBER_TARGET)) {
    trigger_error(sprintf('Directory `%s` not writeable', THUMBER_TARGET), E_USER_ERROR);
}
