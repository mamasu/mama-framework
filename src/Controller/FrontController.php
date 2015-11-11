<?php

/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Controller;

/**
 * Is the controller in charge of instantiate all the controllers, init
 * the basic configuration and call the method of controller that will respond
 * to the request.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class FrontController {

    /**
     * @var \AutoloaderInterface
     */
    protected $autoload;

    /**
     * @var \ParametersInterface
     */
    protected $config;

    /**
     * @var PluginManagerInterface
     */
    protected $pluginManager;

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var PluginLocatorInterface
     */
    protected $pluginLocator;

    /**
     * @var array
     */
    protected $Structure;

    /**
     * @var array
     */
    protected $appLibraries;

    /**
     * @var array
     */
    protected $Libraries;

    /**
     * @var ErrorController
     */
    protected $errorController;

    /**
     * @var RoutingResolverAbstract
     */
    protected $routingResolver;

    /**
     * @var RoutingRuleAbstract
     */
    protected $routingRule;

    /**
     * @var CommunicationInterface
     */
    protected $communication;

    /**
     * @var ACLInterface
     */
    protected $acl;

    /**
     * @var BasicViewInterface
     */
    protected $view;

    /**
     * @var LanguageInterface
     */
    protected $language;

    /**
     *
     * @var SessionFactory
     */
    protected $sessionFactory;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var AuthInterface
     */
    protected $auth;

    /**
     * @var BasicControllerAbstract
     */
    private $controller;

    /**
     * @var CoreInterface
     */
    private $core;
    public $executionErrors = 0;
    public $messageErrors = '';
    public $traceRouteErrors = '';

    public function __construct(
        \Mmf\Autoloader\AutoloaderInterface $autoload,
        \Mmf\Parameter\ParametersInterface $config,
        \Mmf\IO\CommunicationInterface $communication
    ) {
        $this->autoload = $autoload;
        $this->config = $config;
        $this->communication = $communication;
    }

    /**
     * Is the function to start the Framework. Is usually call in index .
     *
     * @throws Exception
     */
    public function main() {
        $this->config->set('URLBase', $this->autoload->getURLBase());

        $this->setAndAppLibraries(); //Load All library paths, not include in try because ErrorController is not present.
        $this->loadAppFilesystem(); //Include the app filesystem structure into the loader path.

        $this->errorController = $this->getLibraryInstance('mvc', 'errorClass'); //Create error controller.
        //TODO log
        //$this->loadLibraryDirectory('io');
        try {

            return $this->createMVCAction(); //Load Event, Plugin, Language, Routing, Auth, ACL, View, and controllers.
        } catch (ControllerException $e) { //Catch the false response from controller, not catch the problem errors.
            return $this->routingRule->getOutput()->formatResponseBad(['errorCode' => $e->getCode(),
                        'errorMessage' => $e->getMessage()]);
        } catch (RoutingException $e) { //Catch the routing not resolve.
            $respAutoClass = $this->getLibraryInstance('io', 'respAutoClass', $this->config);
            /* @var $respAutoClass ResponseInterface */
            return $respAutoClass->formatResponseBad(['errorCode' => $e->getCode(),
                        'errorMessage' => 'The URL not match with any of our defined routes']);
            //TODO translate all the texts
        } catch (Exception $e) { //Catch the All other frameworks exceptions.
            $respAutoClass = $this->getLibraryInstance('io', 'respAutoClass', $this->config);
            /* @var $respAutoClass ResponseInterface */
            return $respAutoClass->formatResponseBad(['errorCode' => $e->getCode(),
                        'errorMessage' => $e->getMessage()]);
        } catch (Exception $e) { //Catch not controlled errors
            $this->executionErrors = 1;
            $this->messageErrors = 'File:' . $e->getFile() . ' File line:' . $e->getLine() . ', Message:' . $e->getMessage() . ', Traceroute:' . $e->getTraceAsString();
            $this->traceRouteErrors = $e->getTrace();
            $this->errorController->displayError(500);

            $respAutoClass = $this->getLibraryInstance('io', 'respAutoClass', $this->config);
            /* @var $respAutoClass ResponseInterface */
            return $respAutoClass->formatResponseBad(['errorCode' => $e->getCode(),
                        'errorMessage' => 'Internal Server Error']);
        }
    }

    /**
     * @throws ControllerException
     * @throws Exception
     * @throws Exception
     *
     * @return mixed controller->action return
     */
    protected function createMVCAction() {
        //Start new session
        $this->sessionFactory = $this->getLibraryInstance('session', 'sessionClass');
        $this->session = $this->sessionFactory->createSession();

        //Activate Event if the library it's included
        $this->activateEvent();

        //Create connection
        //TODO check, how to get the none connection bd class
        $this->connection = $this->getLibraryInstance('mvc', 'connectionClass', $this->config);

        //Create the translate object and translate the route input.
        //TODO Create Language and translate URL CLASS
        $this->language = $this->getLibraryInstance('language', 'languageClass', $this->communication, $this->config, $this->connection);

        //Activate the communication
        //$this->communication   = $this->getLibraryInstance('io', 'chanelClass');
        //Activate Routing
        $this->routingResolver = $this->getLibraryInstance('routing', 'routingClass', $this->communication, $this->language);

        //Start plugin managment & load install plugins if the library it's included
        //$this->activatePlugin();
        //Dispatch Core read event in case of Event library is included
        //$this->dispatchCoreReady(array());
        //Create SEO class and redirect the http request if is need.
        //TODO Create SEO CLASS
        //Execute Resolution of route, if is no possible to resolve RoutingException is throw
        $this->executeResolveRoute();

        //Execute Auth system, if the user is not authenticate a ControllerException is throw
        $this->executeAuth();

        //Execute the ACL system, if the user is not allowed ControllerException is throw
        $this->executeACL();
        //Up view, create core, create controller and execute action
        return $this->prepareAndCreateControllerAction();
    }

    /**
     * This method will create the view, the core and controller and
     * execute the action.
     *
     * @return mixed controller->action return
     */
    protected function prepareAndCreateControllerAction() {
        //Create the view controller
        $this->view = $this->getLibraryInstance('mvc', 'viewClass', $this->config);

        //Create the controller with the core.
        $controller = $this->createCoreAndController(
                $this->routingRule->getController() . 'Controller',
                $this->eventManager,
                $this->routingRule->getInput(),
                $this->routingRule->getOutput(),
                $this->view,
                $this->language,
                $this->routingResolver,
                $this->errorController,
                $this->session,
                $this->connection,
                $this->auth
        );

        //Execute the controller action with the parameters.
        $actionReturn = $this->callClassAndMethodWithInputArguments($controller, $this->routingRule->getAction(), $this->routingRule->getInput());

        //Format the response
        return $this->routingRule->getOutput()->formatResponse($actionReturn);
    }

    /**
     * Execute the Access Control List, throws and ControllerException if is not allowed.
     *
     * @throws ControllerException
     */
    protected function executeACL() {
        //Create the ACL
        $this->acl = $this->getLibraryInstance('acl', 'aclClass', $this->auth, $this->connection, $this->language);
        $isAllowed = $this->acl->isAllowed($this->routingRule);

        //Check if is allow to create the controller and call the action
        if (!$isAllowed) {
            throw new ControllerException('User not allow to access', 1500);
        }
    }

    /**
     * Execute the Authentication system, throws and ControllerException if
     * the session is not longer valid.
     *
     * @throws ControllerException
     */
    protected function executeAuth() {
        //Create Auth controller
        $this->auth = $this->getLibraryInstance('auth', 'authClass', $this->session, $this->routingRule->getInput(), $this->connection, $this->config, $this->language);
    }

    /**
     * Resolve the route.
     *
     * @throws \RoutingException when no route is matching
     */
    protected function executeResolveRoute() {
        //Add bulk routes
        $routingIniFile = $this->autoload->getURLBase() . $this->config->get('routing')['bulkRoutePath'];
        $this->routingResolver->addBulkRoutes($routingIniFile);

        //Resolve route
        $this->routingRule = $this->routingResolver->resolve();
    }

    /**
     * Set the libraries from the config and set the structure from the config
     * file.
     */
    private function setAndAppLibraries() {
        //Get the  libraries and application libraries
        $this->appLibraries = $this->config->get('app')['paths'];

        //Get the Structure
        $this->Structure = $this->config->get('Structure')['filesystem'];

        //Set to Autoloader the internal Structure
        $this->autoload->setStructure($this->Structure);
    }

    /**
     * Load the App file system.
     */
    protected function loadAppFilesystem() {
        foreach ($this->appLibraries as $value) {
            $this->autoload->addNewMmfAutoloadPath($value);
        }
    }

    /**
     * Activate Event System if is configure.
     */
    private function activateEvent() {
        //Init Event Manager
        $this->eventManager = $this->getLibraryInstance('event', 'eventClass');
    }

    /**
     * Activate Plugin System if Event and Plugin are configure.
     */
    private function activatePlugin() {

        //Get the locator Class from the config file, this will be needed
        //when the plugin locator is based on DB
        //Get the plugin locator instance
        $this->pluginLocator = $this->getLibraryInstance('plugin', 'locatorClass', $this->Structure);

        //Get the plugin manager instance
        $this->pluginManager = $this->getLibraryInstance('plugin', 'pluginClass', $this->config, $this->autoload, $this->eventManager, $this->pluginLocator, $this->routingResolver);

        //Init the plugins installed
        $this->pluginManager->initPluginInstalled();
    }

    /**
     * Dispatch the core event when all components are ready.
     *
     * @param mixed $properties
     */
    private function dispatchCoreReady($properties) {
        if (array_search('event', $this->Libraries) != NULL) {
            //Create Ready Event
            $event = new EventCoreReady();
            $event->properties = $properties; //Properties
            //Dispatch  Framework ready event
            $this->eventManager->dispatch($event);
        }
    }

    /**
     * Load the library directory
     *
     * @param string $libraryName
     * @return bool
     */
    private function loadLibraryDirectory($libraryName) {
        $paths = $this->config->get($libraryName)['paths'];
        if ($paths) {
            foreach ($paths as $path) {
                $this->autoload->addNewAutoloadPath($path);
            }
            //Add the library into the Library
            $this->Libraries[] = $libraryName;
            return true;
        }
        return false;
    }

    /**
     * Return the instance of the library class.
     *
     * @param string $libraryName
     * @param string $libraryClass
     *
     * @throws \InvalidArgumentException
     *
     * @return stdClass | null $libraryClass
     */
    private function getLibraryInstance($libraryName, $libraryClass) {
        $instance = null;
       // if ($this->loadLibraryDirectory($libraryName)) {
            $libraryClassName = $this->config->get($libraryName)[$libraryClass];
            if (class_exists($libraryClassName)) {
                if (count(func_get_args()) > 2) {
                    $arguments = array_slice(func_get_args(), 2, count(func_get_args()) - 2);
                    $ref = new \ReflectionClass($libraryClassName);
                    $instance = $ref->newInstanceArgs($arguments);
                    //$instance = new $libraryClassName(array_slice(func_get_args(), 2, count(func_get_args())-2));
                } else {
                    $instance = new $libraryClassName();
                }
                return $instance;
            } else {
                throw new \InvalidArgumentException('Invalid library class(' . $libraryClassName . ')');
            }
        //}
        throw new \InvalidArgumentException('We can not instantiate the library class (' . $libraryClassName . ')');
    }

    /**
     * Creates the Concret controller with the constructor parameters and
     *
     * @param                              $class
     * @param \PluginManagerInterface   $pluginManager
     * @param \EventManagerInterface    $eventManager
     * @param \RequestInterface         $request
     * @param \ResponseInterface        $response
     * @param \BasicViewInterface       $view
     * @param \LanguageInterface        $language
     * @param \RoutingResolverAbstract  $router
     * @param \ErrorControllerInterface $error
     * @param \SessionInterface         $session
     * @param \ConnectionInterface      $connection
     * @param \AuthInterface            $auth
     *
     * @return mixed
     * @throws \CoreException
     */
    public function createCoreAndController(
        $class,
        \Mmf\Event\EventManagerInterface $eventManager,
        \Mmf\IO\RequestInterface $request,
        \Mmf\IO\ResponseInterface $response,
        \Mmf\View\BasicViewInterface $view,
        \Mmf\Language\LanguageInterface $language,
        \Mmf\Routing\RoutingResolverAbstract $router,
        ErrorControllerInterface $error,
        \Mmf\Parameter\SessionInterface $session,
        \Mmf\Model\ConnectionInterface $connection,
        \Mmf\Auth\AuthInterface $auth
    ) {
        $coreClass = $this->config->get('mvc')['coreClass'];

        if (class_exists($class) && class_exists($coreClass)) {
            $this->core = new $coreClass(
                $this->autoload,
                $this->config,
                $eventManager,
                $request,
                $response,
                $view,
                $language,
                $router,
                $error,
                $session,
                $connection,
                $auth
            );

            $this->controller = new $class($this->core);
            return $this->controller;
        } else {
            $className = is_object($class) ? get_class($class) : $class;
            throw new \Mmf\Core\CoreException('Is not unable to create the controller'
            . ' (' . $className . '), check if the path is correct and if '
            . 'exists the controller or if The CoreClass is correct (' . $coreClass . ')');
        }
    }

    /**
     * Call a class and a method trying to pass the method recive in the request.
     * If the request doesn't have the parameters, it is set to false.
     *
     * @param string | object      $class to call the method
     * @param string               $method to be call
     * @param \RequestInterface $request
     *
     * @return mixed
     *
     * @throws \ControllerException
     * @throws \CoreException
     */
    public function callClassAndMethodWithInputArguments(
        $class,
        $method,
        \Mmf\IO\RequestInterface $request
    ) {
        $params = $this->getFunctionArguments($class, $method);

        $listOfParams = [];
        foreach ($params as $param) {
            $paramValue = $request->input($param['name']);
            if ($paramValue === null && $param['isOptional'] === false) {
                throw new ControllerException('The param ' . $param['name'] . ' is mandatory', 1501);
            } elseif ($paramValue === null && $param['isOptional'] === true) {
                $paramValue = $param['initialValue'];
            }
            $listOfParams[] = $paramValue;
        }
        if (!is_object($class)) {
            $class = new $class();
        }
        $returnOfAction = call_user_func_array(array($class, $method), $listOfParams);
        if ($returnOfAction !== false) {
            return $returnOfAction;
        } else {
            throw new CoreException('FrontController::callClassAndMethodWithInputArguments'
            . ', Is not unable to call the action (' . $method . ') with '
            . 'the parameters(' . print_r($listOfParams, true) . '), the expected name of parameters are'
            . '(' . print_r($params, true) . ')');
        }
    }

    /**
     * This function returns the arguments of the method in class send it in the
     * parameters.
     *
     * @param string | object $class
     * @param string $method
     * @return array of parameters <'name', 'isOptional', 'initialValue'>
     */
    public function getFunctionArguments($class, $method) {

        $ReflectionMethod = new \ReflectionMethod($class, $method);

        $paramsArray = array();
        foreach ($ReflectionMethod->getParameters() as $param) {
            $auxParam = array('name' => $param->getName(), 'isOptional' => false, 'initialValue' => null);
            if ($param->isOptional()) {
                $auxParam['isOptional'] = true;
                $auxParam['initialValue'] = $param->getDefaultValue();
            }
            $paramsArray[] = $auxParam;
        }
        return $paramsArray;
    }

    /**
     * Ask if the request is ajax.
     *
     * @return bool
     */
    private function isAjaxRequest() {
        $ajax = false;

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $ajax = true;
        }
        return $ajax;
    }

}
