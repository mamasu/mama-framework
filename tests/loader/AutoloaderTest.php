<?php

use Mmf\Autoloader\Autoloader;
/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The MmfEventManager bla bla...
 *
 * Description
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class AutoloaderTest extends \PHPUnit_Framework_TestCase {

    protected static $prefix;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public static function setUpBeforeClass() {
        self::$prefix = __DIR__ . '/../../../src/';
        include_once __DIR__ . '/../include.php';
    }

    /**
     * @group loader
     * @group modules
     * @group development
     * @group production
     */
    public function testMKPFilesystem() {
        $autoloader = new Autoloader(array('controllers', 'models', 'entities'),self::$prefix.'loader');
        //$autoloader = new MmfAutoloader();
        $autoloader->addNewMmfAutoloadPath('/mktfilesystem/custom/reseller1/core');
        $autoloader->addNewMmfAutoloadPath('/mktfilesystem/base/core');

        $a = new Prova();
        $b = new Prova2();
        $c = new ProvaExtended();

        $this->assertEquals('custom/prova',  $a->test());
        $this->assertEquals('base/prova2',  $b->test());
        $this->assertEquals('custom/provaextended',  $c->test());

        unset($autoloader);
        unset($a);
        unset($b);
        unset($c);
    }

    /**
     * @group loader
     * @group modules
     * @group development
     * @group production
     */
    public function testMmfFilesystem() {
        $autoloader = new Autoloader(array('controllers', 'models', 'entities'),self::$prefix.'loader');
        //$autoloader = new MmfAutoloader();
        $autoloader->addNewMmfAutoloadPath('/mmffilesystem/');
        $autoloader->addNewAutoloadPath('/mmffilesystem/libs/libtest/');

        $a = new ProvaMmf();
        $b = new ProvaMmfEntities();
        $c = new ProvaLibtest();

        $this->assertEquals('mmf/controllers/prova',  $a->test());
        $this->assertEquals('mmf/entities/prova',  $b->test());
        $this->assertEquals('mmf/libs/ProvaLibtest',  $c->test());

        unset($autoloader);
        unset($a);
        unset($b);
        unset($c);
    }
}
