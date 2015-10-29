<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Plugin;

/**
 * The FileSystemPluginLocator brings to the plugin manager a way to discover
 * the new plugins and the installed plugins.
 *
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class FileSystemPluginLocator implements PluginLocatorInterface{

    /**
     * Internal plugin structure.
     *
     * @var array
     */
    protected $internalPluginStructure = array();

    public function __construct($internalPluginStructure){
        $this->internalPluginStructure = $internalPluginStructure;
    }

    /**
     * Return all the plugin installed classes found in the concrete path.
     *
     * @param string $path
     * @return array('pluginClasses'=>$factoryPluginClasses,'pluginDirectories'=>$validPluginDirectories)
     */
    public function getInstalledPlugins($path) {
        $searchPluginDirectories = $this->searchPluginDirectories($path);
        $validPluginDirectories  = array();
        $factoryPluginClasses    = array();
        foreach ($searchPluginDirectories as $pluginDirectory) {
            if (is_file($pluginDirectory. '/enable.php')) {
                $validPluginClass = $this->searchPluginFactoryClass($pluginDirectory);
                if ($validPluginClass) {
                    $validPluginDirectories[] = $pluginDirectory;
                    $factoryPluginClasses[] = $validPluginClass;
                }
            }
        }
        return array('pluginClasses'    => $factoryPluginClasses,
                     'pluginDirectories'=> $validPluginDirectories,
                     'pluginEnabled'    => true
                     );
    }

    /**
     *
     * Return all the plugin classes found in the concrete path.
     *
     * @param string $path
     * @return array('pluginClasses'=>$factoryPluginClasses,'pluginDirectories'=>$validPluginDirectories, 'pluginEnabled'=>$enablePlugins)
     *
     */
    public function discoverPlugins($path) {
        $searchPluginDirectories = $this->searchPluginDirectories($path);
        $validPluginDirectories  = array();
        $factoryPluginClasses    = array();
        $enablePlugins           = array();
        foreach ($searchPluginDirectories as $pluginDirectory) {
            $validPluginClass = $this->searchPluginFactoryClass($pluginDirectory);
            if ($validPluginClass) {
                $enablePlugin = is_file($pluginDirectory. '/enable.php')?true:false;
                $enablePlugins[] = $enablePlugin;
                $validPluginDirectories[] = $pluginDirectory;
                $factoryPluginClasses[] = $validPluginClass;
            }
        }
        return array('pluginClasses'    => $factoryPluginClasses,
                     'pluginDirectories'=> $validPluginDirectories,
                     'pluginEnabled'    => $enablePlugins);
    }

    /**
     * Given a path it give the directories.
     *
     * @param string $path
     *
     * @return array pluginDirectories
     * @throws \PluginException
     */
    protected function searchPluginDirectories($path) {
        $pluginDirectories = array();
        if ( ($directoryHandle = opendir($path)) == true ) {
            while (($fileOrDir = readdir( $directoryHandle )) !== false) {
                if (is_dir($path. $fileOrDir ) && $fileOrDir !== '.' && $fileOrDir !=='..') {
                    $pluginDirectories[] = $path. $fileOrDir;
                }
            }
        } else {
            throw new PluginException('Invalid plugin path, check the main config.ini file');
        }
        return $pluginDirectories;
    }

    /**
     * Given the plugin directory it search, based on plugin structure, if
     * exists a pluginFactoryClass to call to get ready the plugin.
     *
     * @param string $pluginDirectory
     *
     * @return PluginInterface|null
     * @throws \PluginException
     */
    protected function searchPluginFactoryClass($pluginDirectory) {
        foreach ($this->internalPluginStructure as $pluginStructure) {
            $path = $pluginDirectory.'/'.$pluginStructure.'/';
            if ( ($directoryHandle = opendir($path)) == true ) {
                while (($fileOrDir = readdir( $directoryHandle )) !== false) {
                    if (is_file($path. $fileOrDir) && $this->isPhpFile($path.$fileOrDir)) {
                        $classImplementation = $this->haveTheFileImplementationOf($path. $fileOrDir);
                        if ($classImplementation) {
                            return $classImplementation;
                        }
                    }
                }
            } else {
                throw new PluginException('Invalid plugin structure path, check the main config.ini file');
            }
        }

        return null;

    }

    /**
     * Given a path to a file it return if is php or not.
     *
     * @param string $pathTofile
     * @return boolean
     */
    private function isPhpFile($pathTofile) {
        $info = new SplFileInfo($pathTofile);
        if ($info->getExtension() == "php") {
            return true;
        }
        return false;
    }

    /**
     * Open the given path file and search for a plugin implementation. It returns
     * the class name in a positive case.
     *
     * @param string $file
     * @param string $implementation
     * @return boolean|string
     */
    public function haveTheFileImplementationOf($file, $implementation = 'PluginInterface') {
        $matches = array();
        $fp = fopen($file, 'r');
        while (!feof($fp)) {
            $line = stream_get_line($fp, 1000000, "\n");
            if (preg_match('/class\s+(\w+)(.*)\simplements\s+(\w+)(.*)?\{/', $line, $matches)) {
                if ($matches[3] === $implementation) {
                    return $matches[1]; //Return the class name
                }
            }
        }
        return false;
    }
}
