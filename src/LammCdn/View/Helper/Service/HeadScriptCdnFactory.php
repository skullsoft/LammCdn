<?php

namespace LammCdn\View\Helper\Service;

use Cdn\View\Helper\HeadScript;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HeadScriptCdnFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $config = $serviceLocator->get('Config');
        $helper = new HeadScript($config['cdn']['servers']);

        return $helper;
    }

}
