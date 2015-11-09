<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Routing;

/**
 * Description of RoutingRule
 *
 * @author Jepi Humet
 */
class RoutingRule extends RoutingRuleAbstract {

    /**
     * Returns regularExpression
     *
     * @return string $regularExpression
     */
    function getRegularExpression() {
        return $this->regularExpression;
    }

    /**
     * Returns Controller name
     *
     * @return string $controller
     */
    function getController() {
        return $this->controller;
    }

    /**
     * Returns Action name
     *
     * @return string $action
     */
    function getAction() {
        return $this->action;
    }


    /**
     * Returns input
     *
     * @return \RequestInterface
     */
    function getInput() {
        return $this->input;
    }

    /**
     * Returns output
     *
     * @return \ResponseInterface $output
     */
    function getOutput() {
        return $this->output;
    }

    /**
     * Returns the method of the call.
     *
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Sets regularExpression
     *
     * @param string $regularExpression
     * @return bool success
     */
    function setRegularExpression($regularExpression) {
        $this->regularExpression = $regularExpression;
    }

    /**
     * Sets controller
     *
     * @param string $controller
     * @return bool success
     */
    function setController($controller) {
        $this->controller = $controller;
    }

    /**
     * Sets action
     *
     * @param string $action
     * @return bool success
     */
    function setAction($action) {
        $this->action = $action;
    }

    /**
     * Sets input
     *
     * @param RequestInterface $input
     * @return bool success
     */
    function setInput(\Mmf\IO\RequestInterface $input) {
        $this->input = $input;
    }

    /**
     * Sets output
     *
     * @param ResponseInterface $output
     * @return bool success
     */
    function setOutput(\Mmf\IO\ResponseInterface $output) {
        $this->output = $output;
    }

    /**
     * Sets the method parameter.
     *
     * @param $method
     */
    public function setMethod($method) {
        $this->method = $method;
    }

}
