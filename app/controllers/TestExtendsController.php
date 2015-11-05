<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Controllers;

/**
 * Description of TestController
 *
 * @author xavier
 */
class TestExtendsController extends \Mmf\Controller\BasicControllerAbstract {
    public function testFunction($test=null, $foo, $var='test') {
        return $var;
    }

}
