<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\IO;

/**
 * Description of CommunicationTerminal
 *
 * @author Jepi Humet
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 */
class CommunicationTerminal implements CommunicationInterface {

    private $route  = false;

    private $method = false;

    /**
     * @return string $route
     */
    public function route() {
        return ($this->route)?:$this->getTerminalRoute();
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
        return $this->method;
    }

    /**
     * @param string $method
     * @return bool
     */
    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * TODO
     * Get the terminal route.
     */
    private function getTerminalRoute() {
        return '';
    }

}
