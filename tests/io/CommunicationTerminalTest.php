<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
gc_disable();

class CommunicationTerminalTest extends PHPUnit_Framework_TestCase {

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
        $this->object = new \Mmf\IO\CommunicationTerminal;
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
        $this->assertEquals(true, true);
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
