<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Auth;

use \Mmf\Model\MySQLModelAbstract;
/**
 * The AuthModel.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class AuthModel extends MySQLModelAbstract{

    /**
     * Return the role and user attributes from the given token.
     *
     * @param string $token
     * @return boolean
     */
    public function getRoleAndUserFromToken($token) {
        $sql = 'SELECT
                    user.username,
                    user.id_user,
                    role.name,
                    role.id_role,
                    role.id_parent,
                    NOW() AS db_date,
                    token.expire
                FROM
                    role
                        INNER JOIN
                    user ON user.id_role = role.id_role
                        INNER JOIN
                    token ON user.id_user = token.id_user
                WHERE token.token="'.$token.'"
                 ';
        $role = $this->select($sql);
        if(is_array($role) && count($role)>0) {
            return $role[0];
        } else {
            return false;
        }
    }

    /**
     * @param string $token
     * @param string $expireDate
     *
     * @return bool
     */
    public function updateExpireDate($token, $expireDate) {
        $sql = 'UPDATE `token`
                SET
                `expire` = "'.$expireDate.'"
                WHERE `token` = "'.$token.'";';
        $updateResult = $this->update($sql);
        if ($updateResult>0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function getRoleAndUserFromUsernamePassword($username, $password) {
        $sql = 'SELECT
                    user.username,
                    user.id_user,
                    role.name,
                    role.id_role,
                    role.id_parent,
                    NOW() AS db_date
                FROM
                    role
                        INNER JOIN
                    user ON user.id_role = role.id_role
                WHERE user.username="'.$username.'"
                    AND user.password="'.$password.'"
                 ';
        $role = $this->select($sql);
        if(is_array($role) && count($role)>0) {
            return $role[0];
        } else {
            return false;
        }
    }

    /**
     * Return user information given id user.
     *
     * @param int $userId
     *
     * @return array
     */
    public function getRoleAndUserFromIdUser($userId) {
        $sql = 'SELECT
                    user.username,
                    user.id_user,
                    role.name,
                    role.id_role,
                    role.id_parent,
                    NOW() AS db_date
                FROM
                    role
                        INNER JOIN
                    user ON user.id_role = role.id_role
                WHERE user.id_user="'.$userId.'"
                 ';
        $role = $this->select($sql);
        if(is_array($role) && count($role)>0) {
            return $role[0];
        } else {
            return false;
        }
    }
}
