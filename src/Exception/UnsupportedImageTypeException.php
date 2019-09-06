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
namespace Tools\Thumber\Exception;

use Exception;

/**
 * UnsupportedImageTypeException
 */
class UnsupportedImageTypeException extends Exception
{
    /**
     * @var string|null
     */
    protected $imageType;

    /**
     * Construct the exception
     * @param string|null $message The Exception message to throw
     * @param int $code The Exception code
     * @param \Throwable|null $previous The previous exception used for the exception chaining
     * @param string|null $imageType The unsupported image type
     * @uses $imageType
     */
    public function __construct(?string $message = null, int $code = 0, ?\Throwable $previous = null, ?string $imageType = null)
    {
        if (!$message) {
            $message = 'Image type not supported by this driver';
            if ($imageType) {
                $message = sprintf('Image type `%s` is not supported by this driver', $imageType);
            }
        }

        parent::__construct($message, $code, $previous);
        $this->imageType = $imageType;
    }

    /**
     * Gets the unsupported image type
     * @return string|null
     * @uses $imageType
     */
    public function getImageType(): ?string
    {
        return $this->imageType;
    }
}
