<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Routing;

/**
 * Description of RoutingRuleAbstract
 *
 * @author Jepi Humet
 */
abstract class RoutingRuleAbstract {

    /**
     *
     * @var string $regularExpression
     */
    protected $regularExpression;

    /**
     *
     * @var string $controller
     */
    protected $controller;

    /**
     *
     * @var string $action
     */
    protected $action;

    /**
     *
     * @var RequestInterface
     */
    protected $input;

    /**
     *
     * @var ResponseInterface
     */
    protected $output;

    /**
     *
     * @var string
     */
    protected $method;

    /**
     * @param string                $regularExpression
     * @param string                $controller
     * @param string                $action
     * @param \RequestInterface  $input
     * @param \ResponseInterface $output
     * @param string                $method
     */
    function __construct(
            $regularExpression,
            $controller,
            $action,
            \Mmf\IO\RequestInterface $input,
            \Mmf\IO\ResponseInterface $output,
            $method
    ) {
        $this->regularExpression = $regularExpression;
        $this->controller        = $controller;
        $this->action            = $action;
        $this->input             = $input;
        $this->output            = $output;
        $this->method            = $method;
    }

    /**
     * Returns regularExpression
     * @return string $regularExpression
     */
    abstract public function getRegularExpression();

    /**
     * Returns Controller name
     * @return string $controller
     */
    abstract public function getController();

    /**
     * Returns Action name
     * @return string $action
     */
    abstract public function getAction();

    /**
     * Returns input
     * @return RequestInterface $input
     */
    abstract public function getInput();

    /**
     * Returns output
     * @return ResponseInterface $output
     */
    abstract public function getOutput();

    /**
     * Returns the method of the call.
     * @return string
     */
    abstract public function getMethod();

    /**
     * Sets regularExpression
     * @param string $regularExpression
     * @return bool success
     */
    abstract public function setRegularExpression($regularExpression);

    /**
     * Sets controller
     * @param string $controller
     * @return bool success
     */
    abstract public function setController($controller);

    /**
     * Sets action
     * @param string $action
     * @return bool success
     */
    abstract public function setAction($action);

    /**
     * Sets input
     * @param RequestInterface $input
     * @return bool success
     */
    abstract public function setInput(\Mmf\IO\RequestInterface $input);

    /**
     * Sets output
     * @param ResponseInterface $output
     * @return bool success
     */
    abstract public function setOutput(\Mmf\IO\ResponseInterface $output);

    /**
     * Sets the method parameter.
     * @param $method
     */
    abstract public function setMethod($method);

}
