<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Parameter;

/**
 * The MmfSessionAbstract is the common class that turns on session and give
 * the common parameters.
 *
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class Session extends Config implements SessionInterface{

    /**
     * Flash Var
     *
     * @var array
     */
    protected $flashVar = array();


    /**
     * Set parameter
     *
     * @param string|int $key
     * @param mixed      $value
     */
    public function set($key, $value) {
        parent::set($key, $value);
        $_SESSION[$key] = $value;
    }

    /**
     * Set session var that is only valid for only one request.
     *
     * @param string $key
     * @param mixed $value
     */
    public function setFlashVar($key, $value) {
        $this->flashVar[$key] = $value;
        $this->set($key, $value);
    }

    /**
     * Remove the FlashVars and the respective vars in the storage var.
     */
    public function removeFlashVar() {
        foreach ($this->flashVar as $key => $value) {
            unset($this->storage[$key]);
        }
        $this->flashVar = array();
    }
}
