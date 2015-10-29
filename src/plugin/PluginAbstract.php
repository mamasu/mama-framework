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
abstract class PluginAbstract{

    /**
     * Set the environment vars and init the first configuration parameters,
     * like routing, config, or external libs path.
     *
     * @param ParametersInterface $config
     * @param AutoloaderInterface $autoloader
     * @param EventManagerInterface $eventManager
     */
    public function __construct(\Mmf\Parameter\ParametersInterface $config,
                                \Mmf\Autoloader\AutoloaderInterface $autoloader,
                                \Mmf\Event\EventManagerInterface $eventManager) {

    }

}
