<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\IO;

/**
 * The MmfResponseHtmlAutomatic format the input data into the html format.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 */
class ResponseHtmlAutomatic extends ResponseHtml{

    /**
     * Echo the response and return it as a string to be echo.
     *
     * @param mixed $response
     * @return string
     */
    public function formatResponseBad($response) {
        //TODO replace.
        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) { // AJAX specific code
            return parent::formatResponseBad($response);
        } else {
            if (is_array($response) &&
                    isset($response['errorCode']) &&
                    isset($response['errorMessage'])
            ) {
                switch ($response['errorCode']) {
                    case 1600: //URL NOT MATCH
                        http_response_code(404);
                        $return = $response['errorMessage'];
                        break;
                    case 1500: //FORBIDEN
                        http_response_code(401);
                        $return = $response['errorMessage'];
                        break;
                    default:
                        http_response_code(500);
                        $return = $response['errorMessage'];
                        break;
                }
            } else {
                http_response_code(500);
                $return = print_r($response, true);
            }
            echo $return;
            return $return;
        }
    }


}
