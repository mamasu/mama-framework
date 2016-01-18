<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\IO;

/**
 * Description of RequestHtml
 *
 * @author Jepi Humet
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 */
class RequestHtml implements RequestInterface {

    /**
     *
     * @var array
     */
    private $parameters = array();

    /**
     * Set the initial parameters as Header vars, Post vars and Get vars.
     * The GET vars replace the POST and Header vars in case that have the same
     * name, and POST vars replace the Header vars in case that have the same
     * name.
     */
    public function __construct() {
        if (function_exists('getallheaders')){
            //TODO: create getallheaders functions for nginx
            $this->setBulkOfInputGivenArray(getallheaders());
        } elseif(!empty($_SERVER)) {
            $headers = '';
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
            $this->setBulkOfInputGivenArray($headers);
        }
        $this->setBulkOfInputGivenArray($_POST);
        $this->setBulkOfInputGivenArray($_GET);
    }

    /**
     * Set a bulk of input parameters from and array.
     *
     * @param array $arrayOfParameters
     */
    protected function setBulkOfInputGivenArray($arrayOfParameters) {
        if(is_array($arrayOfParameters)) {
            foreach ($arrayOfParameters as $nameOfParameter => $valueOfParameter) {
                $this->setInput($nameOfParameter, $valueOfParameter);
            }
        }
    }

    /**
     * Get the input var.
     *
     * @param string $varName name of the var to retrive the value.
     * @return mixed input
     */
    public function input($varName) {
        if (isset($this->parameters[$varName])) {
            return $this->filterVar($this->parameters[$varName]);
        } else {
            return null;
        }
    }

    /**
     * Set the input var to concret value.
     *
     * @param string $varName
     * @param mixed $value
     */
    public function setInput($varName, $value) {
        $this->parameters[$varName] = $value;
    }

    /**
     * Function to filter the input var. Is it define as public to replicate
     * the logic for every var that you want.
     *
     * @param string $var
     * @return mixed sanitize var
     */
    public function filterVar($var) {
        $response = NULL;
        if (is_bool($var)) {
            $response = $var;
        } elseif(is_int($var)) {
            $response = $var;
        } elseif(is_float($var)) {
            $response = $var;
        }
        if($var != 'null') {
            if(is_string($var)) {
                $response = filter_var($var, FILTER_SANITIZE_SPECIAL_CHARS);            
            } elseif(is_array($var)) {
                $response = array();
                foreach ($var as $key => $value) {
                    if(is_array($value)) {
                        $response[$key] = $this->filterVar($value);
                    } else {
                        $response[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        return $response;
        
    }

}
