<?php

namespace LammCdn\View\Helper\Service;

use Cdn\View\Helper\Elements;
use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;


class LinkElementsFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $config = $serviceLocator->get('Config');
        $helper = new Elements($config['cdn']['elements'],
            $config['cdn']['link_helper']['enabled']);
        
        return $helper;
    }

}


