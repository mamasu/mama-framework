<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Controller;

/**
 * The MmfBasicControllerInterface is the base of all the controllers.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
abstract class BasicControllerAbstract implements BasicControllerInterface {
    /**
     *
     * @var CoreInterface
     */
    protected $MmfCore;
    public function __construct(\Mmf\Core\CoreInterface $core) {
        $this->MmfCore = $core;
    }
}
