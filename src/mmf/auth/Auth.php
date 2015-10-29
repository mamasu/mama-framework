<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Auth;

/**
 * The Auth
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class Auth implements AuthInterface {

    private $guestUserId = 0;
    private $guestUsername = "guest";
    private $guestRoleId = 1;
    private $guestRoleName = "guest";

    /**
     * @var in
     */
    protected $userId;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var int
     */
    protected $roleId;

    /**
     * @var string
     */
    protected $roleName;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     *
     * @var AuthModel
     */
    protected $authModel;

    /**
     *
     * @var \Mmf\Language\LanguageInterface
     */
    protected $language;

    /**
     * @var MmfParametersInterface
     */
    protected $config;

    /**
     *
     * @var MmfSessionInterface
     */
    protected $session;

    /**
     * Constructor.
     *
     * @param \MmfSessionInterface    $session
     * @param \MmfRequestInterface    $request
     * @param \MmfConnectionInterface $connection
     * @param \MmfParametersInterface $config
     * @param \MmfLanguageInterface   $language
     */
    public function __construct(\Mmf\Parameter\SessionInterface $session = null,
            \Mmf\IO\RequestInterface $request = null,
            \Mmf\MVC\ ConnectionInterface $connection = null,
            \Mmf\Parameter\ParametersInterface $config = null,
            \Mmf\Language\LanguageInterface $language = null) {
        $this->session = $session;
        $this->request = $request;
        $this->connection = $connection;
        $this->config = $config;
        $this->language = $language;
        $this->initAuthModel($config, $connection);
        if ($this->request !== null) {
            $this->token = $this->request->input('token');
        }
        $this->authenticate();
    }

    private function initAuthModel(
        \Mmf\Parameter\ParametersInterface $config = null, 
        \Mmf\MVC\ ConnectionInterface $connection = null
    ) {
        if ($config === null) {
            $this->authModel = new AuthModel($connection);
        } else {
            $auth = $config->get('auth');
            if (array_key_exists('authModelClass', $auth) && class_exists($auth['authModelClass'])) {
                $this->authModel = new $auth['authModelClass']($connection);
            } else {
                $this->authModel = new AuthModel($connection);
            }
        }
    }

    /**
     * Logic of authentication.
     *
     * @return void
     */
    public function authenticate() {
        $userId = $this->session->get('userId');
        if ($userId !== null) {
            $user     = $this->authModel->getRoleAndUserFromIdUser($userId);
            if ($user) {
                $this->setUserId($userId);
                $this->setUsername($user['username']);
                $this->setRoleId($user['id_role']);
                $this->setRoleName($user['name']);
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    /**
     * Function to declare a user as a guess.
     */
    public function logout() {
        $this->setUserId($this->guestUserId);
        $this->setUsername($this->guestUsername);
        $this->setRoleId($this->guestRoleId);
        $this->setRoleName($this->guestRoleName);
    }

    /**
     * @return bool
     */
    public function isAuthenticated() {
        if ($this->getUsername() !== $this->guestRoleName) {
            return true;
        }
        return false;
    }

    /**
     * @return int user id
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @return string username or guest
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return string role
     */
    public function getRoleId() {
        return $this->roleId;
    }

    /**
     * @return string role
     */
    public function getRoleName() {
        return $this->roleName;
    }

    /**
     * Set the user id.
     *
     * @param int $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
        if ($this->session !== null) {
            $this->session->set('userId', $userId);
        }
    }

    /**
     * Set the username.
     *
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
        if ($this->session !== null) {
            $this->session->set('username', $username);
        }
    }

    /**
     * Set the role id
     *
     * @param string $roleId
     */
    public function setRoleId($roleId) {
        $this->roleId = $roleId;
        if ($this->session !== null) {
            $this->session->set('roleId', $roleId);
        }
    }

    /**
     * Set the role name
     *
     * @param string $roleName
     */
    public function setRoleName($roleName) {
        $this->roleName = $roleName;
        if ($this->session !== null) {
            $this->session->set('roleName', $roleName);
        }
    }

}
