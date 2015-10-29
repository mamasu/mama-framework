<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Plugin;

/**
 * The PluginLocatorInterface bla bla...
 *
 * Description
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
interface PluginLocatorInterface {

    /**
     * Return all the plugin installed classes found in the concrete path.
     *
     * @param string $path
     * @return array('pluginClasses'=>...,'pluginDirectories'=>..., 'pluginEnabled'=>...)
     */
    public function getInstalledPlugins($path);

    /**
     *
     * Return all the plugin classes found in the concrete path.
     *
     * @param string $path
     * @return array('pluginClasses'=>...,'pluginDirectories'=>..., 'pluginEnabled'=>...)
     *
     */
    public function discoverPlugins($path);
}
