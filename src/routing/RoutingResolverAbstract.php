<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Routing;

/**
 * Description of RoutingResolver
 *
 * @author Jepi Humet
 */
abstract class RoutingResolverAbstract {

    /**
     *
     * @var array<RoutingRuleAbstract> $listOfRules
     */
    protected $listOfRules = array();

    /**
     *
     * @var CommunicationInterface
     */
    protected $communication;

    /**
     *
     * @var LanguageInterface
     */
    protected $language;

    /**
     * This pattern defines the regular expression for mandatory keys which will
     * developer use in routing definition as in beauty URLs like /product/[id]
     * @var string
     */
    protected $requiredInputPattern = "/\:[(a-zA-Z0-9\_)+]+/";

    /**
     * This pattern defines the regular expression for catch all parameter. It
     * means that the variable defined in this way will matches with (.*)
     * @var string
     */
    protected $catchAllInputPattern = "/\*[(a-zA-Z0-9\_)+]+/";

    /**
     * Specifies the regular expression which defines the allowed characters for
     * input values sent through the URL
     * @var string
     */
    protected $allowedInputValues = "\w\.\,\:\;\-\#\%\?\s";
    protected $inputObjects = array();
    protected $outputObjects = array();

    function __construct(\Mmf\IO\CommunicationInterface $communication,
                        \Mmf\Language\LanguageInterface $language = null) {
        $this->communication = $communication;
        $this->language = $language;
    }

    /**
     *
     * @throws \RoutingException
     *
     * @return RoutingRuleAbstract
     */
    abstract public function resolve();

    /**
     *
     * @param string $regularExpression
     * @param string $controller
     * @param string $action
     * @param RequestInterface $input
     * @param ResponseInterface $output
     */
    public function addRoute(
            $regularExpression, 
            $controller, 
            $action,
            \Mmf\IO\RequestInterface $input, 
            \Mmf\IO\ResponseInterface $output
    ) {
        //Ensure all expression finishes with a "/" char, to check parameters between two "/" when resolving
        $regularExpression .= $regularExpression[strlen($regularExpression) - 1]
                == "/" ? "" : "/";
        $this->listOfRules[] = new RoutingRule($regularExpression,
                $controller, $action, $input, $output,
                $this->communication->method());
    }

    /**
     *
     * @param string $routingIniFile
     */
    public function addBulkRoutes($routingIniFile) {
        $params = parse_ini_file($routingIniFile, true);

        foreach ($params as $controller => $properties) {
            for ($i = 0; $i < count($properties['expression']); $i++) {
                $expression = $properties['expression'][$i];
                $request = $properties['request'][$i];
                $response = $properties['response'][$i];
                $action = $properties['action'][$i];

                if (isset($this->inputObjects[$request])) {
                    $input = $this->inputObjects[$request];
                } else {
                    $input = new $request();
                    $this->inputObjects[$request] = $input;
                }

                if (isset($this->outputObjects[$response])) {
                    $output = $this->outputObjects[$response];
                } else {
                    $output = new $response();
                    $this->outputObjects[$response] = $output;
                }

                $this->addRoute($expression, $controller, $action, $input,
                        $output);
            }
        }
    }

}
