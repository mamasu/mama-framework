<?php

class CommunicationTerminalTest extends \PHPUnit_Framework_TestCase {

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
     * @covers \Mmf\IO\CommunicationTerminal::setRoute
     * @covers \Mmf\IO\CommunicationTerminal::route
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testRoute() {
        $host                   = 'testhost1';
        $uri                    = '/test.php?varname=asdf&varnmae2=asdf1';
        $this->object->setRoute($host.$uri);

        $route = $this->object->route();
        $this->assertEquals($host.$uri, $route);
    }

    /**
     * @covers \Mmf\IO\CommunicationTerminal::method
     * @covers \Mmf\IO\CommunicationTerminal::setMethod
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testMethod() {
        $uri                    = '/test.php?varname=asdf&varnmae2=asdf1';

        $this->object->setMethod($uri);
        $this->assertEquals($uri, $this->object->method());
    }

    /**
     * @covers \Mmf\IO\CommunicationTerminal::getTerminalRoute
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testGetTerminalRoute() {
        // TODO : get terminal route
        $this->assertEquals('', $this->object->route());
    }

}
