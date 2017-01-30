<?php

namespace Tomaskraus\PathUtils;

/**
 * php-includer object
 *
 * @author Tomáš
 */
class Path {

    private $root;

    /**
     * creates a new instance of a path-manipulating object
     *
     * @param string|null $rootPath optional. root of your web application
     */
    public function __construct($rootPath = null) {
        if ($rootPath) {
            $this->root = $rootPath;
        } else {
            $this->root = "";
        }
    }

    /**
     * root path of your web application
     *
     * @param string|null $path optional. additional path
     * @return string your web application root path, with the additional path added to the end
     *
     * useful for constructing (even non-existent) paths belonging to your web application
     */
    public function root($path = null) {
        return self::join($this->root, $path);
    }

    /**
     * joins two (even non-existent) paths together
     *
     * @param string path1
     * @param string path2
     * @return string correct path (with auto inserted/deleted path separator)
     *
     * works correctly with linux-style paths with "/" separator
     * on Windows, mixed separator results may occur (but still works in php)
     *   example: joinPath("C:\\temp", "img\\click.png") returns "C:\\temp/img\\click.png"
     *   example: joinPath("C:\\temp\\", "img\\click.png") returns the same...
     */
    public static function join($path1, $path2) {
        $final_delim = "/";
        $win_delim = "\\";
        $root_delim = "/";

        $path1Orig = $path1;
        if (!$path1) {
            $path1 = "";
        }
        if (!$path2) {
            $path2 = "";
        }

        $path1 = trim($path1, $final_delim);
        $path2 = trim($path2, $final_delim);

        if (DIRECTORY_SEPARATOR == $win_delim) {
            //trim backslashes only in windows
            $path1 = trim($path1, $win_delim);
            $path2 = trim($path2, $win_delim);
        }


        $finalPath;
        if (!$path1 && !$path2) {
            $finalPath = "";
        } else if (!$path1) {
            $finalPath = $path2;
        } else if (!$path2) {
            $finalPath = $path1;
        } else {
            $finalPath = $path1 . $final_delim . $path2;
        }

        //preserve the root (Linux, Mac)
        $startChar = substr($path1Orig, 0, 1);
        if ($startChar == $root_delim) {
            $finalPath = $root_delim . $finalPath;
        }

        return $finalPath;
    }

}

