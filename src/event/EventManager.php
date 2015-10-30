<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Event;

/**
 * The MmfEventManager is a class used to manage the event dispached and notify
 * the observer listen to that events.
 *
 * This class have the static method instance, used to get one instance of the
 * class.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */

class EventManager implements EventManagerInterface{

    /**
     * List of Observers
     * @var SplObjectStorage
     */
    private $_observers;

    /**
     * @var EventAbstract
     */
    public $event;

    public function __construct() {
        $this->_observers = new \SplObjectStorage();
    }


    /**
     * Add new observer to the list
     *
     * @param \SplObserver        $observer
     * @param string|null         $eventName
     * @param string|null         $function
     * @param mixed |null         $order
     */
    public function attach(\SplObserver $observer, $eventName = Null, $function = Null, $order = Null) {
        $newEventAttach = new \stdClass();
        $newEventAttach->observer  = $observer;
        $newEventAttach->function  = $function;
        $newEventAttach->eventName = $eventName;
        $newEventAttach->order     = $order;
        $this->_observers->attach($newEventAttach);
    }

    /**
     * Delete the observer from the list
     *
     * @param \SplObserver $observer
     * @param string|null         $eventName
     * @param string|null         $function
     * @param mixed |null         $order
     */
    public function detach(\SplObserver $observer, $eventName = Null, $function = Null, $order = Null) {
        $newEventAttach = new \stdClass();
        $newEventAttach->observer  = $observer;
        $newEventAttach->function  = $function;
        $newEventAttach->eventName = $eventName;
        $newEventAttach->order     = $order;
        $this->_observers->detach($newEventAttach);
    }

    /**
     * Send a notification to the correct observer
     */
    public function notify() {
        $observersToNotify = array();

        //Check which observers must be update
        foreach ($this->_observers as $observer) {
            if ($this->checkIfObserverMustBeUpdate($observer)) {
                //Add the observers in array to be order for priority
                $observersToNotify[] = $observer;
            }
        }

        //Order the list of observers
        usort($observersToNotify, array($this,'orderObserversForPriority'));

        //Update the observers
        foreach ($observersToNotify as $observer) {
            try {
                $this->updateObserverState($observer);
            } catch (\Exception $e) {
                if ((int)$e->getCode()===600) { //Stop propagation
                    break 1;
                }
            }
        }

    }

    /**
     * Order The observers using the order integer value. Lower number is going
     * to execute first, in case of have the same order it goes first the first
     * observer assign to the event.
     *
     * @param stdClass $a
     * @param stdClass $b
     * @return int
     */
    private function orderObserversForPriority($a, $b) {
        if($a->order > $b->order) {
            return +1;
        } elseif ($a->order == $b->order) {
            return 0;
        }
        return -1;
    }

    /**
     * Returns if the observer must be update.
     *
     * @param StdClass $observer
     * @return boolean
     */
    private function checkIfObserverMustBeUpdate (\StdClass $observer) {
        if ($observer->eventName == $this->event->name) {
            return true;
        }
        return false;
    }

    /**
     * Update the correct observer match with the same name.
     *
     * @param StdClass $observer
     */
    private function updateObserverState(\StdClass $observer) {
        $this->event->function = $observer->function;
        $observerObject = $observer->observer;
        $observerObject->update($this);
    }

    /**
     * This method is used for other classes when they want to dispatch an
     * event. It requires and Event.
     *
     * @param EventAbstract $event
     * @return void
     */
    public function dispatch(EventAbstract $event) {
        $this->event = $event;
        $this->notify();
    }

}
