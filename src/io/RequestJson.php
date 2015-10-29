<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\IO;

/**
 * Description of RequestJson
 *
 * @author Jepi Humet
 * @author Xavier Cashuga <xavier.casahuga@mamasu.es>
 */
class RequestJson extends RequestHtml implements RequestInterface {

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct() {
        if (function_exists('getallheaders')){
            $this->setBulkOfInputGivenArray(getallheaders());
        }
        $inputJSON = file_get_contents('php://input');
        $input= json_decode( $inputJSON, TRUE );
        $this->setBulkOfInputGivenArray($input);
        $this->setBulkOfInputGivenArray($_GET);
    }

}
