<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The MmfRoutingResolver class is where is decided the route which has to be
 * chosen.
 *
 * @author Jepi Humet <jepi.humet@mamasu.es>
 *
 */
class RoutingResolverTest extends \PHPUnit_Framework_TestCase {

    private $communicator;
    private $input;
    private $output;
    private $routingResolver;
    protected static $prefix;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public static function setUpBeforeClass() {
        self::$prefix = __DIR__ . '/../../../';
        //include_once __DIR__ . '/../include.php';
    }

    private function prepareRoutesTest($url, $file = false) {
        print "\nURL: $url \n";
        $this->communicator = $this->getMockBuilder('Mmf\IO\CommunicationInterface')
                ->disableOriginalConstructor()
                ->setMethods(array('route', 'setRoute', 'method', 'setMethod'))
                ->getMock();

        $this->communicator->expects($this->any())
                ->method('route')
                ->willReturn($url);

        $this->routingResolver = new \Mmf\Routing\RoutingResolver($this->communicator);

        if (!$file) {
            $this->input = new \Mmf\IO\RequestHtml();
            $this->output = new \Mmf\IO\ResponseHtml();

            $this->routingResolver->addRoute("/routingtest/:id",
                    "testController", "testAction", $this->input, $this->output);
            $this->routingResolver->addRoute("/routingtest/:id/:name/",
                    "testController", "testAction", $this->input, $this->output);
            $this->routingResolver->addRoute("/routingtest/:id/:name/:description",
                    "testController", "testAction", $this->input, $this->output);
            $this->routingResolver->addRoute("/routingtest/:description",
                    "testController", "testAction", $this->input, $this->output);
        } else {
            $this->routingResolver->addBulkRoutes($file);
        }
    }

    /**
     * @group routing
     * @group modules
     * @group development
     * @group production
     */
    public function testOneInput() {
        print "\n==> TEST 1\n";
        $this->prepareRoutesTest("/routingtest/12");
        $rule = $this->routingResolver->resolve();
        $this->assertEquals($rule->getRegularExpression(), "/routingtest/:id/");
    }

    /**
     * @group routing
     * @group modules
     * @group development
     * @group production
     */
    public function testEndSlashWithNonOptionalInputs() {
        print "\n==> TEST 2\n";
        $this->prepareRoutesTest("/routingtest/12/");
        $rule = $this->routingResolver->resolve();
        $this->assertEquals($rule->getRegularExpression(), "/routingtest/:id/");
    }

    /**
     * @group routing
     * @group modules
     * @group development
     * @group production
     */
    public function testTwoInputs() {
        print "\n==> TEST 3\n";
        $this->prepareRoutesTest("/routingtest/12/test1/123");
        $rule = $this->routingResolver->resolve();
        $this->assertEquals($rule->getRegularExpression(),
                "/routingtest/:id/:name/:description/");
    }

    /**
     * @group routing
     * @group modules
     * @group development
     * @group production
     */
    public function testOptionalInput() {
        print "\n==> TEST 4\n";
        $this->prepareRoutesTest("/routingtest/12/test1/this-is-a-test");
        $rule = $this->routingResolver->resolve();
        $this->assertEquals($rule->getRegularExpression(),
                "/routingtest/:id/:name/:description/");
    }

    /**
     * @group routing
     * @group modules
     * @group development
     * @group production
     */
    public function testSlashAfterOptionalParameter() {
        print "\n==> TEST 5\n";
        $this->prepareRoutesTest("/routingtest/12/test1/this-is-a-test/");
        $rule = $this->routingResolver->resolve();
        $this->assertEquals($rule->getRegularExpression(),
                "/routingtest/:id/:name/:description/");
    }

    /**
     * @group routing
     * @group modules
     * @group development
     * @group production
     */
    public function testParametersAreProperlyPopulated() {
        print "\n==> TEST 7\n";
        $this->prepareRoutesTest("/routingtest/12/asdf/my-test/");
        $rule = $this->routingResolver->resolve();
        $this->assertEquals($rule->getInput()->input('id'), 12);
        $this->assertEquals($rule->getInput()->input('name'), "asdf");
        $this->assertEquals($rule->getInput()->input('description'), "my-test");
    }

    /**
     * @group routing
     * @group modules
     * @group development
     * @group production
     */
    public function testParametersWithSpecialChars() {
        print "\n==> TEST 8\n";
        $this->prepareRoutesTest("/routingtest/12/asdf/my-_ , .%20 test/");
        $rule = $this->routingResolver->resolve();
        $this->assertEquals($rule->getInput()->input('id'), 12);
        $this->assertEquals($rule->getInput()->input('description'),
                "my-_ , .%20 test");
    }

