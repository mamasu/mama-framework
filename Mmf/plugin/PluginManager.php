<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Plugin;

/**
 * The PluginManager Load all the installed plugins, give a way to search
 * all the plugins in the filesystem, install and uninstall plugins.
 *
 * Description
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class PluginManager implements PluginManagerInterface {

    /**
     *
     * @var ParametersInterface
     */
    protected $parameters;

    /**
     *
     * @var AutoloaderInterface
     */
    protected $autoloader;

    /**
     *
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     *
     * @var PluginLocatorInterface
     */
    protected $pluginLocator;

    /**
     *
     * @var RoutingResolver
     */
    protected $routing;

    /**
     *
     * @var array
     */
    protected $pluginPaths;

    /**
     *
     * @var array (PluginInterface, ...)
     */
    public $pluginList = array();


    /**
     *
     * @param ParametersInterface $parameters
     * @param AutoloaderInterface $autoloader
     * @param EventManagerInterface $eventManager
     * @param PluginLocatorInterface $pluginLocator
     * @param RoutingResolver $routing
     */
    public function __construct(
        \Mmf\Parameter\ParametersInterface $parameters,
        \Mmf\Autoloader\AutoloaderInterface $autoloader,
        \Mmf\Event\EventManagerInterface $eventManager,
        PluginLocatorInterface $pluginLocator,
        \Mmf\Routing\RoutingResolver $routing
    ) {
        $this->parameters    = $parameters;
        $this->autoloader    = $autoloader;
        $this->eventManager  = $eventManager;
        $this->pluginLocator = $pluginLocator;
        $this->routing       = $routing;
        $this->pluginPaths   = $this->parameters->get('plugin')['pluginPaths'];
    }


    /**
     * Get the list of plugins installed and init them.
     *
     * @return false | array(PluginInterface)
     * @throws PluginException
     */
    public function initPluginInstalled() {
        try {
            foreach ($this->pluginPaths as $path) {
                //Get the installed plugins
                $newPluginInstalled = $this->pluginLocator->getInstalledPlugins($this->autoloader->getURLBase().$path);
                $listOfPluginsInstalled = $this->createPluginInstances($newPluginInstalled, true);
                foreach ($listOfPluginsInstalled as $newPlugin) {
                    $this->pluginList[] = $newPlugin['plugin'];
                }
            }
            return $this->pluginList;
        } catch (Exception $e) {
            throw new PluginException('Plugin Manager: Can not init all plugins. '
                    . 'Please find attach the error from the '
                    . 'initialization:'. $e->getMessage());
        }
    }

    /**
     * Return the list of all plugin available, installed and not installed.
     *
     * @return array PluginInterface
     * @throws PluginException
     */
    public function getPluginList() {
        $arrayPluginList = array();
        try {
            //Iterate over the plugins paths
            foreach ($this->pluginPaths as $path) {
                //Search new plugins
                $newPluginsDiscover = $this->pluginLocator->discoverPlugins($this->autoloader->getURLBase().$path);

                //Instantiate the plugins
                $listOfPluginsDiscover = $this->createPluginInstances($newPluginsDiscover);
                foreach ($listOfPluginsDiscover as $newPlugin) {
                    $arrayPluginList[] = array('plugin'=>$newPlugin['plugin'], 'enabled'=>$newPlugin['enabled']);
                }
            }
        } catch (\Exception $e) {
            throw new PluginException('Plugin Manager: Can not init all plugins. '
                    . 'Please find attach the error from the '
                    . 'initialization:'. $e->getMessage());
        }
        return (array)$arrayPluginList;
    }

    /**
     * Instantiate the plugins from pluginLocator and if is true the $init var,
     * it creates the plugin. The expected return value is a array of tuples
     * of plugin and if it's enabled or not.
     *
     * @param array      $plugins
     * @param bool|false $init
     *
     * @return array
     * @throws \PluginException
     */
    private function createPluginInstances($plugins, $init=false) {
        $pluginList = array();
        foreach ($plugins['pluginClasses'] as $key => $newPlugin) {
            //Load the concrete plugin directory
            $this->autoloader->addNewAutoloadPath($plugins['pluginDirectories'][$key], true);

            //Create new plugin instance

            if(class_exists($newPlugin)) {
                $newPluginInstantiation = new $newPlugin($this->parameters,
                                                        $this->autoloader,
                                                        $this->eventManager);
            } else {
                throw new PluginException('Plugin Manager: '
                        . 'Unable to instantiate the plugin with '
                        . 'name ('. $newPlugin. ') and path ('.
                        $plugins['pluginDirectories'][$key].')');
            }

            //Call Init function of the plugin
            if($init) {
                $newPluginInstantiation->init();
            }
            //Add the plugin instance into the plugin list
            $pluginList[] = ['plugin'=>$newPluginInstantiation,
                                  'enabled'=>$plugins['pluginEnabled'][$key]];
        }
        return $pluginList;
    }

    /**
     *
     * @param PluginInterface $plugin
     * @return bool
     * @throws PluginException
     */
    public function pluginInstall(PluginInterface $plugin) {
        try {
            $isPluginInstalled = $plugin->install();
        } catch(Exception $e) {
            throw new PluginException('Plugin Manager: cannot '
                    . 'install the plugin'. get_class($plugin));
        }

        return (bool)$isPluginInstalled;
    }

    /**
     *
     * @param PluginInterface $plugin
     * @return bool
     * @throws PluginException
     */
    public function pluginUninstall(PluginInterface $plugin) {
        try {
            $isPluginUninstalled = $plugin->uninstall();
        } catch(Exception $e) {
            throw new PluginException('Plugin Manager: cannot '
                    . 'uninstall the plugin'. get_class($plugin));
        }

        return (bool)$isPluginUninstalled;
    }
}
