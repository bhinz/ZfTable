<?php

namespace ZfTable;

use ZfTable\Example\Model\CustomerTable;

class Module
{
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'ZfTable\Example\Model\CustomerTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new CustomerTable($dbAdapter);
                    return $table;
                },
            ],
            'aliases' => [
                'zfdb_adapter' => 'Zend\Db\Adapter\Adapter',
            ],
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
