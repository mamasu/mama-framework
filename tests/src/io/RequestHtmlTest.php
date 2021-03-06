<?php

use Mmf\IO\RequestHtml;
/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-02-20 at 23:55:01.
 */
class RequestHtmlTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var RequestHtml
     */
    protected $object;

    public static function setUpBeforeClass() {
        //include_once __DIR__.'/../include.php';
    }

    /**
     * @covers \Mmf\IO\RequestHtml::__construct
     * @covers \Mmf\IO\RequestHtml::setBulkOfInputGivenArray
     */
    protected function setUp() {
        $this->object = new RequestHtml;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers \Mmf\IO\RequestHtml::__construct
     * @covers \Mmf\IO\RequestHtml::setBulkOfInputGivenArray
     * @covers \Mmf\IO\RequestHtml::input
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testInput() {
        $value              = 'test';
        $valueExpected      = 'test';
        $valueArray         = [1,2,[3]];
        $valueArrayExpected = [1,2,[3]];
        $valueNull          = '';
        $valueNullExpected  = null;

        $_GET['testValue']      = $value;
        $_GET['testValueArray'] = $valueArray;
        $_GET['testValueNull']  = $valueNull;
        $_POST['postTestValue'] = $value;

        $request = new RequestHtml;

        $this->assertEquals($valueExpected,     $request->input('testValue'));
        $this->assertEquals($valueArrayExpected,$request->input('testValueArray'));
        $this->assertEquals($valueNullExpected, $request->input('testValueNull'));
        $this->assertEquals($valueExpected,     $request->input('postTestValue'));
        $this->assertEquals(null, $this->object->input('inputnotexists'), 'The var exist or the value is not null');
    }

    /**
     * @covers \Mmf\IO\RequestHtml::__construct
     * @covers \Mmf\IO\RequestHtml::setBulkOfInputGivenArray
     * @covers \Mmf\IO\RequestHtml::setInput
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

    /**
     * @covers \Mmf\IO\RequestHtml::__construct
     * @covers \Mmf\IO\RequestHtml::setBulkOfInputGivenArray
     * @covers \Mmf\IO\RequestHtml::filterVar
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testFilterVar() {
        $var = 'Is Peter <smart> & funny?';
        $varExpected = 'Is Peter &#60;smart&#62; &#38; funny?';
        $this->assertEquals($varExpected,$this->object->filterVar($var));

        $var = ['Is Peter <smart> & funny?', 'Is Peter <smart> & funnny?'];
        $varExpected = ['Is Peter &#60;smart&#62; &#38; funny?', 'Is Peter &#60;smart&#62; &#38; funnny?'];
        $this->assertEquals($varExpected,$this->object->filterVar($var));

        $var = 0.2;
        $varExpected = 0.2;
        $this->assertEquals($varExpected,$this->object->filterVar($var));

        $var = 1;
        $varExpected = 1;
        $this->assertEquals($varExpected,$this->object->filterVar($var));

        $var = true;
        $varExpected = true;
        $this->assertEquals($varExpected,$this->object->filterVar($var));

        $var = ['a'=>['b'=>'holi'], 'b'=>['c'=>['d'=>'holi']]];
        $varExpected = ['a'=>['b'=>'holi'], 'b'=>['c'=>['d'=>'holi']]];
        $this->assertEquals($varExpected,$this->object->filterVar($var));
    }

}
