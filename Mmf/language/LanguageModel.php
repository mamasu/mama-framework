<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Language;

use \Mmf\MVC\MySQLModelAbstract;
/**
 * The LanguageModel, check the default user language.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class LanguageModel extends MySQLModelAbstract{

    /**
     * Return the user language properties.
     *
     * @param int $userId
     * @return boolean
     */
    public function getUserLanguage($userId) {
        $sql = 'SELECT language.id_language,
                       language.name,
                       language.code,
                       language.default
                FROM user
                INNER JOIN language ON language.id_language = user.id_language
                WHERE user.id_user=\''.$userId.'\'';

        $language = $this->select($sql);
        if (count($language)>0) {
            return $language[0];
        } else {
            return false;
        }
    }
}
