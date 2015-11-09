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

class NoACL implements ACLInterface {

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
     * Get the Session and Request Interfaces need to capture the user and
     * determine if is allowed or not.
     *
     * @param \Mmf\Auth\AuthInterface              $auth
     * @param \MmfConnectionInterface | null $connection
     * @param \MmfLanguageInterface   | null $language
     */
    public function __construct(
        AuthInterface $auth,
        ConnectionInterface $connection = null,
        LanguageInterface $language = null
    ) {

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
        return true;
    }
}
