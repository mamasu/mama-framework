<?php

$prefix = __DIR__ . '/../../src/';
$prefixRouting = $prefix . 'routing/';
$prefixIO = $prefix . 'io/';

if (!class_exists('\Mmf\Exception')) {
    require_once($prefix . 'mvc/Exception.php');
}
if (!class_exists('\Mmf\AutoloaderInterface') && !class_exists('\Mmf\Autoloader')) {
    require_once($prefix . 'loader/Autoloader.php');
}
if (!class_exists('\Mmf\ACLInterface')) {
    require_once($prefix . 'acl/ACLInterface.php');
}
if (!class_exists('\Mmf\BasicModelInterface')) {
    require_once($prefix . 'mvc/BasicModelInterface.php');
}
if (!class_exists('\Mmf\MySQLModelAbstract')) {
    require_once($prefix . 'mvc/MySQLModelAbstract.php');
}
if (!class_exists('\Mmf\ACLModel')) {
    require_once($prefix . 'acl/ACLModel.php');
}
if (!class_exists('\Mmf\ACLException')) {
    require_once ($prefix . 'acl/ACLException.php');
}
if (!class_exists('\Mmf\ACL')) {
    require_once ($prefix . 'acl/ACL.php');
}
if (!class_exists('\Mmf\BasicViewInterface')) {
    require_once($prefix . 'mvc/BasicViewInterface.php');
}
if (!class_exists('\Mmf\BasicViewAbstract')) {
    require_once($prefix . 'mvc/BasicViewAbstract.php');
}
if (!class_exists('\Mmf\BasicView')) {
    require_once($prefix . 'mvc/BasicView.php');
}

if (!class_exists('\Mmf\ParametersInterface')) {
    require_once($prefix . 'parameter/ParametersInterface.php');
}
if (!class_exists('\Mmf\CoreInterface')) {
    require_once $prefix . 'mvc/CoreInterface.php';
}
if (!class_exists('\Mmf\ErrorControllerInterface')) {
    require_once($prefix . 'mvc/ErrorControllerInterface.php');
}
if (!class_exists('\Mmf\ErrorController')) {
    require_once($prefix . 'mvc/ErrorController.php');
}

if (!class_exists('\Mmf\Core')) {
    require_once $prefix . 'mvc/Core.php';
}
if (!class_exists('\Mmf\EventManagerInterface')) {
    require_once($prefix . 'event/EventManagerInterface.php');
}
if (!class_exists('\Mmf\EventAbstract')) {
    require_once($prefix . 'event/EventAbstract.php');
}
if (!class_exists('\Mmf\EventAbstract')) {
    require_once($prefix . 'event/EventAbstract.php');
}
if (!class_exists('\Mmf\EventManager')) {
    require_once($prefix . 'event/EventManager.php');
}
if (!class_exists('\Mmf\Event')) {
    require_once($prefix . 'event/Event.php');
}
if (!class_exists('\Mmf\EventObserver')) {
    require_once($prefix . 'event/EventObserver.php');
}

if (!class_exists('\Mmf\PluginManagerInterface')) {
    require_once($prefix . 'plugin/PluginManagerInterface.php');
}
if (!class_exists('\Mmf\PluginManager')) {
    require_once($prefix . 'plugin/PluginManager.php');
}
if (!class_exists('\Mmf\PluginManager')) {
    require_once($prefix . 'plugin/PluginManager.php');
}
if (!class_exists('\Mmf\PluginException')) {
    require_once($prefix . 'plugin/PluginException.php');
}
if (!class_exists('\Mmf\PluginLocatorInterface')) {
    require_once($prefix . 'plugin/PluginLocatorInterface.php');
}
if (!class_exists('\Mmf\PluginInterface')) {
    require_once($prefix . 'plugin/PluginInterface.php');
}
if (!class_exists('\Mmf\FileSystemPluginLocator')) {
    require_once($prefix . 'plugin/FileSystemPluginLocator.php');
}
if (!class_exists('\Mmf\RequestInterface')) {
    require_once($prefix . 'io/RequestInterface.php');
}
if (!class_exists('\Mmf\ResponseInterface')) {
    require_once($prefix . 'io/ResponseInterface.php');
}
if (!class_exists('\Mmf\ResponseAPIAutomatic')) {
    require_once($prefix . 'io/ResponseAPIAutomatic.php');
}
if (!class_exists('\Mmf\CommunicationInterface')) {
    require_once($prefix . 'io/CommunicationInterface.php');
}
if (!class_exists('\Mmf\CommunicationHttp')) {
    require_once($prefix . 'io/CommunicationHttp.php');
}
if (!class_exists('\Mmf\CommunicationTerminal')) {
    require_once($prefix . 'io/CommunicationTerminal.php');
}
if (!class_exists('\Mmf\RequestHtml')) {
    require_once ($prefix . 'io/RequestHtml.php');
}
if (!class_exists('\Mmf\ResponseHtml')) {
    require_once($prefix . 'io/ResponseHtml.php');
}
if (!class_exists('\Mmf\ResponseJson')) {
    require_once($prefix . 'io/ResponseJson.php');
}
if (!class_exists('\Mmf\RequestJson')) {
    require_once($prefix . 'io/RequestJson.php');
}



