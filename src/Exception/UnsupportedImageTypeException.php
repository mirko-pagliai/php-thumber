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

use Tools\InvalidValueException;

/**
 * UnsupportedImageTypeException
 */
class UnsupportedImageTypeException extends InvalidValueException
{
    /**
     * Constructor
     * @param string|null $message The string of the error message
     * @param int $code The exception code
     * @param int $severity The severity level of the exception
     * @param string $filename The filename where the exception is thrown
     * @param int $lineno The line number where the exception is thrown
     * @param \Exception|null $previous The previous exception used for the exception chaining
     * @param mixed $value The value that throwed the exception
     */
    public function __construct($message = '', $code = 0, $severity = E_ERROR, $filename = '__FILE__', $lineno = __LINE__, \Exception $previous = null, $value = null)
    {
        if (!$message) {
            $message = $value ? sprintf('Image type `%s` is not supported by this driver', $value) : 'Image type not supported by this driver';
        }

        parent::__construct($message, $code, $severity, $filename, $lineno, $previous, $value);
    }

    /**
     * Gets the unsupported image type
     * @return string|null
     * @deprecated use `getValue()` instead
     */
    public function getImageType()
    {
        deprecationWarning('Use `getValue()` instead');

        return $this->getValue();
    }
}
