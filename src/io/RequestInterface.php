<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\IO;

/**
 * The MmfRequestInterface is the interface for the classes that want to access
 * to the input application arguments.
 *
 * @author Jepi Humet
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 */
interface RequestInterface {

    /**
     * Get the input var.
     *
     * @param string $varName name of the var to retrieve the value.
     * @return mixed input
     */
    public function input($varName);

    /**
     * Set the input var to value.
     *
     * @param string $varName
     * @param mixed $value
     */
    public function setInput($varName, $value);

    /**
     * Function to filter the input var. Is it define as public to replicate
     * the logic for every var that you want.
     *
     * @param string $var
     * @return sanitaize var
     */
    public function filterVar($var);
}
