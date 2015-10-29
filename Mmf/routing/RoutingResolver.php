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
class RoutingResolver extends RoutingResolverAbstract {

    /**
     * @return RoutingRuleAbstract
     * @throws \RoutingException
     */
    public function resolve() {
        $completeRoute = $this->communication->route();
        $fragmentedRoute = explode('?',$completeRoute);
        $routeWithoutGetParams = $fragmentedRoute[0];

        /* @var $rule RoutingRuleAbstract */
        foreach ($this->listOfRules as $rule) {
            if ($this->matchRule($routeWithoutGetParams, $rule)) {
                return $rule;
            }
        }

        throw new RoutingException("There is no rule resolving this route",
        1600);
    }

    /**
     * Arranges all changes based on rule and returns a real Regex, not an URL format
     * (based on routing rules), and a list of input params.
     *
     * @param RoutingRuleAbstract $rule
     * @return list(string regex, array<string> inputs)
     */
    private function getRegexProperties(RoutingRuleAbstract $rule) {
        $requiredMatches = array();
        $ruleRegex = $rule->getRegularExpression();

        preg_match_all($this->requiredInputPattern, $ruleRegex, $requiredMatches);
        $pathRequiredVars = $requiredMatches[0];
        preg_match_all($this->catchAllInputPattern, $ruleRegex, $requiredMatches);
        $pathCatchAllVars = $requiredMatches[0];

        $urlRegexRequired = str_replace($pathRequiredVars,
                "([" . $this->allowedInputValues . "]+)", $ruleRegex);
        $urlRegex = str_replace($pathCatchAllVars, "(.*)", $urlRegexRequired);


        $urlRegexReplaced = str_replace("/", "\/", $urlRegex);
        $finalUrlRegex = "/^" . $urlRegexReplaced . "?$/";

        $inputsRequired = str_replace(":", "", $pathRequiredVars);
        $inputsCatchAll = str_replace("*", "", $pathCatchAllVars);

        return array($finalUrlRegex, array_merge(array(), $inputsRequired,
                    $inputsCatchAll));
    }

    /**
     * Check if route matches with rule depending on regular expression which
     * defines them.
     * @param string $route
     * @param RoutingRuleAbstract $rule
     * @return bool true if rule matches with route or false if not
     */
    private function matchRule($route, RoutingRuleAbstract &$rule) {
        list($regex, $inputs) = $this->getRegexProperties($rule);

        $matches = array();
        preg_match($regex, $route, $matches);
        if (count($matches) > 0) {
            //Substract the first element of the array, which is the complete URL
            array_splice($matches, 0, 1);
            for ($i = 0; $i < count($inputs); $i++) {
                $key = $inputs[$i];
                $value = $matches[$i];
                $rule->getInput()->setInput($key, $value);
            }
            return true;
        }
        return false;
    }

}
