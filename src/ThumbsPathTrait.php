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

/**
 * This trait provides some methods to get and resolve thumbnails paths.
 */
trait ThumbsPathTrait
{
    /**
     * Gets a path for a thumbnail.
     *
     * Called with the `$file` argument, returns the file absolute path.
     * Otherwise, called with `null`, returns the path of the target directory.
     * @param string|null $file File
     * @return string
     */
    protected function getPath($file = null)
    {
        $path = add_slash_term(THUMBER_TARGET);

        return $file ? $path . DS . $file : $path;
    }

    /**
     * Internal method to resolve a partial file path
     * @param string $path Partial file path
     * @return string
     */
    protected function resolveFilePath($path)
    {
        if (!is_url($path)) {
            is_readable_or_fail($path);
        }

        return $path;
    }
}
