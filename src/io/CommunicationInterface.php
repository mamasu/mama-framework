<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\IO;

/**
 * The communication interface is used to define what kind of application are you
 * using, and abstract this from the logic of the application.
 *
 * @author Jepi Humet
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 */
interface CommunicationInterface {

    /**
     * @return string $route
     */
    public function route();

    /**
     *
     * @param string $route
     * @return bool success
     */
    public function setRoute($route);

    /**
     * @return method
     */
    public function method();

    /**
     * @param string $method
     * @return bool
     */
    public function setMethod($method);
}
