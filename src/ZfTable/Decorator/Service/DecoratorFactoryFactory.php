<?php

/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace ZfTable\Decorator\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfTable\Decorator\DecoratorFactory;

class DecoratorFactoryFactory implements FactoryInterface
{

    /**
     * Class responsible for instantiating a DecoratorFactory
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return DecoratorFactory
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $decoratorFactory = new DecoratorFactory;
        $decoratorFactory->setPluginManager($serviceLocator->get('ZfTable\Decorator\DecoratorPluginManager'));

        return $decoratorFactory;
    }
}
