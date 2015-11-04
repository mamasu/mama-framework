<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\ACL;

use Mmf\Auth\AuthInterface;
use Mmf\Model\ConnectionInterface;
use Mmf\Language\LanguageInterface;
use Mmf\Routing\RoutingRuleAbstract;

/**
 * The ACL is the class for all Access Control List, available
 * for Mamaframework.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class ACL implements ACLInterface {

    /**
     *
     * @var \Mmf\Auth\AuthInterface
     */
    private $auth;

    /**
     *
     * @var \Mmf\Model\ConnectionInterface
     */
    private $connection;

    /**
     *
     * @var \Mmf\Language\LanguageInterface
     */
    private $language;

    /**
     *
     * @var ACLModel
     */
    private $aclModel;

    /**
     * Id role for the user.
     *
     * @var int
     */
    private $roleId = NULL;

    /**
     * Id role for the user.
     *
     * @var int
     */
    private $roleName = NULL;

    /**
     * Roles given from database.
     *
     * @var array
     */
    private $rolesChain = NULL;

    /**
     * Roles adatped from database to normal form.
     *
     * @var array
     */
    private $access = NULL;

    /**
     * Get the Session and Request Interfaces need to capture the user and
     * determine if is allowed or not.
     *
     * @param \Mmf\Auth\AuthInterface              $auth
     * @param \MmfConnectionInterface | null $connection
     * @param \MmfLanguageInterface   | null $language
     */
    public function __construct(AuthInterface $auth,
            ConnectionInterface $connection = null,
            LanguageInterface $language = null) {
        $this->auth = $auth;
        $this->connection = $connection;
        $this->language = $language;
        $this->aclModel = new ACLModel($connection);
        $this->forceRole($this->auth->getRoleName());
    }

    /**
     * Main Function, used to check if the request have autorization to access
     * into the controller and action required.
     *
     * @param \MmfRoutingRuleAbstract $routingRule
     * @return bool TRUE if the user is allow to execute the routing rule or
     * FALSE if the user is not allowed.
     */
    public function isAllowed(RoutingRuleAbstract $routingRule) {
        $controller = str_ireplace("Controller", "",  $routingRule->getController());

        //$function = new \ReflectionClass($routingRule->getController() . 'Controller');
        /*
        var_dump($function->inNamespace());
        var_dump($function->getName());
        var_dump($function->getNamespaceName());
        var_dump($function->getShortName());
         */
        //$controller = str_ireplace("Controller", "", $function->getShortName());

        $action = $routingRule->getAction();
        $access = $this->getAccess();
        $allowed = FALSE;
        if (array_key_exists($controller, $access)) {
            foreach ($access[$controller] as $rule) {
                if ($rule == "*") {
                    $allowed = TRUE;
                } else {
                    if ($allowed) { //After general acceptation like * can be an exception
                        $negation = FALSE;
                        if ($rule[0] == "!") {
                            $negation = TRUE;
                            $rule = substr($rule, 1);
                        }

                        if ($negation) { //By the moment is allowed but maybe there is an exception rule
                            if ($rule == $action) {
                                $allowed = FALSE;
                            }
                        }
                    } else {
                        if ($rule == $action) {
                            $allowed = TRUE;
                        }
                    }
                }
            }
        }
        return $allowed;
    }

    private function forceRole($name = "guest") {
        $role = $this->aclModel->getConcreteRole($name);
        if ($role === false) {
            throw new ACLException("Role name doesn't exist in database", 1700);
        }
        $this->roleId = $role['id_role'];
        $this->roleName = $role['name'];
    }

    /**
     * Return a normal access array.
     *
     * @return array
     */
    private function getAccess() {
        if (is_null($this->access)) {
            $chain = $this->getRolesChain();
            $tmpAccess = array();

            foreach ($chain as $role) {
                $arrAccess = $this->aclModel->getAccessForARole($role['id_role']);
                foreach ($arrAccess as $accessItem) {
                    $tmpAccess[$accessItem['controller']] = explode("|",
                            $accessItem['rules']);
                }
            }
            $this->access = $tmpAccess;
            return $this->access;
        } else {
            return $this->access;
        }
    }

    /**
     * Get the list of roles chain. For example, if admin have user as parent
     * role, it returns the admin and user role.
     *
     * @return array
     */
    private function getRolesChain() {
        if (is_null($this->rolesChain)) {
            $chain = array();
            $role = $this->aclModel->getRoleById($this->roleId);
            while ($role != FALSE) {
                $chain[] = $role;
                $currId = $role['id_parent'];
                $role = $this->aclModel->getRoleById($currId);
            }

            $this->rolesChain = array_reverse($chain);
            return $this->rolesChain;
        } else {
            return $this->rolesChain;
        }
    }

}
