<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Model;

/**
 * The ConnectionInterface specifies a way to open and close connections.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
interface ConnectionInterface {
    /**
     *
     * @param ParametersInterface $config
     */
    public function __construct(\Mmf\Parameter\ParametersInterface $config);

    /**
     * Open connection if is not already open.
     *
     * @param string $name optional parameter if nothing is send it gets
     * the default connection.
     * * @throws ModelException
     */
    public function openConnection($name='default');

    /**
     * Close connection if is still open.
     *
     * @param string $name optional parameter if nothing is send it gets
     * the default connection.
     */
    public function closeConnection($name='default');
}
