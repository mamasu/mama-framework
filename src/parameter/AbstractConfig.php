<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Parameter;

/**
 * The AbstractConfig bla bla...
 *
 * Description
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class AbstractConfig {

    /**
     * @var Storage of data
     */
    protected $storage;


    public function __construct($storage = array()) {
        $this->storage = $storage;
    }

    /**
     * Add Config Vars from a new .ini file
     *
     * @param string $path
     */
    public function addConfigVars($path = 'config.ini') {
        if ($path === 'config.php') {
            $arrayIniParams = parse_ini_file(dirname(__FILE__).'/'.$path,true);
        } else {
            $arrayIniParams = parse_ini_file($path, true);
        }
        foreach ($arrayIniParams as $key => $iniParam) {
            $this->storage[$key] = $iniParam;
        }
    }

}
