# php-thumber

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)
[![CI](https://github.com/mirko-pagliai/php-thumber/actions/workflows/ci.yml/badge.svg)](https://github.com/mirko-pagliai/php-thumber/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/mirko-pagliai/php-thumber/branch/master/graph/badge.svg)](https://codecov.io/gh/mirko-pagliai/php-thumber)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/afadd01c29e141d28b22549c030bb7f5)](https://www.codacy.com/app/mirko.pagliai/php-thumber?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=mirko-pagliai/php-thumber&amp;utm_campaign=Badge_Grade)
[![CodeFactor](https://www.codefactor.io/repository/github/mirko-pagliai/php-thumber/badge)](https://www.codefactor.io/repository/github/mirko-pagliai/php-thumber)

*php-thumber* is a PHP library for creating thumbnails on the fly and it implements a file cache for thumbnails.
It uses [intervention/image](https://github.com/Intervention/image), working as wrapper.

Did you like this plugin? Its development requires a lot of time for me.
Please consider the possibility of making [a donation](//paypal.me/mirkopagliai): even a coffee is enough! Thank you.

[![Make a donation](https://www.paypalobjects.com/webstatic/mktg/logo-center/logo_paypal_carte.jpg)](//paypal.me/mirkopagliai)

***
  * [Requirements and supported formats](#requirements-and-supported-formats)
  * [Installation and configuration](#installation-and-configuration)
    + [Installation on older PHP versions](#installation-on-older-php-versions)
      - [For PHP 7.2 or later](#for-php-72-or-later)
      - [For PHP 5.6 or later](#for-php-56-or-later)
  * [How to use](#how-to-use)
  * [Testing](#testing)
  * [Versioning](#versioning)

## Requirements and supported formats
*php-thumber* requires GD Library (>=2.0) **or** Imagick PHP extension
(>=6.5.7).

It's **highly preferable** to use Imagick, because It provides better
performance and a greater number of supported formats.

Supported formats may vary depending on the library used.

|         | JPEG | PNG | GIF | TIF | BMP | ICO | PSD |
|---------|------|-----|-----|-----|-----|-----|-----|
| GD      | Yes  | Yes | Yes | No  | No  | No  | No  |
| Imagick | Yes  | Yes | Yes | Yes | Yes | Yes | Yes |

For more information about supported format, please refer to the
[Intervention Image documentation](http://image.intervention.io/getting_started/formats).

## Installation and configuration
You can install the plugin via composer:
```bash
$ composer require --prefer-dist mirko-pagliai/php-thumber
```

Therefore, before using the library, it may be necessary to configure some constants:

*   `THUMBER_DRIVER`: the driver you want to use for the creation of thumbnails. Valid values are `imagick` or `gd`;
*   `THUMBER_TARGET`: full path directory where to create thumbnails (so you have to create this directory and make it writable).

An example:
```php
define('THUMBER_DRIVER', 'imagick');
define('THUMBER_TARGET', '/tmp/php-thumber');
```

Otherwise, you can include/require the [`config/bootstrap.php`](https://github.com/mirko-pagliai/php-thumber/blob/master/config/bootstrap.php) file, which will auto-determine the driver to use and set a temporary directory where to create thumbnails (on Unix environment, it will be `/tmp/php-thumber`).

### Installation on older PHP versions
Recent packages and the master branch require at least PHP 7.4 and the current
development of the code is based on these and later versions of PHP.
However, there are still some branches compatible with previous versions of PHP.

#### For PHP 7.2 or later
The [php7.2](//github.com/mirko-pagliai/php-thumber/tree/php7.2) branch
requires at least PHP 7.2.

In this case, you can install the package as well:
```bash
$ composer require --prefer-dist mirko-pagliai/php-thumber:dev-php7.2
```

Note that the `php7.2` branch will no longer be updated as of April 28, 2022,
except for security patches, and it matches the
[1.4.3](https://github.com/mirko-pagliai/php-thumber/releases/tag/1.4.3) version.

#### For PHP 5.6 or later
The [php5.6](//github.com/mirko-pagliai/php-thumber/tree/php5.6) branch
requires at least PHP 5.6.

In this case, you can install the package as well:
```bash
$ composer require --prefer-dist mirko-pagliai/php-thumber:dev-php5.6
```

Note that the `php5.6` branch will no longer be updated as of April 22, 2021,
except for security patches, and it matches the
[1.2.3](https://github.com/mirko-pagliai/php-thumber/releases/tag/1.2.3) version.

## How to use
See our wiki:
*   [How to use ThumbCreator and create thumbnails](https://github.com/mirko-pagliai/php-thumber/wiki/How-to-use-ThumbCreator-and-create-thumbnails).

Refer to our [API](//mirko-pagliai.github.io/php-thumber).

## Testing
Some tests belong to the `imageEquals` group. These tests generate thubnails and compare them with pre-loaded thumbnails (inside `tests/examples/comparing_files`).
By default, these tests are not performed, because the images may be different if generated from different environments and systems.

To exclude these tests, you should run:
```bash
vendor/bin/phpunit --exclude-group imageEquals
```

## Versioning
For transparency and insight into our release cycle and to maintain backward
compatibility, *php-thumber* will be maintained under the
[Semantic Versioning guidelines](http://semver.org).
