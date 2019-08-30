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
namespace PhpThumber;

use BadMethodCallException;
use Intervention\Image\Constraint;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use PhpThumber\Exception\NotReadableImageException;
use PhpThumber\Exception\UnsupportedImageTypeException;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Tools\Exception\NotWritableException;

/**
 * Utility to create a thumb.
 *
 * Please, refer to the `README` file to know how to use the utility and to
 * see examples.
 */
class ThumbCreator
{
    /**
     * `ImageManager` instance
     * @var \Intervention\Image\ImageManager
     */
    public $ImageManager;

    /**
     * Arguments that will be used to generate the name of the thumbnail.
     *
     * Every time you call a method that alters the final thumbnail, its
     * arguments must be added to this array, including the name of that method.
     * @var array
     */
    protected $arguments = [];

    /**
     * Callbacks that will be called by the `save()` method to create the
     * thumbnail
     * @var array
     */
    protected $callbacks = [];

    /**
     * Driver name
     * @var string
     */
    protected $driver;

    /**
     * Path of the file from which the thumbnail will be generated
     * @var string
     */
    protected $path;

    /**
     * Path of the generated thumbnail
     * @var string
     */
    protected $target;

    /**
     * Construct.
     * It sets the file path and extension.
     * @param string $path Path of the image from which to create the
     *  thumbnail. It can be a full path or a remote url
     * @uses $ImageManager
     * @uses $arguments
     * @uses $driver
     * @uses $path
     */
    public function __construct($path)
    {
        if (!is_url($path)) {
            is_readable_or_fail($path);
        }
        $this->driver = THUMBER_DRIVER;
        $this->ImageManager = new ImageManager(['driver' => $this->driver]);
        $this->path = $path;
        $this->arguments[] = $this->path;
    }

    /**
     * Internal method to get default options for the `save()` method
     * @param array $options Passed options
     * @param string|null $path Path to use
     * @return array Passed options added to the default options
     * @uses $path
     */
    protected function getDefaultSaveOptions(array $options = [], $path = null)
    {
        $options += [
            'format' => get_extension($path ?: $this->path),
            'quality' => 90,
            'target' => false,
        ];

        //Fixes some formats
        $options['format'] = preg_replace(['/^jpeg$/', '/^tif$/'], ['jpg', 'tiff'], $options['format']);

        return $options;
    }

    /**
     * Gets an `Image` instance
     * @return \Intervention\Image\Image
     * @throws \PhpThumber\Exception\NotReadableImageException
     * @throws \PhpThumber\Exception\UnsupportedImageTypeException
     * @uses $ImageManager
     * @uses $path
     */
    protected function getImageInstance()
    {
        try {
            $imageInstance = $this->ImageManager->make($this->path);
        } catch (NotReadableException $e) {
            if (string_starts_with($e->getMessage(), 'Unsupported image type')) {
                throw new UnsupportedImageTypeException('', 0, null, mime_content_type($this->path));
            }
            throw new NotReadableImageException('', 0, null, rtr($this->path));
        }

        return $imageInstance;
    }

    /**
     * Crops the image, cutting out a rectangular part of the image.
     *
     * You can define optional coordinates to move the top-left corner of the
     *  cutout to a certain position.
     * @param int|null $width Required width
     * @param int|null $heigth Required heigth
     * @param array $options Options for the thumbnail
     * @return \PhpThumber\ThumbCreator
     * @see https://github.com/mirko-pagliai/cakephp-thumber/wiki/How-to-uses-the-ThumbCreator-utility#crop
     * @uses $arguments
     * @uses $callbacks
     */
    public function crop($width = null, $heigth = null, array $options = [])
    {
        $heigth = $heigth ?: $width;
        $width = $width ?: $heigth;
        $options += ['x' => null, 'y' => null];

        //Adds arguments
        $this->arguments[] = [__FUNCTION__, $width, $heigth, $options];

        //Adds the callback
        $this->callbacks[] = function (Image $imageInstance) use ($width, $heigth, $options) {
            return $imageInstance->crop($width, $heigth, $options['x'], $options['y']);
        };

        return $this;
    }

    /**
     * Resizes the image, combining cropping and resizing to format image in a
     *  smart way. It will find the best fitting aspect ratio on the current
     *  image automatically, cut it out and resize it to the given dimension
     * @param int|null $width Required width
     * @param int|null $heigth Required heigth
     * @param array $options Options for the thumbnail
     * @return \PhpThumber\ThumbCreator
     * @see https://github.com/mirko-pagliai/cakephp-thumber/wiki/How-to-uses-the-ThumbCreator-utility#fit
     * @uses $arguments
     * @uses $callbacks
     */
    public function fit($width = null, $heigth = null, array $options = [])
    {
        $heigth = $heigth ?: $width;
        $width = $width ?: $heigth;
        $options += ['position' => 'center', 'upsize' => true];

        //Adds arguments
        $this->arguments[] = [__FUNCTION__, $width, $heigth, $options];

        //Adds the callback
        $this->callbacks[] = function (Image $imageInstance) use ($width, $heigth, $options) {
            return $imageInstance->fit($width, $heigth, function (Constraint $constraint) use ($options) {
                if ($options['upsize']) {
                    $constraint->upsize();
                }
            }, $options['position']);
        };

        return $this;
    }

