<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Event;

/**
 * The EventManager is a interface used to manage the event dispached and notify
 * the observer listen to that events.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */

interface EventManagerInterface extends \SplSubject{

    /**
     * dispatch the event and notify the observers listen.
     *
     * @param EventAbstract $event
     */
    public function dispatch(EventAbstract $event);

}
