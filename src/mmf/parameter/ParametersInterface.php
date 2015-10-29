<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Parameter;

/**
 * Parameters interface
 *
 * Description
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
interface ParametersInterface {
    /**
     * Get parameter
     *
     * @param string|int $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Set parameter
     *
     * @param string|int $key
     * @param mixed      $value
     */
    public function set($key, $value);

    /**
     * Return all the params stored
     *
     * @return array
     */
    public function getAllParams();
}
