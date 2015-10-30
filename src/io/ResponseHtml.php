<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\IO;

/**
 * The MmfResponseHtml format the input data into the html format.
 *
 * @author Jepi Humet
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 */
class ResponseHtml implements ResponseInterface {

    /**
     * Echo the response and return it as a string to be echo.
     *
     * @param mixed $response
     * @return string
     */
    public function formatResponse($response) {
        if (is_object($response) && is_a($response, '\Mmf\MVC\BasicViewInterface')) {
            //Is a view
            $return = $response->getContentWithTemplate();
        } else if (is_string($response)) {
            //Is string
            $return = $response;
        } else {
            //Is another structure (object or array)
            $return = print_r($response, true);
        }
        echo $return;
        return $return;
    }

    /**
     * Echo the response and return it as a string to be echo.
     *
     * @param mixed $response
     * @return string
     */
    public function formatResponseBad($response) {
        //TODO replace.
        if (is_object($response) && is_a($response, '\Mmf\MVC\BasicViewInterface')) {
            //Is a view
            $return = $response->getContentWithTemplate();
        } else if (is_string($response)) {
            //Is string
            $return = $response;
        } else {
            //Is another structure (object or array)
            $return = print_r($response, true);
        }
        echo $return;
        return $return;
    }

}
