<?php

namespace LammCdn;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\Mvc,
    Zend\EventManager\StaticEventManager;


class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{

    public function onBootstrap($e)
    {
        $app = $e->getParam('application');
        $serviceManager = $app->getServiceManager();

        $events = StaticEventManager::getInstance();
        $events->attach('*', 'log',
            function($event) use ($serviceManager) {
                $logger = $serviceManager->get('logger');
                $target = get_class($event->getTarget());
                $message = $event->getParam('message', 'No message provided');
                $priority = (int) $event->getParam('priority',
                        \Monolog\Logger::INFO);
                $logger->log($priority, sprintf('%s: %s', $target, $message));
            }
        );

        $e->getApplication()->getEventManager()->getSharedManager()->attach(
            'Zend\Mvc\Controller\AbstractActionController',
            Mvc\
            MvcEvent::EVENT_DISPATCH,
            function(Mvc\MvcEvent $event) {
                $application = $event->getApplication();
                $services = $application->getServiceManager();
                $view = $services->get('ViewRenderer');
                $controller = $event->getTarget();
                if ($controller instanceof Mvc\Controller\AbstractActionController) {
                    $params = $event->getRouteMatch()->getParams();
                    $modulo = "";
                    if (isset($params['__NAMESPACE__'])) {
                        $paramsArray = explode("\\", $params['__NAMESPACE__']);
                        $modulo = $paramsArray[0];
                    }
                    $controller = isset($params['__CONTROLLER__']) ? $params['__CONTROLLER__']
                            : "";

                    $action = $params['action'];

                    $paramsConfig = array(
                        'modulo' => strtolower($modulo),
                        'controller' => strtolower($controller),
                        'action' => strtolower($action),
                        'baseHost' => $view->base_path("/"),
                        'statHost' => $view->LinkCdn()->getUrl() . "/",
                        'eHost' => '',
                        'statVers' => '?' . $view->LinkCdn()->getLastCommit(),
                        'min' => '',
                        'AppCore' => array(),
                        'AppSandbox' => array(),
                        'AppSchema' => array(
                            'modules' => array(),
                            'requires' => array()
                        )
                    );
                    $view->inlineScript()->appendScript("var yOSON =" . json_encode(
                            $paramsConfig, JSON_FORCE_OBJECT)
                    );
                }
            }, 100);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            )
        );
    }

}


