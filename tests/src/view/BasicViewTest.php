<?php

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-02-13 at 18:03:20.
 */
class BasicViewTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var MmfBasicViewAbstract
     */
    protected $view;
    protected static $prefix = '../Mmf/mvc/';

    public static function setUpBeforeClass() {
        //include_once __DIR__ . '/../include.php';
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        self::$prefix = __DIR__ . '/../../../app/';
//        $config = $this->getMockBuilder('MmfParametersInterface')
//                       ->disableOriginalConstructor()
//                       ->getMock();
//        $configAarrayReturned = ['viewFolder'=>self::$prefix.'mvc/views',
//                                 'defaultScripts' => array("http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js",
//                                                            "//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js",
//                                                            "/js/generic/jquery-ui.js"),
//                                 'installFolder' => "http://mamaframeworks.com",
//                                 'URLBase' => ''];
//
//        $config->method('get')
//               ->willReturn($configAarrayReturned);
        $config = $this->getMockBuilder('Mmf\Parameter\ParametersInterface')
                ->disableOriginalConstructor()
                ->getMock();

        $config->method('get')
                ->will($this->returnCallback('callbackConfigView'));

        $this->view = new \Mmf\View\BasicView($config);
    }

    protected function tearDown() {
        unset($this->view);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */

    /**
     * @group mvc
     * @group modules
     * @group development
     * @group production
     */
    public function testBasic() {
        $this->view->addVar('testVar', 1);
        $contentView = $this->view->get('product/testview.php')->contentView;
        if ($contentView == '1') {
            $this->assertEquals(true, true);
        } else {
            $this->assertEquals(true, false);
        }
    }

    /**
     * @group mvc
     * @group modules
     * @group development
     * @group production
     */
    public function testTemplateWithIncludedView() {
        $this->view->addVar('testVar', 1);
        $contentView = $this->view->get('product/testview.php')->getContentView();
        $this->view->setTemplate('template.php');
        $contentView = $this->view->getContentWithTemplate();

        if ($contentView == '11') {
            $this->assertEquals(true, true);
        } else {
            $this->assertEquals(true, false);
        }
    }

    /**
     * @group mvc
     * @group modules
     * @group development
     * @group production
     */
    public function testTemplateWithDoubleIncludedView() {
        $this->view->addVar('testVar', 1);
        $lastView = $this->view->get('product/testview.php');
        $this->view->addVar('lastView', $lastView);
        $this->view->get('product/includetestview.php');

        $this->view->setTemplate('template.php');
        $contentView = $this->view->getContentWithTemplate();

        if ($contentView == '111') {
            $this->assertEquals(true, true);
        } else {
            $this->assertEquals(true, false);
        }
    }

    /**
     * @group mvc
     * @group modules
     * @group development
     * @group production
     */
    public function testTemplateWithScriptsAndCSS() {
        $this->view->addVar('testVar', 1);
        $this->view->get('product/testview.php');

        $statistics = 'statistics';
        $this->view->addJsVar('data', $statistics, FALSE);
        $this->view->addScript('/js/generic/testscript.js');
        $this->view->addStyles('/css/test.css');


        $this->view->setTemplate('templateWithStylesAndScripts.php');
        $contentView = $this->view->getContentWithTemplate();

        $this->assertContains('http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js', $contentView);
        $this->assertContains('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', $contentView);
        $this->assertContains('http://mamaframeworks.com/js/generic/jquery-ui.js', $contentView);
        $this->assertContains('http://mamaframeworks.com/js/generic/testscript.js', $contentView);
    }

    /**
     * @group mvc
     * @group modules
     * @group development
     * @group production
     */
    public function testChooseTemplate() {
        $this->view->addVar('testVar', 1);
        $this->view->get('product/testview.php', 'templateWithStylesAndScripts.php');

        $statistics = ['a'=>'statistics', 'b'=>'statistics1'];
        $this->view->addJsVar($statistics, 'statisti');
        $this->view->addScript('/js/generic/testscript.js');
        $this->view->addStyles('/css/test.css');


        $contentView = $this->view->getContentWithTemplate();

        $this->assertContains('http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js', $contentView);
        $this->assertContains('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', $contentView);
        $this->assertContains('http://mamaframeworks.com/js/generic/jquery-ui.js', $contentView);
        $this->assertContains('http://mamaframeworks.com/js/generic/testscript.js', $contentView);
    }

    /**
     * @group mvc
     * @group modules
     * @group development
     * @group production
     */
    public function testWithEmptyTemplate() {
        $this->view->addVar('testVar', 1);
        $this->view->get('product/testview.php');

        $statistics = ['a'=>'statistics', 'b'=>'statistics1'];
        $this->view->addJsVar($statistics, 'statisti');
        $this->view->addScript('/js/generic/testscript.js');
        $this->view->addStyles('/css/test.css');


        $contentView = $this->view->getContentWithTemplate();

        $this->assertContains('1', $contentView);
    }

    /**
     * @group mvc
     * @group modules
     * @group development
     * @group production
     */
    public function testNotExistingTemplate() {
        $this->view->addVar('testVar', 1);
        $this->view->get('product/testview.php');

        $statistics = ['a'=>'statistics', 'b'=>'statistics1'];
        $this->view->addJsVar($statistics, 'statisti');
        $this->view->addScript('/js/generic/testscript.js');
        $this->view->addStyles('/css/test.css');


        $this->view->setTemplate('templateWithStylesAndScriptsNOTEXISTING.php');
        try {
            $contentView = $this->view->getContentWithTemplate ();
            $this->assertEquals(true, false, 'Throw exception is not thrown.');
        } catch(\Exception $e) {
            $this->assertEquals($e->getCode(), 1502);
        }
    }

    /**
     * @group mvc
     * @group modules
     * @group development
     * @group production
     */
    public function testAssetEcho() {
        ob_start();
        $return = $this->view->asset('asdf', FALSE);
        $this->assertEquals($return, 'http://mamaframeworks.comasdf');
        $output = ob_get_clean();
        $this->assertEquals($output, 'http://mamaframeworks.comasdf');
    }

}

function callbackConfigView() {
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
