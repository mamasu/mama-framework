<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\ACL;

use Mmf\MVC\MySQLModelAbstract;
/**
 * The ACLInterface is the interface for all Access Control List, available
 * for Mamaframework.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class ACLModel extends MySQLModelAbstract {

    /**
     * Get the list of access for a role.
     *
     * @param int $roleId
     * @return array
     */
    public function getAccessForARole($roleId) {
        $access = $this->select("
            SELECT
                permission.controller,
                permission.rules
            FROM
                permission
            LEFT JOIN role_permission ON
                role_permission.id_permission = permission.id_permission
            LEFT JOIN role ON
                role.id_role = role_permission.id_role
            WHERE
                role.id_role = '{$roleId}'
            ");
        return $access;
    }

    /**
     * Get the role details, given a role id.
     *
     * @param int $roleId
     * @return boolean | array
     */
    public function getRoleById($roleId) {
        $role = $this->select("SELECT * FROM role WHERE id_role = '{$roleId}' LIMIT 1");
        if (count($role) == 0) {
            return FALSE;
        } else {
            return $role[0];
        }
    }

    /**
     * Given role details, given role name.
     *
     * @param string $roleName
     * @return array
     */
    public function getConcreteRole($roleName) {
        $role = $this->select("SELECT * FROM role WHERE name = '{$roleName}' LIMIT 1");
        if (count($role) == 0) {
            return FALSE;
        } else {
            return $role[0];
        }
    }

}
