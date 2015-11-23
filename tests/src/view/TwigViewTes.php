<?php

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-02-13 at 18:03:20.
 */
class TwigViewTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var TwigViewAbstract
     */
    protected $view;
    protected static $prefix = '../Mmf/mvc/';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        self::$prefix = __DIR__ . '/../../../app/';

        $config = $this->getMockBuilder('Mmf\Parameter\ParametersInterface')
                ->disableOriginalConstructor()
                ->getMock();

        $config->method('get')
                ->will($this->returnCallback('callbackConfigViewTwig'));

        $this->view = new \Mmf\View\TwigView($config);
    }

    protected function tearDown() {
        unset($this->view);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */

    /**
     * @covers \Mmf\View\TwigView::get
     * @group mvc
     * @group modules
     * @group development
     * @group production
     */
    public function testBasic() {
        $this->view->addVar('testVar', 1);
        //ob_start();
        $contentView = $this->view->get('product/testview.php');
        //$contentView = ob_get_clean();
        if ($contentView == '<?php
echo $testVar;') {
            $this->assertEquals(true, true);
        } else {
            $this->assertEquals(true, false);
        }
    }



}

function callbackConfigViewTwig() {
    $functionArguments = func_get_args();
    $conection1 = [
        'viewFolder' => 'views',
        'defaultScripts' => array("http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js",
        "//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js",
        "/js/generic/jquery-ui.js"),
        'defaultCSS' => array("testcss.css", "http://testcss.css"),
        'installFolder' => "http://mamaframeworks.com"
    ];
    $return = array('mvc' => $conection1, 'URLBase' => __DIR__ . '/../../../app/');
    return $return[$functionArguments[0]];
}