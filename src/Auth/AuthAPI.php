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
class AuthAPI extends Auth {

    /**
     * Logic of authentication.
     *
     * @return void
     */
    public function authenticate() {
        if ($this->token != "") {
            $userInfo = $this->checkIfTokenIsValidAndUpdateTheExpireDate();
        } else { //Is a guess user.
            $userInfo = ['username' => 'guest', 'name' => 'guest', 'id_user' => 1];
        }

        $this->setUsername($userInfo['username']);
        $this->setRoleName($userInfo['name']);
        $this->setUserId($userInfo['id_user']);
        $this->setDefaultLanguage($userInfo['id_user']);
    }

    /**
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

    /**
     * Check if token is valid, if not throws and error.
     *
     * @throws MmfAuthException
     */
    private function checkIfTokenIsValidAndUpdateTheExpireDate() {
        $userInfo = $this->authModel->getRoleAndUserFromToken($this->token);
        if ($userInfo === false) {
            throw new AuthException('The token is not valid', 2000);
        }
        if ($userInfo['expire'] !== null &&
                $userInfo['expire'] < $userInfo['db_date']) {
            throw new AuthException('The token expires', 2001);
        }
        if ($userInfo['expire'] !== null) {
            $futureExpiredate = date('Y-m-d H:i:s',
                    strtotime($userInfo['db_date']) + $this->config->get('auth')['sessionTimeLife']
                    * 60);
            $this->authModel->updateExpireDate($this->token, $futureExpiredate);
        }
        return $userInfo;
    }

}
