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
namespace Thumber\TestSuite;

use Thumber\ThumbCreator;
use Tools\Filesystem;
use Tools\TestSuite\TestTrait as ToolsTestTrait;

/**
 * TestCase trait
 */
trait TestTrait
{
    use ToolsTestTrait;

    /**
     * Internal method to create a copy of an image file
     * @param string $path Image file path
     * @return string
     */
    protected static function createCopy(string $path): string
    {
        $Filesystem = new Filesystem();
        $result = $Filesystem->createTmpFile();
        $Filesystem->copy($path, $result, true);

        return $result;
    }

    /**
     * Internal method to create some thumbs
     * @return void
     * @throws \ErrorException
     */
    protected function createSomeThumbs(): void
    {
        $this->getThumbCreatorInstance('400x400.jpg')->resize(200)->save();
        $this->getThumbCreatorInstance('400x400.jpg')->resize(300)->save();
        $this->getThumbCreatorInstance('400x400.png')->resize(200)->save();
    }

    /**
     * Asserts that the contents of one image file is equal to the contents of another image file
     * @param string $expected Expected file
     * @param string $actual Actual file
     * @param string $message The failure message that will be appended to the generated message
     * @return void
     */
    public static function assertImageFileEquals(string $expected, string $actual, string $message = ''): void
    {
        $Filesystem = new Filesystem();

        $expected = $Filesystem->makePathAbsolute($expected, THUMBER_COMPARING_DIR);
        self::assertFileExists($expected, $message);
        self::assertFileExists($actual, $message);

        $expectedCopy = self::createCopy($expected);
        $actualCopy = self::createCopy($actual);
        $message = $message ?: sprintf('The file `%s` is not what you expected', $expected);
        self::assertSame(md5_file($expectedCopy), md5_file($actualCopy), $message);

        $Filesystem->remove([$expectedCopy, $actualCopy]);
    }

    /**
     * Asserts that an image file has `$expectedWidth` and `$expectedHeight`
     * @param int $expectedWidth Expected image width
     * @param int $expectedHeight Expected mage height
     * @param string $filename Path to the tested file
     * @param string $message The failure message that will be appended to the generated message
     * @return void
     */
    public function assertImageSize(int $expectedWidth, int $expectedHeight, string $filename, string $message = ''): void
    {
        self::assertFileExists($filename);
        [$actualWidth, $actualHeight] = getimagesize($filename) ?: [0 => 0, 1 => 0];
        self::assertEquals($actualWidth, $expectedWidth, $message);
        self::assertEquals($actualHeight, $expectedHeight, $message);
    }

    /**
     * Asserts for a valid thumbnail path
     * @param string $path Thumbnail path
     * @param string $message The failure message that will be appended to the generated message
     * @return void
     */
    public function assertThumbPath(string $path, string $message = ''): void
    {
        $regex = sprintf('/^%s[\w\d_]+\.\w{3,4}/', preg_quote(Filesystem::instance()->addSlashTerm(THUMBER_TARGET), DS));
        self::assertMatchesRegularExpression($regex, $path, $message);
    }

    /**
     * Returns an instance of `ThumbCreator`
     * @param string $path Path of the image from which to create the thumbnail. It can be a relative path (to
     *  `APP/webroot/img`), a full path or a remote url
     * @return \Thumber\ThumbCreator
     */
    protected function getThumbCreatorInstance(string $path = ''): ThumbCreator
    {
        $path = Filesystem::instance()->makePathAbsolute($path ?: '400x400.jpg', THUMBER_EXAMPLE_DIR);

        return new ThumbCreator($path);
    }

    /**
     * Returns an instance of `ThumbCreator`, after calling `resize()` and `save()` methods.
     *
     * It can be called passing only the array of options as first argument.
     * @param string $path Path of the image from which to create the thumbnail. t can be a full path or a remote url
     * @param array $options Options for saving
     * @return \Thumber\ThumbCreator
     * @throws \ErrorException
     */
    protected function getThumbCreatorInstanceWithSave(string $path = '', array $options = []): ThumbCreator
    {
        $ThumbCreator = $this->getThumbCreatorInstance($path);
        $ThumbCreator->resize(200)->save($options);

        return $ThumbCreator;
    }

    /**
     * Skips the test if you're running the designated driver
     * @param string $driver Driver name
     * @param string $message The message to display
     * @return bool
     */
    public function skipIfDriverIs(string $driver, string $message = ''): bool
    {
        return $this->skipIf($driver == THUMBER_DRIVER, $message);
    }
}
