# 1.x branch
## 1.5 branch
### 1.5.1
* little fixes for `phpstan`, `psalm` and for the `composer.json` file.

### 1.5.0
* requires at least PHP 7.4 and PHPUnit 9.1. Updated the code with the new
    features introduced by php 7.4.

## 1.4 branch
### 1.4.3
* added tests for PHP 8.1;
* little fixes.

### 1.4.2
* migration to github actions.

### 1.4.1
* fixed little bug for `ThumbCreator::fit()` method.

### 1.4.0
* all methods from `ThumbCreator` (`crop()`, `fit()`, `resize()`, `resizeCanvas()`)
    now only accept integers for width and height (and no longer `null`). The
    height is still optional;
* checks that the `x` and `y` options of the `ThumbCreator::crop()` are integers;
* improved the error message for `assertImageFileEquals()` method;
* increased the level of `phpstan`;
* fixed bootstrap, `mkdir` errors are no longer suppressed
    (see [issue 18](//github.com/mirko-pagliai/php-thumber/issues/18));
* some little fixes, improvement of descriptions and tags.

## 1.3 branch
### 1.3.0
* `UnsupportedImageTypeException::getImageType()` was deprecated and has now been
    removed. Use `getValue()` instead;
* updated for `php-tools` 1.5.

## 1.2 branch
### 1.2.3
* ready for `php` 8;
* some little fixes.

### 1.2.2
* `getThumbCreatorInstanceWithSave()` and `getThumbCreatorInstance()` methods
    provides by `TestTrait` only take a string as first argument, no longer `null`
    or an array;
* ready for `phpunit` 9;
* extensive improvement of function descriptions and tags.

### 1.2.1
* updated for `php-tools` 1.4.5;
* added `phpstan`, so fixed some code.

### 1.2.0
* requires at least PHP 7.2.5;
* `UnsupportedImageTypeException` extends now `InvalidValueException`. The
    `getImageType()` method is deprecated, use `getValue()` instead;
* updated for `php-tools` 1.4.1.

## 1.1 branch
### 1.1.1
* little fixes.

### 1.1.0
* `ThumbManager::clear()` and `ThumbManager::clearAll()` can return `null`;
* updated for `php` 7.1 and `phpunit` 8.

## 1.0 branch
### 1.0.1
* fixed lowest dependencies;
* little fixes;
* added [APIs](//mirko-pagliai.github.io/php-thumber).

### 1.0.0
* first release.
