<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Model;

/**
 * The MySQLModelAbstract is the main abstract class for the SQL models.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
abstract class MySQLModelAbstract implements BasicModelInterface {

    /**
     *
     * @var ConnectionInterface
     */
    protected $connection = false;

    /**
     * Init the core var and connection var.
     *
     * @param ConnectionInterface    $connection
     * @param string | false            $name is the same as in the config.ini file.
     */
    public function __construct(ConnectionInterface $connection, $name=false) {
        if($name){ //Open the connection send in the parameter $name.
            $this->connection = $connection->openConnection($name);
        } else { //Open the default connection.
            $this->connection = $connection->openConnection();
        }
    }

    /**
     * Execute SQL and return the object.
     *
     * @param string $SQL
     * @throws ModelException
     */
    private function executeSQL($SQL, $parameters = null) {
        try {
            $queryPrepare = $this->connection->prepare($SQL);
            if (is_array($parameters)) {
                $queryPrepare->execute($parameters);
            } else {
                $queryPrepare->execute();
            }
        } catch (\PDOException $e) {
            throw new ModelException('Error in the Select QUERY ('.$SQL.') '
                    . 'and error message('.$e->getMessage().')');
        }
        return $queryPrepare;
    }

    /**
     * Do a select query to Database and return the result in a array type.
     *
     * @param string $SQL
     * @return array selected rows.
     * @throws ModelException
     */
    public function select($SQL, $parameters = null) {
        $queryResult = $this->executeSQL($SQL, $parameters);
        return $queryResult->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Do a insert query to Database and return the id of the row inserted.
     *
     * @param string $SQL
     * @return int id of inserted row.
     * @throws ModelException
     */
    public function insert($SQL, $parameters = null) {
        $this->executeSQL($SQL, $parameters);
        return $this->connection->lastInsertId();
    }

    /**
     * Do a delete query to Database and return the number of deleted rows.
     *
     * @param string $SQL
     * @return int number of deleted rows.
     * @throws ModelException
     */
    public function delete($SQL, $parameters = null) {
        $queryResult = $this->executeSQL($SQL, $parameters);
        return $queryResult->rowCount();
    }

    /**
     * Do a update query to Database and return the number of updated rows
     *
     * @param string $SQL
     * @return int number of update rows.
     * @throws ModelException
     */
    public function update($SQL, $parameters = null) {
        $queryResult = $this->executeSQL($SQL, $parameters);
        return $queryResult->rowCount();
    }

    /**
     * Begin a transaction.
     *
     * @throws ModelException
     */
    public function beginTransaction() {

    }

    /**
     * End the transaction.
     *
     * @throws ModelException
     */
    public function endTransaction() {

    }
}
