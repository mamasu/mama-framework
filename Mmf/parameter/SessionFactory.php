<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Parameter;

/**
 * The SessionFactory is creator of the Session with the session
 * parameters init.
 *
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class SessionFactory{

    /**
     * Init session parameters and init the class to manage the vars.
     *
     * @return \Session
     * @throws \SessionException
     */
    public function createSession() {
        if (!isset($_SESSION)) {
           if (PHP_SAPI === 'cli') {
              $_SESSION = array();
           } elseif (!headers_sent()) {
              if (!session_start()) {
                 throw new SessionException('session_start failed.');
              }
           } else {
              throw new SessionException('Session started after headers sent.');
           }
        }
        $mmfSession = new Session($_SESSION);
        return $mmfSession;
    }
}
