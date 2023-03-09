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
     * @var string[]
     */
    protected const SUPPORTED_FORMATS = ['bmp', 'gif', 'ico', 'jpg', 'png', 'psd', 'tiff'];

    /**
     * Internal method to clear thumbnails
     * @param array<string> $filenames Filenames
     * @return int Number of thumbnails deleted
     * @throws \Tools\Exception\NotReadableException
     */
    protected function _clear(array $filenames): int
    {
        array_walk($filenames, function (string $filename): void {
            $filename = Exceptionist::isReadable(Filesystem::instance()->concatenate(THUMBER_TARGET, $filename));
            Filesystem::instance()->remove($filename);
        });

        return count($filenames);
    }

    /**
     * Internal method to find thumbnails
     * @param string $pattern A pattern (a regexp, a glob, or a string)
     * @param bool $sort Whether results should be sorted
     * @return array<string, string> Filenames
     * @throws \Tools\Exception\MethodNotExistsException
     */
    protected function _find(string $pattern = '', bool $sort = false): array
    {
        $pattern = $pattern ?: sprintf('/[\d\w]{32}_[\d\w]{32}\.(%s)$/', implode('|', self::SUPPORTED_FORMATS));
        $finder = (new Finder())->files()->name($pattern)->in(THUMBER_TARGET);

        return objects_map(iterator_to_array($sort ? $finder->sortByName() : $finder), 'getFilename');
    }

    /**
     * Clears all thumbnails that have been generated from an image path
     * @param string $path Path of the original image
     * @return int Number of thumbnails deleted
     * @throws \Tools\Exception\FileNotExistsException|\Tools\Exception\NotReadableException|\Throwable
     */
    public function clear(string $path): int
    {
        return $this->_clear($this->get($path));
    }

    /**
     * Clears all thumbnails
     * @return int Number of thumbnails deleted
     * @throws \Tools\Exception\FileNotExistsException|\Tools\Exception\NotReadableException|\Throwable
     */
    public function clearAll(): int
    {
        return $this->_clear($this->getAll());
    }

    /**
     * Gets all thumbnails that have been generated from an image path
     * @param string $path Path of the original image
     * @param bool $sort Whether results should be sorted
     * @return array<string, string>
     * @throws \Tools\Exception\MethodNotExistsException|\Tools\Exception\NotReadableException
     */
    public function get(string $path, bool $sort = false): array
    {
        $pattern = sprintf('/%s_[\d\w]{32}\.(%s)$/', md5(Exceptionist::isReadable($path)), implode('|', self::SUPPORTED_FORMATS));

        return $this->_find($pattern, $sort);
    }

    /**
     * Gets all thumbnails
     * @param bool $sort Whether results should be sorted
     * @return array<string, string>
     * @throws \Tools\Exception\MethodNotExistsException
     */
    public function getAll(bool $sort = false): array
    {
        return $this->_find('', $sort);
    }
}
