<?php

use Mmf\IO\RequestJson;
/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-02-20 at 23:55:01.
 */
class RequestJsonTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var RequestHtml
     */
    protected $object;

    public static function setUpBeforeClass() {
        //include_once __DIR__.'/../include.php';
    }

    /**
     * @covers \Mmf\IO\RequestJson::__construct
     * @covers \Mmf\IO\RequestJson::setBulkOfInputGivenArray
     */
    protected function setUp() {
        $this->object = new RequestJson();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers \Mmf\IO\RequestJson::__construct
     * @covers \Mmf\IO\RequestHtml::setBulkOfInputGivenArray
     * @covers \Mmf\IO\RequestHtml::input
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testSetInput() {
        $value              = 'test';
        $valueExpected      = 'test';
        $valueArray         = [1,2,[3]];
        $valueArrayExpected = [1,2,[3]];
        $valueNull          = '';
        $valueNullExpected  = null;
        $this->object->setInput('testValue',      $value);
        $this->object->setInput('testValueArray', $valueArray);
        $this->object->setInput('testValueNull',  $valueNull);

        $this->assertEquals($valueExpected,     $this->object->input('testValue'));
        $this->assertEquals($valueArrayExpected,$this->object->input('testValueArray'));
        $this->assertEquals($valueNullExpected, $this->object->input('testValueNull'));
    }

}
