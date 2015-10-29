<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\IO;

/**
 * The ResponseInterface is used for every controller that wants to return
 * a response. This output system give some utilities to abstract the application
 * medium to the logic.
 *
 * @author Jepi Humet
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 */
interface ResponseInterface {

    /**
     *
     * @param mixed $response
     *
     * @return string
     */
    public function formatResponse($response);

    /**
     * @param mixed $response
     *
     * @return string
     */
    public function formatResponseBad($response);
}
