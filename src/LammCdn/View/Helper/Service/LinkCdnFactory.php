<?php

namespace LammCdn\View\Helper\Service;

use Cdn\View\Helper\Link;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LinkCdnFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $config = $serviceLocator->get('Config');
        $helper = new Link($config['cdn']['servers'],
            $config['cdn']['link_helper']['enabled']);

        return $helper;
    }

}
