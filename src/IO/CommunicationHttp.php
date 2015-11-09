<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\IO;

/**
 * The MmfCommunicationHttp is the class used to retrieve manage the route of the
 * http applications.
 *
 * @author Jepi Humet
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 */
class CommunicationHttp implements CommunicationInterface {

    /**
     * @var false | string
     */
    private $route  = false;

    /**
     * @var false | string
     */
    private $method = false;

    /**
     * @return string $route
     */
    public function route() {
        return ($this->route)?:$this->getHttpRoute();
    }

    /**
     *
     * @param string $route
     * @return bool success
     */
    public function setRoute($route) {
        $this->route = $route;
    }

    /**
     * @return method GET | POST | PUT | DELETE
     */
    public function method() {
        return ($this->method)?:$_SERVER['REQUEST_METHOD'];
    }

    /**
     * @param string $method
     * @return bool
     */
    public function setMethod($method) {
        $this->method = $method;
    }


    /**
     * Get the http route.
     */
    private function getHttpRoute() {
        return $_SERVER['REQUEST_URI'];
    }


}
