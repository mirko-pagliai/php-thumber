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
namespace Thumber\Exception;

use Tools\Exception\NotReadableException;

/**
 * NotReadableImageException
 */
class NotReadableImageException extends NotReadableException
{
    /**
     * Construct the exception
     * @param string|null $message The Exception message to throw
     * @param int $code The Exception code
     * @param \Throwable|null $previous The previous exception used for the exception chaining
     * @param string|null $path Path of the not readable image
     */
    public function __construct($message = null, $code = 0, \Throwable $previous = null, $path = null)
    {
        if (!$message) {
            $message = 'Unable to read image from file';
            if ($path) {
                $message = sprintf('Unable to read image from file `%s`', $path);
            }
        }

        parent::__construct($message, $code, $previous, $path);
    }
}
