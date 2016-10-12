<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */
namespace ZfTable\Decorator\Condition;

use Zend\ServiceManager\AbstractPluginManager;

class ConditionPluginManager extends AbstractPluginManager
{
    /**
     * Default set of aliases
     *
     * @var array
     */
    protected $aliases = [
        'equal'       => Plugin\Equal::class,
        'notequal'    => Plugin\NotEqual::class,
        'between'     => Plugin\Between::class,
        'greaterthan' => Plugin\GreaterThan::class,
        'lessthan'    => Plugin\LessThan::class,
    ];

    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $factories = [
        Plugin\Equal::class       => InvokableFactory::class,
        Plugin\NotEqual::class    => InvokableFactory::class,
        Plugin\Between::class     => InvokableFactory::class,
        Plugin\GreaterThan::class => InvokableFactory::class,
        Plugin\LessThan::class    => InvokableFactory::class,
    ];

    /**
     * Don't share plugin by default
     *
     * @var bool
     */
    protected $shareByDefault = false;

    /**
     * See AbstractPluginManager
     *
     * @throws \DomainException
     * @param mixed $plugin
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof AbstractCondition) {
            return;
        }
        throw new \DomainException('Invalid Condition Implementation');
    }
}
