<?php

namespace LammCdn\View\Helper\Service;

use LammCdn\View\Helper\HeadLink;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HeadLinkCdnFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $config = $serviceLocator->get('Config');
        $helper = new HeadLink($config['cdn']['servers']);

        return $helper;
    }

}
