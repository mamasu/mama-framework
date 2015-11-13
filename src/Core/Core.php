<?php
/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Core;

use Mmf\Autoloader\AutoloaderInterface;
use Mmf\Parameter\ParametersInterface;
use Mmf\Parameter\SessionInterface;
use Mmf\Plugin\PluginManagerInterface;
use Mmf\Event\EventManagerInterface;
use Mmf\IO\RequestInterface;
use Mmf\IO\ResponseInterface;
use Mmf\View\BasicViewInterface;
use Mmf\Model\ConnectionInterface;
use Mmf\Controller\ErrorControllerInterface;
use Mmf\Language\LanguageInterface;
use Mmf\Routing\RoutingResolverAbstract;
use Mmf\Auth\AuthInterface;

/**
 * The CoreInterface this class give a way to access to all core libraries,
 * and if in the future is need it to include more libraries we don't need to
 * modify all the MVC classes.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class Core implements CoreInterface {

    /**
     * @var \AutoloaderInterface
     */
    public $autoloader;

    /**
     * @var \ParametersInterface
     */
    public $config;

    /**
     * @var \PluginManagerInterface
     */
    public $pluginManager;

    /**
     * @var \EventManagerInterface
     */
    public $eventManager;

    /**
     * @var \RequestInterface
     */
    public $request;

    /**
     * @var \ResponseInterface
     */
    public $response;

    /**
     * @var \BasicViewInterface
     */
    public $view;

    /**
     * @var \LanguageInterface
     */
    public $language;

    /**
     * @var \RoutingResolverAbstract
     */
    public $router;

    /**
     * @var \ErrorControllerInterface
     */
    public $error;

    /**
     * @var \SessionInterface
     */
    public $session;

    /**
     * @var \ConnectionInterface
     */
    public $connection;

    /**
     * @var \AuthInterface
     */
    public $auth;

    /**
     * @param \AutoloaderInterface      $autoloader
     * @param \ParametersInterface      $config
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
     */
    public function __construct(AutoloaderInterface      $autoloader,
                                ParametersInterface      $config,
                                EventManagerInterface    $eventManager,
                                RequestInterface         $request,
                                ResponseInterface        $response,
                                BasicViewInterface       $view,
                                LanguageInterface        $language,
                                RoutingResolverAbstract  $router,
                                ErrorControllerInterface $error,
                                SessionInterface         $session,
                                ConnectionInterface      $connection,
                                AuthInterface            $auth) {
        $this->autoloader    = $autoloader;
        $this->config        = $config;
        //$this->pluginManager = $pluginManager;
        $this->eventManager  = $eventManager;
        $this->request       = $request;
        $this->response      = $response;
        $this->view          = $view;
        $this->language      = $language;
        $this->router        = $router;
        $this->error         = $error;
        $this->session       = $session;
        $this->connection    = $connection;
        $this->auth          = $auth;
    }

    /**
     * @return AutoloaderInterface
     */
    public function autoloader() {
        return $this->autoloader;
    }

    /**
     * @return ParametersInterface
     */
    public function config() {
        return $this->config;
    }

    /**
     * @return EventManagerInterface
     */
    public function eventManager() {
        return $this->eventManager;
    }

    /**
     * @return RequestInterface
     */
    public function request() {
        return $this->request;
    }

    /**
     * @return ResponseInterface
     */
    public function response() {
        return $this->response;
    }

    /**
     * @return BasicViewInterface
     */
    public function view() {
        return $this->view;
    }

    /**
     * @return LanguageInterface
     */
    public function language() {
        return $this->language;
    }

    /**
     * @return RoutingResolverAbstract
     */
    public function router() {
        return $this->router;
    }

    /**
     * @return ErrorControllerInterface
     */
    public function error() {
        return $this->error;
    }

    /**
     * @return SessionInterface
     */
    public function session() {
        return $this->session;
    }

    /**
     * @return ConnectionInterface
     */
    public function connection() {
        return $this->connection;
    }

    /**
     * @return \AuthInterface
     */
    public function auth() {
        return $this->auth;
    }
}

