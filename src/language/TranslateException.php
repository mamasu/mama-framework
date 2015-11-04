<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Language;

/**
 * The TranslateException is the personal exception for all the translate system.
 *
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class TranslateException extends \Mmf\Controller\Exception {

    public function __construct($message, $code = 1800, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
