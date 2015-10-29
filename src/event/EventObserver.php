<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Event;

/**
 * The MmfEventObserver is a class used to observes event manage from
 * MmfEventManager
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */

class EventObserver implements \SplObserver{

    public $isUpdate = false;

    /**
     * TEST
     *
     * @param SplSubject $eventManager
     */
    public function testEvent(\SplSubject $eventManager) {
        echo 'Event name capture:' . $eventManager->event->name     . PHP_EOL;
        echo 'Event name capture:' . $eventManager->event->function . PHP_EOL;
    }

    /**
     * TEST
     *
     * @param SplSubject $eventManager
     */
    public function testEventPropagation(\SplSubject $eventManager) {
        echo 'Propagation Event name capture:' . $eventManager->event->name     . PHP_EOL;
        echo 'Propagation Event name capture:' . $eventManager->event->function . PHP_EOL;
        $this->stopPropagation($eventManager);
    }

    /**
     * TEST
     *
     * @param SplSubject $eventManager
     */
    public function testEventProperties(\SplSubject $eventManager) {
        echo 'Properties Event name capture:' . $eventManager->event->name     . PHP_EOL;
        echo 'Properties Event name capture:' . $eventManager->event->function . PHP_EOL;
        $eventManager->event->properties['propertytochange'] = 'New Content';
    }

    /**
     * When observer wants to stop the further propagations of the event. It
     * requires the EventManager.
     *
     * @throws Exception
     */
    public function stopPropagation() {
        throw new \Mmf\MVC\Exception('Event propagation stop in ' .  get_class(), '600');
    }

    /**
     * Is the function that Event manager will invoke, when the event subscribe
     * for this class will be dispatch.
     *
     * @param SplSubject $eventManager
     */
    public function update(\SplSubject $eventManager) {
        $this->isUpdate = true;
        if ($eventManager->event->function !== NULL) {
            $this->{$eventManager->event->function}($eventManager);
        }
    }

}
