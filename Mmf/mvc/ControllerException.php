<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\MVC;

/**
 * The ControllerException is the personal exception for all model errors.
 *
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class ControllerException extends \Exception {

    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
