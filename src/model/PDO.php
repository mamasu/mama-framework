<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Model;

/**
 * The PDO specifies a way to open and close connections.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class PDO implements ConnectionInterface{

    /**
     *
     * @var MParametersInterface
     */
    public $config = false;

    /**
     *
     * @var array(name, link).
     */
    private $connections = array();

    /**
     *
     * @param ParametersInterface $config
     */
    public function __construct(\Mmf\Parameter\ParametersInterface $config) {
        $this->config = $config;
    }

    /**
     * Open connection if is not already open.
     *
     * @param string $name optional parameter if nothing is send it gets
     * the default connection.
     *
     * @return \PDO
     * @throws \ModelException
     */
    public function openConnection($name='db_default') {
        foreach ($this->connections as $connection) {
            if($connection['name'] == $name) {
                return $connection['lynk'];
            }
        }
        //Open new connection
        try {
            //Get the configuration of the connection.
            $dbConfig = $this->config->get($name);
            //Create the new connection.
            $connection = new \PDO('mysql:host=' . $dbConfig['host'] .
                                       ';port=' . $dbConfig['port'] .
                                       ';dbname=' . $dbConfig['name'],
                                   $dbConfig['user'],
                                   $dbConfig['pass'],
                                   array(\PDO::MYSQL_ATTR_FOUND_ROWS => true, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $this->connections[] = array('name'=>$name,'lynk'=>$connection);

            return $connection;

        } catch (\Exception $e) {
            throw new ModelException('Error trying to connect to db');
        }
    }

    /**
     * Close connection if is still open.
     *
     * @param string $name optional parameter if nothing is send it gets
     * the default connection.
     *
     * @return bool
     */
    public function closeConnection($name='db_default') {
        foreach ($this->connections as $key => $connection) {
            if($connection['name'] == $name) {
                $this->connections[$key]['lynk'] = null; //closing the connection
                array_splice($this->connections, $key, 1);
                return true;
            }
        }
        return false;
    }
}
