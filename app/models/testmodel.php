<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Models;
/**
 * The testmodel.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class testmodel extends \Mmf\Model\MySQLModelAbstract{

    public function testSelect() {
        $sql = 'SELECT * FROM test';
        return $this->select($sql);
    }

    public function testInsert() {
        $sql = "INSERT INTO `test`
                (
                `name`,
                `test`)
                VALUES
                (
                'new name test',
                'new test columtest');
                ";
        return $this->insert($sql);
    }

    public function testUpdate($id) {
        $sql = 'UPDATE `test`
                SET
                `name` = "update",
                `test` = "updatetest"
                WHERE `id` = '.$id.';
                ';
         return $this->update($sql);
    }

    public function testDelete($id) {
        $sql = 'DELETE FROM `test`
                WHERE id='.$id.';
                ';
         return $this->delete($sql);
    }
}