    /**
     * @group routing
     * @group error
     * @group modules
     * @group development
     * @group production
     */
    public function testOptionalParametersErrorRouting() {
        print "\n==> TEST 9\n";
        try {
            $this->prepareRoutesTest('/routingtest/12/test3/this-product-is-a-fake-product/123');
            $this->routingResolver->resolve();
        } catch (\Mmf\Routing\RoutingException $e) {
            $this->assertEquals($e->getCode(), 1600);
        }
    }

    /**
     * @group routing
     * @group modules
     * @group development
     * @group production
     */
    public function testBulkFileRouting() {
        print "\n==> TEST 10\n";
        $this->prepareRoutesTest("/routingtest/12/",
                self::$prefix . "config/routing.ini");

        $rule1 = $this->routingResolver->resolve();
        $this->assertEquals($rule1->getRegularExpression(), "/routingtest/:id/");

        $this->prepareRoutesTest("/routingtest/12/test1",
                self::$prefix . "config/routing.ini");
        $rule2 = $this->routingResolver->resolve();
        $this->assertEquals($rule2->getRegularExpression(),
                "/routingtest/:id/:name/");

        $this->prepareRoutesTest("/routingtest/12/test1/this-is-a-test",
                self::$prefix . "config/routing.ini");
        $rule3 = $this->routingResolver->resolve();
        $this->assertEquals($rule3->getRegularExpression(),
                "/routingtest/:id/:name/:description/");

        $this->prepareRoutesTest("/routingtest/12/test1/this-is-a-test/",
                self::$prefix . "config/routing.ini");
        $rule4 = $this->routingResolver->resolve();
        $this->assertEquals($rule4->getRegularExpression(),
                "/routingtest/:id/:name/:description/");

        try {
            $this->prepareRoutesTest("/routingtest/12//my-test/",
                    self::$prefix . "config/routing.ini");
            $rule5 = $this->routingResolver->resolve();
            $this->assertEquals($rule5->getRegularExpression(),
                    "/routingtest/:id/:description/:name/");
        } catch (\Mmf\Routing\RoutingException $e) {
            $this->assertEquals($e->getCode(), 1600);
        }

        try {
            $this->prepareRoutesTest('/routingtest/12/test3/mt-test/extra-info',
                    self::$prefix . "config/routing.ini");
            $this->routingResolver->resolve();
        } catch (\Mmf\Routing\RoutingException $e) {
            $this->assertEquals($e->getCode(), 1600);
        }
    }

    /**
     * @group routing
     * @group modules
     * @groupd development
     * @group production
     */
    public function testAngularRoutes() {
        print "\n==> TEST 11\n";
        $this->prepareRoutesTest("/routingtest/#myroute");
        $rule4 = $this->routingResolver->resolve();

        $this->assertEquals($rule4->getRegularExpression(), "/routingtest/:id/");
        $this->assertEquals($rule4->getInput()->input("id"), "#myroute");
    }

    /**
     * @group routing
     * @group modules
     * @groupd development
     * @group production
     * @group bugfixing
     */
    public function testBulkFileRoutingSolvingBugs() {
        print "\n==> TEST 12\n";
        $this->prepareRoutesTest("/trip/gettriplist/",
                __DIR__ . "/routing_test_bugs.ini");
        $rule1 = $this->routingResolver->resolve();

        $this->assertEquals($rule1->getRegularExpression(), "/trip/gettriplist/");
    }

    /**
     * @group routing
     * @group modules
     * @groupd development
     * @group production
     * @group bugfixing
     */
    public function testBulkFileRoutingWithCatchAllUrl() {
        print "\n==> TEST 13\n";
        $this->prepareRoutesTest("/clienttest/this/is/a/url/for/catchall/",
                __DIR__ . "/routing_test_bugs.ini");
        $rule1 = $this->routingResolver->resolve();

        $this->assertEquals($rule1->getRegularExpression(),
                "/clienttest/*whatever/");

        echo "\nWHATEVER: ";
        var_dump($rule1->getInput()->input('whatever'));
        $this->assertEquals($rule1->getInput()->input("whatever"),
                "this/is/a/url/for/catchall/");
    }

    /**
     * @group routing
     * @group modules
     * @group development
     * @group production
     * @group bugfixing
     */
    public function testAngularUrl() {
        print "\n==> TEST 14\n";
        $this->prepareRoutesTest("/#/patients",
                __DIR__ . "/routing_test_bugs.ini");
        $rule1 = $this->routingResolver->resolve();

        $this->assertEquals($rule1->getRegularExpression(), "/#/:url/");
    }

    /**
     * @group routing
     * @group modules
     * @group development
     * @group production
     */
    public function testWithGetParams() {
        print "\n==> TEST 15\n";
        $this->prepareRoutesTest("/routingtest/12?hola=2");
        $rule = $this->routingResolver->resolve();
        $this->assertEquals($rule->getRegularExpression(), "/routingtest/:id/");
    }

}
