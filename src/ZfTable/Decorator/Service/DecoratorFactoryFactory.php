<?php

/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace ZfTable\Decorator\Service;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
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
    public function createService(ServiceLocatorInterface $serviceLocator, $cName = null, $rName = null)
    {
        return $this($serviceLocator, $rName);
    }

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return DecoratorFactory
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $decoratorFactory = new DecoratorFactory;
        $decoratorFactory->setPluginManager($container->get('ZfTable\Decorator\DecoratorPluginManager'));

        return $decoratorFactory;
    }
}
