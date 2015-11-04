<?php


class ResponseJsonTest extends PHPUnit_Framework_TestCase {

    /**
     * @var ResponseJson
     */
    protected $object;

    public static function setUpBeforeClass() {
        //include_once __DIR__ . '/../include.php';
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Mmf\IO\ResponseJson;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        unset($this->object);
    }

    /**
     * @covers MmfResponseJson::formatResponse
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testFormatResponse() {
        $response = array('success'=>1, 'responseData'=>array('holaòà<b>7/"',1,false));
        $responseFormat = $this->object->formatResponse($response);
        $this->assertEquals($responseFormat, '{"success":true,"responseData":{"success":1,"responseData":["hola\u00f2\u00e0<b>7\/\"",1,false]}}');
    }

    /**
     * @covers MmfResponseJson::formatResponseBad
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testFormatResponseBad() {
        $response = array('success'=>1, 'responseData'=>array('holaòà<b>7/"',1,false));
        $responseFormat = $this->object->formatResponseBad($response);
        $this->assertEquals('{"success":false,"responseData":{"success":1,"responseData":["hola\u00f2\u00e0<b>7\/\"",1,false]}}', $responseFormat);
    }

}
