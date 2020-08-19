# 1.x branch
## 1.1 branch
### 1.1.2
* `UnsupportedImageTypeException` extends now `InvalidValueException`. The
    `getImageType()` method is deprecated, use `getValue()` instead;
* updated for `php-tools` 1.4.1.

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
