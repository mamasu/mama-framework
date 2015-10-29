<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Plugin;

/**
 * The PluginInterface Load all the installed plugins, give a way to search
 * all the plugins in the filesystem, install and uninstall plugins.
 *
 * Description
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
interface PluginInterface {
    /**
     * Function used to initialize the plugin. Into the init function must be all
     * the event subscription.
     *
     * @return bool
     */
    public function init();

    /**
     * Function used to install the plugin dependencies, like Database tables or
     * some config parameters.
     *
     * @return bool
     */
    public function install();

    /**
     * Function used to uninstall the plugin. Like delete database tables
     * or remove the config parameters.
     *
     * @return bool
     */
    public function uninstall();
}
