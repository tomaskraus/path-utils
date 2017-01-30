# path-utils

A simple PHP library for file system paths - smart path join, root path, and so on...

## features

smart path join, fixes missing or too many path separators, joins even non-existent paths
```php
Path::join("myapp/", "/dist/app.zip") );
// => "myapp/dist/app.zip"
```
application root path, with smart join
```php
$pth = new Path("/var/www/myApp/");
$pth->root(); // => "/var/www/myApp"

$pth->root("conf/local.php");
// => "/var/www/myapp/conf/local.php"
```

## Installation

Via composer:
```
composer require tomaskraus/path-utils
```
, or add this snippet to `composer.json`
```json
    "require": {
        "tomaskraus/path-utils": "^0.1"
    },
```

## Usage example:

Assume we have our php application in `/var/www/myApp`. A `/var/www/myApp` is our application root path.

```php
<?php
require "vendor/autoload.php";

use Tomaskraus\PathUtils\Path;

/* remember our web application root */
$pth = new Path("/var/www/myApp/");

/* one can use even a non-existent root path */
/* just acts as a prefix path */
$pth2 = new Path("foo");

var_dump( $pth->root() );
// => "/var/www/myApp"
//everything is returned without the trailing path separator

var_dump( $pth2->root() );
// => "foo"

/* we can create new, non-existing path strings, based on our web application root */
var_dump( $pth->root("conf/file-to-be-created.php") );
// => "/var/www/myapp/conf/file-to-be-created.php"

var_dump( $pth->root("/conf/file-to-be-created.php") );
// => "/var/www/myapp/conf/file-to-be-created.php"
// returns the same... smart path separator handling

/* another instance with the different root */
var_dump( $pth2->root("/conf/file-to-be-created.php") );
// => "foo/conf/file-to-be-created.php"


/* root() does not normalize paths */
var_dump( $pth->root("/../conf/file-to-be-created.php") );
// => "/var/www/myApp/../conf/file-to-be-created.php"

/* path-safe include, wherever you are */
include $pth->root("myLib/utils.php");
//includes /var/www/myapp/myLib/utils.php


/* Path::join does not normalize paths */
var_dump( Path::join("/var/www/myProject/", "./../otherProject") );
// => "/var/www/myProject/./../otherProject"

/* smart path join, fixes missing or too many path separators */
var_dump( Path::join("myapp/", "/dist/app.zip") );
// => "myapp/dist/app.zip"

var_dump( Path::join("/var/www", "dist/app.zip") );
// => "/var/www/dist/app.zip",
//preserves a root slash from the first parameter

/* join Windows path */
var_dump( Path::join("C:\\www\\", "/dist/app.zip") );
// => "C:\www/dist/app.zip",
// mixed result for Windows path (still works in PHP)

var_dump( Path::join("C:\\www", "dist/app.zip") );
// => the same "C:\www/dist/app.zip"

/* foldable */
var_dump( Path::join("a/b", Path::join("c/d", "e/f")) );
// => "a/b/c/d/e/f"

var_dump( Path::join("a/b/", Path::join("/c/d/", "/e/f/")) );
// => "a/b/c/d/e/f"
// smart path separator handling


```
