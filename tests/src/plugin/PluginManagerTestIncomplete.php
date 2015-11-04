<?php

class PluginManagerTest extends  PHPUnit_Framework_TestCase {
    
    protected $mmfPluginManager;    
    protected static $prefix;    
    protected $pluginList;    
    protected $config;
    protected $eventManager;
    protected $pluginLocator;
    protected $loader;
    
    public static function setUpBeforeClass() {
        $prefix = __DIR__ . '/../../../src/'; 
        self::$prefix = $prefix;
        include_once __DIR__.  '/../include.php';
    }

    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $internalStructure = array("controllers", "models", "entities");
        $this->loader = new \Mmf\Autoloader\Autoloader($internalStructure, self::$prefix);
        $this->loader->addNewAutoloadPath('core/mmf/parameter/');
        $this->loader->addNewAutoloadPath('event/');               
        $this->loader->addNewMmfAutoloadPath('plugin/pluginA');
        
        $this->config        = new \Mmf\Parameter\Config();
        $this->eventManager  = new \Mmf\Event\EventManager();
        $this->pluginLocator = new \Mmf\Plugin\FileSystemPluginLocator($internalStructure);
        
        $this->communicator = $this->getMockBuilder('Mmf\IO\CommunicationInterface')
            ->disableOriginalConstructor()
            ->setMethods(array('route', 'setRoute', 'method', 'setMethod'))
            ->getMock();

        $this->communicator->expects($this->any())
            ->method('route')
            ->willReturn('testURL');

        $this->routing = new Mmf\Routing\RoutingResolver($this->communicator);

        $this->config->addConfigVars(self::$prefix.'plugin/config.ini');

        $this->mmfPluginManager = new \Mmf\Plugin\PluginManager($this->config,
                                                        $this->loader,
                                                        $this->eventManager,
                                                        $this->pluginLocator,
                                                        $this->routing); //Create the manager
        //$listOfAvailablePlugins = $mmfFileSystemPluginLocator->discoverPlugins($prefix.'plugin/plugins/');
        //var_dump($listOfAvailablePlugins);
    }
    
    protected function tearDown() {
        unset($this->loader);
        unset($this->config);
        unset($this->eventManager);
        unset($this->pluginLocator);
        unset($this->mmfPluginManager);
        
    }

    /**
     * @group pluginManager
     * @group plugin
     * @group modules
     * @group development
     * @group production
     */
    public function testManageAllPlugins() {        
        $this->pluginList = $this->mmfPluginManager->getPluginList();
        $this->assertEquals(count($this->pluginList), 3);
    }  
    
    /**
     * @group pluginManager
     * @group plugin
     * @group modules
     * @group development
     * @group production
     */
    public function testManageAllPluginsInstalled() {
        try {
            $listOfPlugins = $this->mmfPluginManager->initPluginInstalled();
        } catch (Exception $e) {     
            echo "ERROR INIT PLUGIN INSTALLED".PHP_EOL;
            $this->assertEquals(false, true);
        }        
        foreach ($listOfPlugins as $key => $plugin) {            
            $this->assertEquals($plugin->testPluginFunction(), true);
        }                
    }
    
    /**
     * @group plugin
     * @group modules
     * @group development
     * @group production
     */
    public function testInstallAndUninstallPlugin() {
        $pluginList = $this->mmfPluginManager->getPluginList();
        foreach ($pluginList as $plugin) {
            if(!$plugin['enabled']){
                $this->assertEquals($this->mmfPluginManager->pluginInstall($plugin['plugin']), true);
                $this->assertEquals($this->mmfPluginManager->pluginUninstall($plugin['plugin']), true);
            }
        }
                   
    }
    
}
