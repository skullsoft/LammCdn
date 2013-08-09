<?php

namespace LammCdn\View\Helper\Service;

use LammCdn\View\Helper\FooterScript;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FooterScriptCdnFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $config = $serviceLocator->get('Config');
        $helper = new FooterScript($config['cdn']['servers']);

        return $helper;
    }

}
