# 1.x branch
## 1.2 branch
### 1.2.2
* `TestTrait::getThumbCreatorInstanceWithSave()` only takes a string as its first
    argument, no longer `null` or an array;
* ready for `phpunit` 9.

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
