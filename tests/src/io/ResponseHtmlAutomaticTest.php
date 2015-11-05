<?php

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-02-22 at 11:49:36.
 */
class ResponseHtmlAutomaticTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ResponseHtml
     */
    protected $object;

    public static function setUpBeforeClass() {

    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Mmf\IO\ResponseHtmlAutomatic;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        unset($this->object);
    }

    /**
     * @covers MmfResponseHtml::formatResponse
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testFormatResponseString() {
        $response = 'hola bon dia';
        $responseFormat = $this->object->formatResponse($response);
        $this->assertEquals('hola bon dia', $responseFormat);
    }

    /**
     * @covers MmfResponseHtml::formatResponse
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testFormatResponseView() {
        $contentView = '<html><head></head><body>asdfasdf werasdfasd</body></html>';
        $view = $this->getMockBuilder('Mmf\View\BasicViewInterface')
                        ->disableOriginalConstructor()
                        ->setMethods(array('addVar', 'get', 'addScript',
                                           'addJsVar', 'addStyles', 'setTemplate',
                                           'getContentWithTemplate', 'getAllScripts',
                                           'getAllCss', 'asset', 'getContentView',
                                           '__construct'))
                        ->getMock();
        $view->expects($this->any())
               ->method('getContentWithTemplate')
               ->willReturn($contentView);

        $responseFormat = $this->object->formatResponse($view);
        $this->assertEquals($contentView, $responseFormat);
    }

    /**
     * @covers MmfResponseHtml::formatResponse
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testFormatResponseArrayOrObject() {
        $response = array('hola bon dia');
        $responseFormat = $this->object->formatResponse($response);
        $this->assertEquals(print_r($response,true), $responseFormat);
    }

    /**
     * @covers MmfResponseHtml::formatResponseBad
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testFormatResponseBadString() {
        $response = array('hola bon dia');
        $responseFormat = $this->object->formatResponseBad($response);
        $this->assertEquals(print_r($response,true), $responseFormat);
        $this->assertEquals(http_response_code(), 500);
    }

    /**
     * @covers MmfResponseHtml::formatResponseBad
     * @group io
     * @group modules
     * @group development
     * @group production
     */
    public function testFormatResponseBadRouting() {
        $response = ['errorCode'    => 1600,
                     'errorMessage' => 'The URL not match with any of our defined routes'];
        $responseFormat = $this->object->formatResponseBad($response);
        $this->assertEquals($response['errorMessage'], $responseFormat);
        $this->assertEquals(http_response_code(), 404);
    }
}