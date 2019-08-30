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
namespace PhpThumber;

use PhpThumber\ThumbsPathTrait;
use Symfony\Component\Finder\Finder;

/**
 * A utility to manage thumbnails
 */
class ThumbManager
{
    use ThumbsPathTrait;

    /**
     * Supported formats
     * @var array
     */
    protected const SUPPORTED_FORMATS = ['bmp', 'gif', 'ico', 'jpg', 'png', 'psd', 'tiff'];

    /**
     * Internal method to clear thumbnails
     * @param array $filenames Filenames
     * @return int|bool Number of thumbnails deleted otherwise `false` in case of error
     */
    protected function _clear(array $filenames)
    {
        $count = 0;

        foreach ($filenames as $filename) {
            if (!@unlink($this->getPath($filename))) {
                return false;
            }

            $count++;
        }

        return $count;
    }

    /**
     * Internal method to find thumbnails
     * @param string|null $pattern A pattern (a regexp, a glob, or a string)
     * @param bool $sort Whether results should be sorted
     * @return array
     */
    protected function _find(?string $pattern = null, bool $sort = false): array
    {
        $pattern = $pattern ?: sprintf('/[\d\w]{32}_[\d\w]{32}\.(%s)$/', implode('|', self::SUPPORTED_FORMATS));
        $finder = (new Finder())->files()->name($pattern)->in($this->getPath());

        if ($sort) {
            $finder = $finder->sortByName();
        }

        return objects_map(iterator_to_array($finder), 'getFilename');
    }

    /**
     * Clears all thumbnails that have been generated from an image path
     * @param string $path Path of the original image
     * @return int|bool Number of thumbnails deleted otherwise `false` in case of error
     * @uses _clear()
     * @uses get()
     */
    public function clear(string $path)
    {
        return $this->_clear($this->get($path));
    }

    /**
     * Clears all thumbnails
     * @return int|bool Number of thumbnails deleted otherwise `false` in case of error
     * @uses _clear()
     * @uses getAll()
     */
    public function clearAll()
    {
        return $this->_clear($this->getAll());
    }

    /**
     * Gets all thumbnails that have been generated from an image path
     * @param string $path Path of the original image
     * @param bool $sort Whether results should be sorted
     * @return array
     * @uses _find()
     */
    public function get(string $path, bool $sort = false): array
    {
        $pattern = sprintf('/%s_[\d\w]{32}\.(%s)$/', md5($this->resolveFilePath($path)), implode('|', self::SUPPORTED_FORMATS));

        return $this->_find($pattern, $sort);
    }

    /**
     * Gets all thumbnails
     * @param bool $sort Whether results should be sorted
     * @return array
     * @uses _find()
     */
    public function getAll(bool $sort = false): array
    {
        return $this->_find(null, $sort);
    }
}
