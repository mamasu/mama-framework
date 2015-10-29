<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Parameter;

/**
 * The MmfConfig
 *
 * Description
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */

class Config extends AbstractConfig implements ParametersInterface {
    /**
     * Get parameter
     *
     * @param string|int $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null) {
        if (isset($this->storage[$key])) {
            return $this->storage[$key];
        }
        return $default;
    }
    /**
     * Set parameter
     *
     * @param string|int $key
     * @param mixed $value
     */
    public function set($key, $value) {
        $this->storage[$key] = $value;
    }

    /**
     * Return all the params stored
     *
     * @return array
     */
    public function getAllParams(){
        return $this->storage;
    }
}
