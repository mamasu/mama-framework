<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Controller;

/**
 * The Event is used as message between dispatcher and observer.
 * This event is dispatch when the frontcontroller is ready.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class EventCoreReady extends \Mmf\Event\EventAbstract {

    /**
     * Event name, is the name used for the observers to subscribe to a single
     * event. Required.
     * @var string
     */
    public $name = 'EventCoreReady';

}
