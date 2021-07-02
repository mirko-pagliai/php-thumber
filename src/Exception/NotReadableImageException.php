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
namespace Thumber\Exception;

use Exception;
use Tools\Exception\NotReadableException;

/**
 * NotReadableImageException
 */
class NotReadableImageException extends NotReadableException
{
    /**
     * Construct the exception
     * @param string $message The string of the error message
     * @param int $code The exception code
     * @param int $severity The severity level of the exception
     * @param string $filename The filename where the exception is thrown
     * @param int $lineno The line number where the exception is thrown
     * @param \Exception|null $previous The previous exception used for the exception chaining
     * @param string|null $path Path of the not readable image
     */
    public function __construct(string $message = '', int $code = 0, int $severity = E_ERROR, string $filename = '__FILE__', int $lineno = __LINE__, ?Exception $previous = null, ?string $path = null)
    {
        if (!$message) {
            $message = $path ? sprintf('Unable to read image from `%s`', $path) : 'Unable to read image from file';
        }

        parent::__construct($message, $code, $severity, $filename, $lineno, $previous, $path);
    }
}