if (!class_exists('\Mmf\RoutingResolverAbstract')) {
    require_once($prefixRouting . 'RoutingResolverAbstract.php');
}
if (!class_exists('\Mmf\RoutingResolver')) {
    require_once($prefixRouting . 'RoutingResolver.php');
}
if (!class_exists('\Mmf\RoutingRuleAbstract')) {
    require_once($prefixRouting . 'RoutingRuleAbstract.php');
}
if (!class_exists('\Mmf\RoutingRule')) {
    require_once($prefixRouting . 'RoutingRule.php');
}
if (!class_exists('\Mmf\RoutingException')) {
    require_once($prefixRouting . 'RoutingException.php');
}



if (!class_exists('\Mmf\CoreException')) {
    require_once $prefix . 'mvc/CoreException.php';
}
if (!class_exists('\Mmf\ConnectionInterface')) {
    require_once($prefix . 'mvc/ConnectionInterface.php');
}
if (!class_exists('\Mmf\FrontController')) {
    require_once $prefix . 'mvc/FrontController.php';
}
if (!class_exists('\Mmf\BasicControllerInterface')) {
    require_once $prefix . 'mvc/BasicControllerInterface.php';
}
if (!class_exists('\Mmf\BasicControllerAbstract')) {
    require_once $prefix . 'mvc/BasicControllerAbstract.php';
}
if (!class_exists('TestController')) {
    require_once $prefix . 'mvc/controllers/TestController.php';
}
if (!class_exists('TestExtendsController')) {
    require_once $prefix . 'mvc/controllers/TestExtendsController.php';
}
if (!class_exists('\Mmf\PDO')) {
    require_once($prefix . 'mvc/PDO.php');
}
if (!class_exists('\Mmf\ModelException')) {
    require_once $prefix . 'mvc/ModelException.php';
}
if (!class_exists('testmodel')) {
    require_once $prefix . 'mvc/models/testmodel.php';
}
if (!class_exists('\Mmf\AbstractConfig')) {
    require_once $prefix . 'parameter/AbstractConfig.php';
}
if (!class_exists('\Mmf\Config')) {
    require_once $prefix . 'parameter/Config.php';
}

if (!class_exists('\Mmf\SessionInterface')) {
    require_once $prefix . 'parameter/SessionInterface.php';
}
if (!class_exists('\Mmf\SessionException')) {
    require_once $prefix . 'parameter/SessionException.php';
}
if (!class_exists('\Mmf\LanguageException')) {
    require_once($prefix . 'language/LanguageException.php');
}
if (!class_exists('\Mmf\TranslateException')) {
    require_once($prefix . 'language/TranslateException.php');
}
if (!class_exists('\Mmf\LanguageInterface')) {
    require_once($prefix . 'language/LanguageInterface.php');
}
if (!class_exists('\Mmf\LanguageDB')) {
    require_once($prefix . 'language/LanguageDB.php');
}
if (!class_exists('\Mmf\TranslatorInterface')) {
    require_once($prefix . 'language/TranslatorInterface.php');
}
if (!class_exists('\Mmf\Translator')) {
    require_once($prefix . 'language/Translator.php');
}
if (!class_exists('\Mmf\TranslateException')) {
    require_once($prefix . 'language/TranslateException.php');
}
if (!class_exists('\Mmf\Session')) {
    require_once $prefix . 'parameter/Session.php';
}
if (!class_exists('\Mmf\SessionFactory')) {
    require_once $prefix . 'parameter/SessionFactory.php';
}
if (!class_exists('\Mmf\ErrorControllerInterface')) {
    require_once $prefix . 'mvc/ErrorControllerInterface.php';
}
if (!class_exists('\Mmf\Auth\AuthException')) {
    require_once $prefix . 'auth/AuthException.php';
}
if (!class_exists('\Mmf\Auth\AuthInterface')) {
    require_once $prefix . 'auth/AuthInterface.php';
}
if (!class_exists('\Mmf\Auth')) {
    require_once $prefix . 'auth/Auth.php';
}
if (!class_exists('\Mmf\AuthAPI')) {
    require_once $prefix . 'auth/AuthAPI.php';
}
if (!class_exists('\Mmf\AuthBasic')) {
    require_once $prefix . 'auth/AuthBasic.php';
}
if (!class_exists('\Mmf\AuthModel')) {
    require_once $prefix . 'auth/AuthModel.php';
}
if (!class_exists('\Mmf\LanguageModel')) {
    require_once($prefix . 'language/LanguageModel.php');
}
if (!class_exists('\Mmf\ControllerException')) {
    require_once($prefix . 'mvc/ControllerException.php');
}

if (!class_exists('\Mmf\Log')) {
    require_once($prefix . '/log/Log.php');
}
/*
if (!class_exists('\App\ProductController')) {
    require_once($prefix . 'core/app/controllers/ProductController.php');
}*/