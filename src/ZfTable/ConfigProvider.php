<?php
namespace ZfTable;

/**
 * Class ConfigProvider
 *
 * @package ZfTable
 */
class ConfigProvider
{
    /**
     * @return Array
     */
    public function __invoke()
    {
        return [
            'service_manager' => [
                'factories' => [
                    'ZfTable\Decorator\DecoratorFactory' => 'ZfTable\Decorator\Service\DecoratorFactoryFactory',
                    'ZfTable\Decorator\DecoratorPluginManager' => 'ZfTable\Decorator\Service\DecoratorPluginManagerFactory',
                ],
                'abstract_factories' => [
                    'ZfTable\Table\TableAbstractServiceFactory',
                ],
            ],
            'zftable_decorators' => [
                'factories' => [
                    'celllink'    => 'ZfTable\Decorator\Cell\LinkFactory',
                    'cellpartial' => 'ZfTable\Decorator\Cell\PartialFactory',
                ],
            ],
        ];
    }
}
