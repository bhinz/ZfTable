<?php

/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace ZfTable\Table;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Can creates any children from AbstractTable, invokes a new instance, but
 * injects the main service locator object into it.
 */
class TableAbstractServiceFactory implements AbstractFactoryInterface
{

    /**
     * Legacy and proxy method to canCreate
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $cName = null, $rName = null)
    {
        return $this->canCreate($serviceLocator, $rName);
    }

    /**
     * Legacy and proxy method to __invoke
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return object child class of \ZfTable\AbstractTable
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $cName = null, $rName = null)
    {
        return $this($serviceLocator, $rName);
    }

    /**
     * Can the factory create an instance for the service?
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        if (class_exists($requestedName)) {
            $reflect = new \ReflectionClass($requestedName);
            if ($reflect->isSubclassOf('ZfTable\AbstractTable')) {
                return true;
            }
        }
        return false;
    }

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object child class of \ZfTable\AbstractTable
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if ($this->canCreate($container, $requestedName)) {
            /**
             * @var \ZfTable\AbstractTable $table
             */
            $table = new $requestedName;

            //inject the decorator factory
            $table->setDecoratorFactory($container->get('ZfTable\Decorator\DecoratorFactory'));

            $config = $container->get('Config');
            $zftableConfig = isset($config['zftable']) ? $config['zftable'] : [];

            $table->setOptions($zftableConfig);

            $form   = $table->getForm();
            $filter = $table->getFilter();
            $form->setInputFilter($filter);

            return $table;
        }
        return null;
    }
}
