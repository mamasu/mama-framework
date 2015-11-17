<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\IO;

/**
 * The ResponseJson format the response into the JSON format.
 *
 * @author Jepi Humet
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 */
class ResponseJson implements ResponseInterface {

    /**
     * It gets the return array and it encapsulates into the json_encode. The
     * right way of json structure is, array(success=>1|0 responseData=>
     * result of the controller action or error message). The return data will be
     * encode into the utf8.
     *
     * @param mixed $response
     * @return string
     */
    public function formatResponse($response) {
        //$utf8Response = $this->utf8Encode($response);
        $returnResponse = array('success'=>true, 'responseData'=>$response);
        $this->sendHeaders('Content-Type: application/json');
        echo json_encode($returnResponse);
        return json_encode($returnResponse);
    }

    /**
     * It gets the return array and it encapsulates into the json_encode. The
     * right way of json structure is, array(success=>1|0 responseData=>
     * result of the controller action or error message). The return data will be
     * encode into the utf8.
     *
     * @param mixed $response
     * @return string
     */
    public function formatResponseBad($response) {
        //$utf8Response = $this->utf8Encode($response);
        $returnResponse = array('success'=>false, 'responseData'=>$response);
        $this->sendHeaders('Content-Type: application/json');
        echo json_encode($returnResponse);
        return json_encode($returnResponse);
    }

    /**
     * Send headers if is possible.
     *
     * @param string $header
     * @return boolean
     */
    private function sendHeaders($header) {
        if(!headers_sent()) {
            header($header);
            return true;
        }
        return false;
    }

}
