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
interface PluginManagerInterface {


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
    );

    /**
     * Get the list of plugins installed and init them.
     *
     * @return boolean
     * @throws PluginException
     */
    public function initPluginInstalled();

    /**
     * Return the list of all plugin installed.
     *
     * @return array PluginInterface
     * @throws PluginException
     */
    public function getPluginList();

    /**
     *
     * @param PluginInterface $plugin
     * @return bool
     * @throws PluginException
     */
    public function pluginInstall(PluginInterface $plugin);

    /**
     *
     * @param PluginInterface $plugin
     * @return bool
     * @throws PluginException
     */
    public function pluginUninstall(PluginInterface $plugin);
}
