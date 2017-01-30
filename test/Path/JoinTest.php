<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tomaskraus\PathUtils\Test;

use Tomaskraus\PathUtils\Path;

/**
 * Description of PITest
 *
 * @author Tomáš
 */
class JoinTest extends \PHPUnit_Framework_TestCase {

    public function test_empty_if_both_args_are_null() {
        $this->assertEquals("", Path::join(null, null));
    }

    public function test_empty_if_arg_is_either_empty_or_null() {
        $this->assertEquals("", Path::join("", null));
        $this->assertEquals("", Path::join(null, ""));
        $this->assertEquals("", Path::join("", ""));
    }

    public function test_returns_first_if_second_is_empty() {
        $this->assertEquals("abc", Path::join("abc", null));
        $this->assertEquals("abc", Path::join("abc", ""));
    }

    public function test_returns_second_if_first_is_empty() {
        $this->assertEquals("abc", Path::join(null, "abc"));
        $this->assertEquals("abc", Path::join("", "abc"));

        $this->assertEquals("abc", Path::join(null, "/abc"));
        $this->assertEquals("abc", Path::join("", "/abc"));
    }

    public function test_returns_without_trailing_delimiter() {
        $this->assertEquals("abc", Path::join("abc/", null));
        $this->assertEquals("abc", Path::join("abc/", ""));

        $this->assertEquals("abc", Path::join(null, "abc/"));
        $this->assertEquals("abc", Path::join("", "abc/"));

        $this->assertEquals("abc", Path::join(null, "/abc/"));
        $this->assertEquals("abc", Path::join("", "/abc/"));
    }


    public function test_returns_delimiter_between_two_non_empty_args() {
        $this->assertEquals("abc/def", Path::join("abc", "def"));

        $this->assertEquals("abc/def", Path::join("abc/", "def"));
        $this->assertEquals("abc/def", Path::join("abc", "/def"));
        $this->assertEquals("abc/def", Path::join("abc/", "/def"));
    }

    public function test_preserve_root_delimiter_first_arg() {
        $this->assertEquals("/", Path::join("/", null));
        $this->assertEquals("/", Path::join("/", ""));

        $this->assertEquals("/abc", Path::join("/abc", ""));
        $this->assertEquals("/abc", Path::join("/abc", null));
        $this->assertEquals("/abc", Path::join("/abc/", ""));
        $this->assertEquals("/abc", Path::join("/abc/", null));

        $this->assertEquals("/abc", Path::join("/", "abc"));
        $this->assertEquals("/abc", Path::join("/", "/abc"));

        $this->assertEquals("/abc/d", Path::join("/abc", "d"));
        $this->assertEquals("/abc/d", Path::join("/abc", "/d"));
    }

    public function test_windows_delimiters() {
        $this->assertEquals("", Path::join("\\", null));
        $this->assertEquals("", Path::join("\\", ""));

        $this->assertEquals("abc", Path::join("\\abc", ""));
        $this->assertEquals("abc", Path::join("abc\\", null));
        $this->assertEquals("abc", Path::join("\\abc\\", ""));

        $this->assertEquals("c:\\abc\\d/e", Path::join("c:\\abc\\d", "e"));
        $this->assertEquals("c:\\abc\\d/e", Path::join("c:\\abc\\d", "/e"));
        $this->assertEquals("c:\\abc\\d/e", Path::join("c:\\abc\\d", "\\e"));

        $this->assertEquals("c:\\abc\\d/e", Path::join("c:\\abc\\d\\", "e"));
        $this->assertEquals("c:\\abc\\d/e", Path::join("c:\\abc\\d\\", "/e"));
        $this->assertEquals("c:\\abc\\d/e", Path::join("c:\\abc\\d\\", "\\e"));
    }
}

