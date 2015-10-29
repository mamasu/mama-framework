<?php
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
class FileSystemPluginLocatorTest extends PHPUnit_Framework_TestCase {

    protected $mmfFileSystemPluginLocator;
    protected $prefix;
    protected $internalStructure;
    protected $autoloader;

    public static function setUpBeforeClass() {
        include_once __DIR__ . '/../include.php';
    }
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        
        $this->prefix = __DIR__ . '/../../../src/';
        $this->internalStructure = array("controllers", "models", "entities");
        $this->loader = new \Mmf\Autoloader\Autoloader($this->internalStructure, $this->prefix);
        $this->loader->addNewAutoloadPath('config/');
        $this->loader->addNewAutoloadPath('event/');
        $this->loader->addNewAutoloadPath('plugin/');
        $this->loader->addNewMmfAutoloadPath('plugin/pluginA');

        $this->mmfFileSystemPluginLocator = new \Mmf\Plugin\FileSystemPluginLocator($this->internalStructure);
    }
    
    protected function tearDown() {
        unset($this->loader);
        unset($this->mmfFileSystemPluginLocator);
    }

    /**
     * @group plugin
     * @group modules
     * @group development
     * @group production
     */
    public function testDiscoverPlugins() {
        $listOfAvailablePlugins = $this->mmfFileSystemPluginLocator->discoverPlugins($this->prefix . 'plugin/plugins/');

        $this->assertEquals(count($listOfAvailablePlugins['pluginClasses']), 3);
        $this->assertEquals(count($listOfAvailablePlugins['pluginDirectories']), 3);
        $this->assertEquals(count($listOfAvailablePlugins['pluginEnabled']), 3);
        $this->assertEquals($listOfAvailablePlugins['pluginEnabled'][0], true);
        $this->assertEquals($listOfAvailablePlugins['pluginEnabled'][1], true);
        $this->assertEquals($listOfAvailablePlugins['pluginEnabled'][2], false);
    }

    /**
     * @group plugin
     * @group modules
     * @group development
     * @group production
     */
    public function testDiscoverInstalledPlugins() {
        $listOfAvailablePlugins = $this->mmfFileSystemPluginLocator->getInstalledPlugins($this->prefix . 'plugin/plugins/');

        $this->assertEquals(count($listOfAvailablePlugins['pluginClasses']), 2);
        $this->assertEquals(count($listOfAvailablePlugins['pluginDirectories']), 2);
    }

    /**
     * @group plugin
     * @group modules
     * @group development
     * @group production
     */
    public function testNonInternalStructure() {
        $mmfFileSystemPluginLocator = new \Mmf\Plugin\FileSystemPluginLocator(array());
        $listOfAvailablePlugins = $mmfFileSystemPluginLocator->getInstalledPlugins($this->prefix . 'plugin/plugins/');
        
        $this->assertEquals(count($listOfAvailablePlugins['pluginClasses']), 0);
        
        unset($mmfFileSystemPluginLocator);
    }

}
