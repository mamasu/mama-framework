<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\ACL;

use Mmf\Auth\AuthInterface;
use Mmf\MVC\ConnectionInterface;
use Mmf\Language\LanguageInterface;
use Mmf\Routing\RoutingRuleAbstract;

/**
 * The ACLInterface is the interface for all Access Control List, available
 * for Mamaframework.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
interface ACLInterface {

    /**
     * Get the Session and Request Interfaces need to capture the user and
     * determine if is allowed or not.
     *
     * @param \MmfAuthInterface              $auth
     * @param \MmfConnectionInterface | null $connection
     * @param \MmfLanguageInterface   | null $language
     */
    public function __construct(AuthInterface       $auth,
                                ConnectionInterface $connection = null,
                                LanguageInterface   $language   = null);

    /**
     * Main Function, used to check if the request have autorization to access
     * into the controller and action required.
     *
     * @param \RoutingRuleAbstract $routingRule
     * @return bool TRUE if the user is allow to execute the routing rule or
     * FALSE if the user is not allowed.
     */
    public function isAllowed(RoutingRuleAbstract $routingRule);
}
