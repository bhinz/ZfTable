<?php
/**
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright Copyright (c) 2015 Vinicius Fagundes
 */

namespace ZfTable\Decorator\Cell;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class LinkFactory
 */
class LinkFactory implements FactoryInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * LinkFactory constructor.
     * @param array|null $options
     */
    public function __construct($options = null)
    {
        $this->options = $options ?: [];
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Link
     */
    public function createService(ServiceLocatorInterface $serviceLocator, $cName = null, $rName = null)
    {
        return $this($serviceLocator, $rName);
    }

    /**
     * {@inheritDoc}
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return Link
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // test if we are using Zend\ServiceManager v2 or v3
        if (!method_exists($container, 'configure')) {
            $container = $container->getServiceLocator();
        }

        $viewHelperManager = $container->get('ViewHelperManager');

        $decorator = new Link($this->options);
        if (!$viewHelperManager || !$viewHelperManager->has('basePath')) {
            throw new ServiceNotCreatedException('BasePath Helper couldn\'t be created!');
        }
        $decorator->setBasePathHelper($viewHelperManager->get('basePath'));

        return $decorator;
    }
}
