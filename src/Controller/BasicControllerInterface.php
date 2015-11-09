<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Controller;

/**
 * The BasicControllerInterface is the base of all the controllers.
 *
 * Description
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
interface BasicControllerInterface {
    public function __construct(\Mmf\Core\CoreInterface $core);
}
