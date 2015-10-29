<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
gc_disable();

use Mmf\Event\EventManager;
use Mmf\Event\EventObserver;
use Mmf\Event\Event;

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The MmfEventManager bla bla...
 *
 * Description
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 * 
 */
class EventManagerTest extends \PHPUnit_Framework_TestCase {
    
    
    
    public static function setUpBeforeClass() {
        //include_once __DIR__.'/../include.php';     
    }
    
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        
    }

    
    /**
     * @group event
     * @group modules
     * @group development
     * @group production
     */
    public function testDispatch() {
        //EXAMPLE OF EVENT MARKETPLACE MANAGMENT
        $MmfEventManager   = new EventManager(); //Creates the Manager
        $MmfEventObserver  = new EventObserver(); //Creates a example of Observer
        $MmfEventObserver1 = new EventObserver(); //Creates a example of Observer
        $MmfEventObserver2 = new EventObserver(); //Creates a example of Observer
        $MmfEvent          = new Event(); //Creates a custom method

        //Example of Event with properties that are being change in the observer code.
        $property = 1;

        //Set Event attributes
        $MmfEvent->name     = 'Test.Event'; //Set the name of the custom method
        $MmfEvent->properties['propertytochange'] = &$property;

        //Attach the a class to the Event with the Event Name (Observer, Event, Function)
        $MmfEventManager->attach($MmfEventObserver2, 'Test.Event', 'testEventProperties', 1);
        $MmfEventManager->attach($MmfEventObserver1, 'Test.Event', 'testEventPropagation', 2);
        $MmfEventManager->attach($MmfEventObserver,  'Test.Event', 'testEvent', 3);        

        //Dispatch the event
        $MmfEventManager->dispatch($MmfEvent);
        
        $this->assertEquals($property, 'New Content');
        $this->assertEquals(true,  $MmfEventObserver2->isUpdate);
        $this->assertEquals(true,  $MmfEventObserver1->isUpdate);
        $this->assertEquals(false, $MmfEventObserver->isUpdate);
        
        unset($MmfEventManager);
        unset($MmfEventObserver);
        unset($MmfEventObserver1);
        unset($MmfEventObserver2);
        unset($MmfEvent);
    }
}
