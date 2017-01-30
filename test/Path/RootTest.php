<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tomaskraus\PathUtils\Test;

use Tomaskraus\PathUtils\Path;

/**
 * Description of PathTest
 *
 * @author Tomáš
 */
class PathTest extends \PHPUnit_Framework_TestCase {

    protected $p;
    const ROOT_PATH = "/myAppRoot";

    protected function setUp()
    {
        $this->p = new Path(self::ROOT_PATH);
        //plain root path
        $this->pp = new Path();
    }

    public function test_no_added_path() {
        $this->assertEquals(self::ROOT_PATH, $this->p->root());
        $this->assertEquals("", $this->pp->root());
    }

    public function test_non_empty_added_path() {
        $this->assertEquals(self::ROOT_PATH . "/user/login.php", $this->p->root("user/login.php"));
        $this->assertEquals("user/login.php", $this->pp->root("user/login.php"));
    }

}
