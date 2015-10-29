<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
gc_disable();

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The MmfRoutingRule class is where is configured a routing rule.
 *
 * @author Jepi Humet <jepi.humet@mamasu.es>
 * 
 */
class RoutingRuleTest extends \PHPUnit_Framework_TestCase {

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        //include_once __DIR__ . '/../include.php';
    }

    /**
     * @group routing
     * @group modules
     * @group development
     * @group production
     */
    public function testRule() {
        $rule = new Mmf\Routing\RoutingRule("[a-z0-9]", "testcontroller", "testaction",
                new Mmf\IO\RequestHtml(), 
                new Mmf\IO\ResponseJson(), "testmethod");

        $this->assertEquals($rule->getRegularExpression(), "[a-z0-9]");
        $this->assertEquals($rule->getController(), "testcontroller");
        $this->assertEquals($rule->getAction(), "testaction");
        $this->assertEquals($rule->getMethod(), "testmethod");

        $rule->setRegularExpression("[a-zA-Z]");
        $rule->setController("newcontroller");
        $rule->setAction("newaction");
        $rule->setMethod("newmethod");

        $this->assertEquals(get_class($rule->getInput()), "Mmf\IO\RequestHtml");
        $this->assertEquals(get_class($rule->getOutput()), "Mmf\IO\ResponseJson");

        $rule->setInput(new \Mmf\IO\RequestJson());
        $rule->setOutput(new Mmf\IO\ResponseHtml());

        $this->assertEquals($rule->getRegularExpression(), "[a-zA-Z]");
        $this->assertEquals($rule->getController(), "newcontroller");
        $this->assertEquals($rule->getAction(), "newaction");
        $this->assertEquals($rule->getMethod(), "newmethod");

        $this->assertEquals(get_class($rule->getInput()), "Mmf\IO\RequestJson");
        $this->assertEquals(get_class($rule->getOutput()), "Mmf\IO\ResponseHtml");
    }

}