    /**
     * Resizes the image
     * @param int|null $width Required width
     * @param int|null $heigth Required heigth
     * @param array $options Options for the thumbnail
     * @return \PhpThumber\ThumbCreator
     * @see https://github.com/mirko-pagliai/cakephp-thumber/wiki/How-to-uses-the-ThumbCreator-utility#resize
     * @uses $arguments
     * @uses $callbacks
     */
    public function resize($width = null, $heigth = null, array $options = [])
    {
        $options += ['aspectRatio' => true, 'upsize' => true];

        //Adds arguments
        $this->arguments[] = [__FUNCTION__, $width, $heigth, $options];

        //Adds the callback
        $this->callbacks[] = function (Image $imageInstance) use ($width, $heigth, $options) {
            return $imageInstance->resize($width, $heigth, function (Constraint $constraint) use ($options) {
                if ($options['aspectRatio']) {
                    $constraint->aspectRatio();
                }
                if ($options['upsize']) {
                    $constraint->upsize();
                }
            });
        };

        return $this;
    }

    /**
     * Resizes the boundaries of the current image to given width and height. An
     *  anchor can be defined to determine from what point of the image the
     *  resizing is going to happen. Set the mode to relative to add or subtract
     *  the given width or height to the actual image dimensions. You can also
     *  pass a background color for the emerging area of the image
     * @param int|null $width Required width
     * @param int|null $heigth Required heigth
     * @param array $options Options for the thumbnail
     * @return \PhpThumber\ThumbCreator
     * @see https://github.com/mirko-pagliai/cakephp-thumber/wiki/How-to-uses-the-ThumbCreator-utility#resizecanvas
     * @uses $arguments
     * @uses $callbacks
     */
    public function resizeCanvas($width, $heigth = null, array $options = [])
    {
        $options += ['anchor' => 'center', 'relative' => false, 'bgcolor' => '#ffffff'];

        //Adds arguments
        $this->arguments[] = [__FUNCTION__, $width, $heigth, $options];

        //Adds the callback
        $this->callbacks[] = function (Image $imageInstance) use ($width, $heigth, $options) {
            return $imageInstance->resizeCanvas($width, $heigth, $options['anchor'], $options['relative'], $options['bgcolor']);
        };

        return $this;
    }

    /**
     * Saves the thumbnail and returns its path
     * @param array $options Options for saving
     * @return string Thumbnail path
     * @see https://github.com/mirko-pagliai/cakephp-thumber/wiki/How-to-uses-the-ThumbCreator-utility#save
     * @throws \BadMethodCallException
     * @throws \Tools\Exception\NotWritableException
     * @uses getDefaultSaveOptions()
     * @uses getImageInstance()
     * @uses $arguments
     * @uses $callbacks
     * @uses $driver
     * @uses $path
     * @uses $target
     */
    public function save(array $options = [])
    {
        if (!$this->callbacks) {
            throw new BadMethodCallException(sprintf('No valid method called before the `save()` method'));
        }

        $options = $this->getDefaultSaveOptions($options);
        $target = $options['target'];

        if (!$target) {
            $this->arguments[] = [$this->driver, $options['format'], $options['quality']];

            $target = sprintf('%s_%s.%s', md5($this->path), md5(serialize($this->arguments)), $options['format']);
        } else {
            $optionsFromTarget = $this->getDefaultSaveOptions([], $target);
            $options['format'] = $optionsFromTarget['format'];
        }

        $target = is_absolute($target) ? $target : add_slash_term(THUMBER_TARGET) . $target;

        //Creates the thumbnail, if this does not exist
        if (!file_exists($target)) {
            $imageInstance = $this->getImageInstance();

            //Calls each callback
            foreach ($this->callbacks as $callback) {
                call_user_func($callback, $imageInstance);
            }

            $content = $imageInstance->encode($options['format'], $options['quality']);
            $imageInstance->destroy();
            try {
                (new Filesystem())->dumpFile($target, $content);
            } catch (IOException $e) {
                throw new NotWritableException(sprintf('Unable to create file `%s`', $target ? rtr($target) : ''));
            }
        }

        //Resets arguments and callbacks
        $this->arguments = $this->callbacks = [];

        return $this->target = $target;
    }
}
