<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Auth;

/**
 * The MmfAuthInterface
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
interface AuthInterface {

    /**
     * @param \MmfSessionInterface    $session
     * @param \MmfRequestInterface    $request
     * @param \MmfConnectionInterface $connection
     * @param \MmfParametersInterface $config
     * @param \MmfLanguageInterface   $language
     */
    public function __construct(\Mmf\Parameter\SessionInterface $session = null,
            \Mmf\IO\RequestInterface $request = null,
            \Mmf\Model\ConnectionInterface $connection = null,
            \Mmf\Parameter\ParametersInterface $config = null,
            \Mmf\Language\LanguageInterface $language = null);

    /**
     * Logic of authentication.
     *
     * @return void
     */
    public function authenticate();

    /**
     * @return bool
     */
    public function isAuthenticated();

    /**
     * @return string username or guest
     */
    public function getUsername();

    /**
     * @return int user id
     */
    public function getUserId();

    /**
     * @return string role
     */
    public function getRoleName();

    /**
     * @return int role
     */
    public function getRoleId();

    /**
     * Set the username.
     *
     * @param string $username
     */
    public function setUsername($username);

    /**
     * Set the user id.
     *
     * @param int $userId
     */
    public function setUserId($userId);

    /**
     * Set the role name.
     *
     * @param string $roleName
     */
    public function setRoleName($roleName);

    /**
     * Set the role id.
     *
     * @param int $roleId
     */
    public function setRoleId($roleId);

    /**
     * Logout the user and set the parameters as a guess parameters.
     */
    public function logout();
}
