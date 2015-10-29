<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Auth;

/**
 * The AuthInterface
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class AuthBasic extends Auth {

    /**
     * Logic of authentication.
     *
     * @return void
     */
    public function authenticate() {
        $authorization = $this->request->input('Authorization');
        if($authorization === null) {
            $userInfo = ['username' => 'guest', 'name' => 'guest', 'id_user' => 1];
        } else {
            $authorizationCredentials = str_replace('Basic', '', $authorization);
            list($username,$password) = explode(':',base64_decode(trim($authorizationCredentials)));

            $userInfo = $this->authModel->getRoleAndUserFromUsernamePassword($username, $password);
        }
        $this->setUsername($userInfo['username']);
        $this->setRoleName($userInfo['name']);
        $this->setUserId($userInfo['id_user']);
        $this->setDefaultLanguage($userInfo['id_user']);
    }

    /**caos
     * Set the default language for this user.
     *
     * @param int $userId
     */
    private function setDefaultLanguage($userId) {
        if ($this->language !== null) {
            $languageModel = new \Mmf\Language\LanguageModel($this->connection);
            $userLanguageProperties = $languageModel->getUserLanguage($userId);
            if ($userLanguageProperties !== false) {
                $this->language->setLocale($userLanguageProperties['code']);
            }
        }
    }

}
