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
use Zend\ServiceManager\Config as ConfigServiceMgr;
use ZfTable\Decorator\DecoratorPluginManager;

class DecoratorPluginManagerFactory implements FactoryInterface
{

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
     * @return DecoratorPluginManager
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config           = $container->has('Config') ? $container->get('Config') : array();
        $decoratorsConfig = isset($config['zftable_decorators']) ? $config['zftable_decorators'] : array();
        $configSevice     = new ConfigServiceMgr($decoratorsConfig);

        $plugins = new DecoratorPluginManager($configSevice);
        $plugins->setServiceLocator($container);

        if (isset($config['di']) && $container->has('Di')) {
            $plugins->addAbstractFactory($container->get('DiAbstractServiceFactory'));
        }

        return $plugins;
    }
}
