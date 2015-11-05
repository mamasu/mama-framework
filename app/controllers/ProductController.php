<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestController
 *
 * @author xavier
 */
class ProductController extends \Mmf\Controller\BasicControllerAbstract {
    public function testFunction($test, $foo, $var) {
        return $test.$foo.$var;
    }

    public function show($test, $foo, $var) {
        return array('1', 2, 4, $test.$foo.$var);
    }

    public function showProduct($test, $foo, $var='defaultvalue') {
        return array('1', 2, 4, $test.$foo.$var);
    }

    public function showProductBadResponse($test, $foo, $var) {
        throw new \Mmf\Controller\ControllerException('Message of bad response '.$test);
    }

}
