<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Event;

/**
 * The Event is used as message between dispatcher and observer.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */

abstract class EventAbstract {
    /**
     * Array of event properties.
     * @var array
     */
    public $properties;

    /**
     * Event name, is the name used for the observers to subscribe to a concret
     * event. Required.
     * @var string
     */
    public $name;

    /**
     * Function of the observer that we want to call when the event is
     * dispatch. Is not required.
     *
     * @var string
     */
    public $function;

    public function __construct() {
        $this->properties = array();
    }

}
