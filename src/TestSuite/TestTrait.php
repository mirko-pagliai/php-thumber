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
namespace Tools\Thumber\TestSuite;

use Tools\Thumber\ThumbCreator;

/**
 * TestCase trait
 */
trait TestTrait
{
    /**
     * Internal method to create a copy of an image file
     * @param string $path Image file path
     * @return string
     */
    protected static function createCopy(string $path): string
    {
        $result = create_tmp_file();
        @copy($path, $result);

        return $result;
    }

    /**
     * Internal method to create some thumbs
     * @return void
     * @uses getThumbCreatorInstance()
     */
    protected function createSomeThumbs(): void
    {
        $this->getThumbCreatorInstance('400x400.jpg')->resize(200)->save();
        $this->getThumbCreatorInstance('400x400.jpg')->resize(300)->save();
        $this->getThumbCreatorInstance('400x400.png')->resize(200)->save();
    }

    /**
     * Asserts that the contents of one image file is equal to the contents of
     *  another image file
     * @param string $expected Expected file
     * @param string $actual Actual file
     * @param string $message The failure message that will be appended to the
     *  generated message
     * @return void
     * @uses createCopy()
     */
    public static function assertImageFileEquals(string $expected, string $actual, string $message = ''): void
    {
        $expected = is_absolute($expected) ? $expected : THUMBER_COMPARING_DIR . $expected;
        self::assertFileExists($expected, $message);
        self::assertFileExists($actual, $message);

        $expectedCopy = self::createCopy($expected);
        $actualCopy = self::createCopy($actual);
        self::assertFileEquals($expectedCopy, $actualCopy, $message);

        @array_map('unlink', [$expectedCopy, $actualCopy]);
    }

    /**
     * Asserts for a valid thumbnail path
     * @param string $path Thumbnail path
     * @param string $message The failure message that will be appended to the
     *  generated message
     * @return void
     */
    public function assertThumbPath(string $path, string $message = ''): void
    {
        $regex = sprintf('/^%s[\w\d_]+\.\w{3,4}/', preg_quote(add_slash_term(THUMBER_TARGET), DS));
        self::assertRegExp($regex, $path, $message);
    }

    /**
     * Returns an instance of `ThumbCreator`
     * @param string|null $path Path of the image from which to create the
     *  thumbnail. It can be a relative path (to APP/webroot/img), a full path
     *  or a remote url
     * @return \Tools\Thumber\ThumbCreator
     */
    protected function getThumbCreatorInstance(?string $path = null): ThumbCreator
    {
        $path = $path ?: '400x400.jpg';

        return new ThumbCreator(is_absolute($path) ? $path : THUMBER_EXAMPLE_DIR . $path);
    }

    /**
     * Returns an instance of `ThumbCreator`, after calling `resize()` and
     *  `save()` methods.
     *
     * It can be called passing only the array of options as first argument.
     * @param string|null|array $path Path of the image from which to create the
     *  thumbnail. It can be a full path or a remote url
     * @param array $options Options for saving
     * @return \Tools\Thumber\ThumbCreator
     * @uses getThumbCreatorInstance()
     */
    protected function getThumbCreatorInstanceWithSave($path = null, array $options = []): ThumbCreator
    {
        if (is_array($path) && func_num_args() < 2) {
            [$options, $path] = [$path, null];
        }

        $thumbCreator = $this->getThumbCreatorInstance($path);
        $thumbCreator->resize(200)->save($options);

        return $thumbCreator;
    }

    /**
     * Skips the test if you running the designated driver
     * @param string $driver Driver name
     * @param string $message The message to display
     * @return bool
     */
    public function skipIfDriverIs(string $driver, string $message = ''): bool
    {
        return parent::skipIf(THUMBER_DRIVER == $driver, $message);
    }
}
