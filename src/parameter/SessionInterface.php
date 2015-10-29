<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Parameter;

/**
 * The SessionInterface is the interface to access session vars.
 *
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
interface SessionInterface extends ParametersInterface{
    /**
     * Set session var that is only valid for only one request.
     *
     * @param string $key
     * @param mixed $value
     */
    public function setFlashVar($key, $value);

    /**
     * Remove the FlashVars and the respective vars in the storage var.
     */
    public function removeFlashVar();
}
