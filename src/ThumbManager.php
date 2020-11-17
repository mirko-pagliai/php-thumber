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
namespace Thumber;

use Symfony\Component\Finder\Finder;
use Tools\Exceptionist;
use Tools\Filesystem;

/**
 * A utility to manage thumbnails
 */
class ThumbManager
{
    /**
     * Supported formats
     * @var array
     */
    const SUPPORTED_FORMATS = ['bmp', 'gif', 'ico', 'jpg', 'png', 'psd', 'tiff'];

    /**
     * Internal method to clear thumbnails
     * @param array $filenames Filenames
     * @return int|null Number of thumbnails deleted or `null` in case of error
     */
    protected function _clear(array $filenames)
    {
        $count = 0;

        foreach ($filenames as $filename) {
            if (!@unlink((new Filesystem())->concatenate(THUMBER_TARGET, $filename))) {
                return null;
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
    protected function _find($pattern = null, $sort = false)
    {
        $pattern = $pattern ?: sprintf('/[\d\w]{32}_[\d\w]{32}\.(%s)$/', implode('|', self::SUPPORTED_FORMATS));
        $finder = (new Finder())->files()->name($pattern)->in(THUMBER_TARGET);

        if ($sort) {
            $finder = $finder->sortByName();
        }

        return objects_map(iterator_to_array($finder), 'getFilename');
    }

    /**
     * Clears all thumbnails that have been generated from an image path
     * @param string $path Path of the original image
     * @return int|null Number of thumbnails deleted or `null` in case of error
     * @uses _clear()
     * @uses get()
     */
    public function clear($path)
    {
        return $this->_clear($this->get($path));
    }

    /**
     * Clears all thumbnails
     * @return int|null Number of thumbnails deleted or `null` in case of error
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
     * @throws \Tools\Exception\FileNotExistsException
     * @throws \Tools\Exception\NotReadableException
     * @uses _find()
     */
    public function get($path, $sort = false)
    {
        Exceptionist::isReadable($path);
        $pattern = sprintf('/%s_[\d\w]{32}\.(%s)$/', md5($path), implode('|', self::SUPPORTED_FORMATS));

        return $this->_find($pattern, $sort);
    }

    /**
     * Gets all thumbnails
     * @param bool $sort Whether results should be sorted
     * @return array
     * @uses _find()
     */
    public function getAll($sort = false)
    {
        return $this->_find(null, $sort);
    }
}
