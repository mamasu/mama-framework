<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\ACL;

/**
 * The ACLException is the personal exception for all the core system.
 *
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class ACLException extends \Exception {

    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
