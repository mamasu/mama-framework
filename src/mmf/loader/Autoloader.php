<?php
/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Autoloader;

/**
 * The Autoloader and AutoloaderPath give a way to include the files need for
 * the execution in the Framework. We register the new path using the function
 * spl_autoload_register.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
interface AutoloaderInterface {
    /**
     * Add the path, include in the var $autoloadPath, into the search path of
     * the system.
     *
     * @param string $autoloadPath path to be include
     * @param bool | string $notUseURLBase
     */
    public function addNewAutoloadPath($autoloadPath, $notUseURLBase=false);

    /**
     * Add the path, include in the var $autoloadPath, into the search path of
     * the system. Will include controllers/, models/ entities/.
     *
     * @param string $autoloadPath path to be include
     * @param bool | string $notUseURLBase
     */
    public function addNewMmfAutoloadPath($autoloadPath, $notUseURLBase=false);

    /**
     * Set the Structure.
     *
     * @param array $internalStructure
     */
    public function setStructure($internalStructure = array('controllers', 'models', 'entities'));


    /**
     * Return the array of  Structure.
     *
     * @return array
     */
    public function getStructure();

    /**
     * Return the URL base as String.
     *
     * @return string
     */
    public function getURLBase();

}

class Autoloader implements AutoloaderInterface {

    /**
     * URL From autoloader load the libs.
     *
     * @var string
     */
    protected $urlBase;

    /**
     * Internal  Structure, Ex; controllers, models, entities.
     *
     * @var array
     */
    protected $internalStructure = array();

    /**
     * @param array        $internalStructure
     * @param string|false $urlBase
     */
    public function __construct($internalStructure = array('controllers', 'models', 'entities') ,
                                $urlBase = false) {
        $this->internalStructure = $internalStructure;
        $this->urlBase = ($urlBase)?$urlBase:dirname(__FILE__);
    }

    /**
     * Return the array of  Structure.
     *
     * @return array
     */
    public function getStructure() {
        return $this->internalStructure;
    }

    /**
     * Set the  Structure.
     *
     * @param array $internalStructure
     */
    public function setStructure($internalStructure = array('controllers', 'models', 'entities')) {
        $this->internalStructure = $internalStructure;
    }

    /**
     * Return the URL base as String.
     *
     * @return string
     */
    public function getURLBase() {
        return $this->urlBase;
    }

    /**
     * Add the path, include in the var $autoloadPath, into the search path of
     * the system.
     *
     * @param string $autoloadPath
     * @param bool | string $notUseURLBase
     */
    public function addNewAutoloadPath($autoloadPath, $notUseURLBase = false) {
        $autoloader = new AutoloaderPath((string)$autoloadPath,
                                            $this->internalStructure,
                                            (!$notUseURLBase)?$this->urlBase:'');
        $autoloader->includePath();
    }

    /**
     * Add the path, include in the var $autoloadPath, into the search path of
     * the system. Will include controllers/, models/ entities/.
     *
     * @param string $autoloadPath
     * @param bool | string $notUseURLBase
     */
    public function addNewMmfAutoloadPath($autoloadPath, $notUseURLBase = false) {
        $autoloader = new AutoloaderPath((string)$autoloadPath,
                                            $this->internalStructure,
                                            (!$notUseURLBase)?$this->urlBase:'');
        $autoloader->includeMmfPath();
    }
}

class AutoloaderPath {

    /**
     * URL From autoloader load the libs.
     *
     * @var string
     */
    protected $urlBase;

    /**
     * Internal  Structure, Ex; controllers, models, entities.
     *
     * @var array
     */
    protected $internalStructure = array();

    /**
     *
     * @var string
     */
    protected $autoloadPath;

    /**
     * Add new path, included in the var $autoloadPath, into the search path of
     * the system
     *
     * @param string       $autoloadPath
     * @param array        $internalStructure
     * @param string|false $urlBase
     */
    public function __construct($autoloadPath,
                                $internalStructure = array('controllers', 'models', 'entities'),
                                $urlBase = false) {
        $this->internalStructure = $internalStructure;
        $this->urlBase = ($urlBase !== false)?$urlBase:dirname(__FILE__);
        $this->autoloadPath = (string)$autoloadPath;
    }

    /**
     * Include the path as a new path to search new classes.
     */
    public function includePath() {
        spl_autoload_register(function ($class) {
            if(!class_exists($class)) {
                $this->includeTheFile($this->autoloadPath . '/' . $class . '.php');
            }
        });
    }

    /**
     * Include the path as  path. This means that will be ready the classes
     * under the path controllers/, models/ entities/, with the extended
     * classes.
     *
     */
    public function includeMmfPath() {
        spl_autoload_register(function ($class) {
            if(!class_exists($class)) {
                $this->includeControllersModelsEntities($class);
            }
        });
    }


    /**
     * Include the common directories of .
     *
     * @param string $class
     */
    protected function includeControllersModelsEntities($class) {
        //Include the Extended Classes
        foreach ($this->internalStructure as $Directory) {
            $this->includeTheFile( $this->autoloadPath . '/'.$Directory.'/' . $class . '.php' );
        }

        //Include the None Extended Classes
        foreach ($this->internalStructure as $Directory) {
            $this->includeTheFile( $this->autoloadPath . '/'.$Directory.'/' . $this->strLastReplace('Extended','',$class) . '.php' );
        }

    }

    /**
     * Include the file if exists
     *
     * @param string $path
     */
    protected function includeTheFile($path) {
        $path = $this->urlBase    .$path;
        if(file_exists($path)) {
            /** @noinspection PhpIncludeInspection */
            require_once ($path);
        }
    }

    /**
     * Replace the last ocurrence of search
     *
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @return string
     */
    protected function strLastReplace($search, $replace, $subject) {
        $pos = strrpos($subject, $search);

        if($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }
}