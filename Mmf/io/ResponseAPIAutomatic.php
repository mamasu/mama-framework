<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\IO;

/**
 * The ResponseAutomatic format the input data into the html format.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 */
class ResponseAPIAutomatic implements ResponseInterface {

    /**
     * @var ResponseInterface
     */
    protected $responseObject;

    /**
     * @param \ParametersInterface $config
     *
     * @throws \MmfException
     */
    public function __construct(\Mmf\Parameter\ParametersInterface $config) {
        $classResponseName = $config->get('mvc')['defaultRespJson'];
        if (class_exists($classResponseName)) {
            $this->responseObject = new $classResponseName();
        } else {
            throw new \Mmf\MVC\Exception('Cannot create the response object, from automatic response object.');
        }
    }

    /**
     * Echo the response and return it as a string to be echo.
     *
     * @param mixed $response
     * @return string
     */
    public function formatResponse($response) {
        return $this->responseObject->formatResponse($response);
    }

    /**
     * Echo the response and return it as a string to be echo.
     *
     * @param mixed $response
     * @return string
     */
    public function formatResponseBad($response) {
        return $this->responseObject->formatResponseBad($response);
    }


}
