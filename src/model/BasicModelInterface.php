<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Model;

/**
 * The BasicModelInterface is the main interface for all the models.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
interface BasicModelInterface {

    /**
     * @param ConnectionInterface $connection
     * @param string|false           $name
     */
    public function __construct(ConnectionInterface $connection, $name=false);

    /**
     * Do a select query to Database and return the result in a array type.
     *
     * @param string $SQL
     * @return array selected rows.
     * @throws ModelException
     */
    public function select($SQL);

    /**
     * Do a insert query to Database and return the id of the row inserted.
     *
     * @param string $SQL
     * @return int id of inserted row.
     * @throws ModelException
     */
    public function insert($SQL);

    /**
     * Do a delete query to Database and return the number of deleted rows.
     *
     * @param string $SQL
     * @return int number of deleted rows.
     * @throws ModelException
     */
    public function delete($SQL);

    /**
     * Do a update query to Database and return the number of updated rows
     *
     * @param type $SQL
     * @return int number of update rows.
     * @throws ModelException
     */
    public function update($SQL);

    /**
     * Begin a transaction.
     *
     * @throws ModelException
     */
    public function beginTransaction();

    /**
     * End the transaction.
     *
     * @throws ModelException
     */
    public function endTransaction();
}
