<?php

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-02-23 at 12:11:02.
 */
class SessionFactoryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \Mmf\Parameter\SessionFactory
     */
    protected $object;

    public static function setUpBeforeClass() {
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Mmf\Parameter\SessionFactory;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers \Mmf\Parameter\SessionFactory::createSession
     * @group parameter
     * @group modules
     * @group development
     * @group production
     */
    public function testCreateMmfSession() {
        $Session = $this->object->createSession();
        $this->assertEquals('Mmf\Parameter\Session',get_class($Session));
    }

}
