<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
gc_disable();

class CommunicationHttpTest extends PHPUnit_Framework_TestCase {

    /**
     * @var CommunicationHttp
     */
    protected $object;

    public static function setUpBeforeClass() {
        //include_once __DIR__.'/../include.php';
    }
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new \Mmf\IO\CommunicationHttp;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers MmfCommunicationHttp::route
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testRoute() {
        $host                   = 'testhost';
        $uri                    = '/test.php?varname=asdf&varnmae2=asdf';
        $_SERVER['HTTP_HOST']   = $host;
        $_SERVER['REQUEST_URI'] = $uri;
        
        $route = $this->object->route();
        $this->assertEquals($uri, $route);
    }
    
    /**
     * @covers MmfCommunicationHttp::setRoute
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testSetRoute() {
        $host                   = 'testhost1';
        $uri                    = '/test.php?varname=asdf&varnmae2=asdf1';
        $this->object->setRoute($host.$uri);
        
        $route = $this->object->route();
        $this->assertEquals($host.$uri, $route);
    }

}
