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
                    'ZfTable\Decorator\DecoratorFactory'       => 'ZfTable\Decorator\Service\DecoratorFactoryFactory',
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
            'asset_manager' => [
                'resolver_configs' => [
                    'map' => [
                        /*ZF TABLE*/
                        'js/zf-table.js' => __DIR__ . '/../src/ZfTable/Public/js/zf-table.js',
                        'css/zf-table/zf-table.css' => __DIR__ . '/../src/ZfTable/Public/css/zf-table/zf-table.css',
                        'img/zf-table/ajax-loader.gif' => __DIR__ . '/../src/ZfTable/Public/img/zf-table/ajax-loader.gif',

                        /*DATA TABLE*/
                        'js/DT_bootstrap_2.js' => __DIR__ . '/../src/ZfTable/Public/js/DT_bootstrap_2.js',
                        'js/DT_bootstrap_3.js' => __DIR__ . '/../src/ZfTable/Public/js/DT_bootstrap_3.js',
                        'js/jquery.dataTables.min.js' => __DIR__ . '/../src/ZfTable/Public/js/jquery.dataTables.min.js',

                        'img/datatable/back_disabled.png' => __DIR__ . '/../src/ZfTable/Public/img/datatable/back_disabled.png',
                        'img/datatable/back_enabled.png' => __DIR__ . '/../src/ZfTable/Public/img/datatable/back_enabled.png',
                        'img/datatable/back_enabled_hover.png' => __DIR__ . '/../src/ZfTable/Public/img/datatable/back_enabled_hover.png',
                        'img/datatable/forward_disabled.png' => __DIR__ . '/../src/ZfTable/Public/img/datatable/forward_disabled.png',
                        'img/datatable/forward_enabled.png' => __DIR__ . '/../src/ZfTable/Public/img/datatable/forward_enabled.png',
                        'img/datatable/forward_enabled_hover.png' => __DIR__ . '/../src/ZfTable/Public/img/datatable/forward_enabled_hover.png',
                        'img/datatable/sort_asc_disabled.png' => __DIR__ . '/../src/ZfTable/Public/img/datatable/sort_asc_disabled.png',
                        'img/datatable/sort_both.png' => __DIR__ . '/../src/ZfTable/Public/img/datatable/sort_both.png',
                        'img/datatable/sort_desc.png' => __DIR__ . '/../src/ZfTable/Public/img/datatable/sort_desc.png',
                        'img/datatable/sort_desc_disabled.png' => __DIR__ . '/../src/ZfTable/Public/img/datatable/sort_desc_disabled.png',
                        'img/datatable/sort_asc.png' => __DIR__ . '/../src/ZfTable/Public/img/datatable/sort_asc.png',

                        /*BOOTSTRAP*/
                        'css/bootstrap-3.0.0/bootstrap.min.css' => __DIR__ . '/../src/ZfTable/Public/css/bootstrap-3.0.0/bootstrap.min.css',

                        'css/bootstrap-2.2.2/bootstrap.min.css' => __DIR__ . '/../src/ZfTable/Public/css/bootstrap-2.2.2/bootstrap.min.css',
                        'css/bootstrap-2.2.2/bootstrap-responsive.min.css' => __DIR__ . '/../src/ZfTable/Public/css/bootstrap-2.2.2/bootstrap-responsive.min.css',
                        'css/bootstrap-2.2.2/DT_bootstrap.css' => __DIR__ . '/../src/ZfTable/Public/css/bootstrap-2.2.2/DT_bootstrap.css',
                    ],
                ],
            ],
        ];
    }
}

