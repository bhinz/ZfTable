<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace ZfTable\Decorator;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Factory\InvokableFactory;

class DecoratorPluginManager extends AbstractPluginManager
{
    protected $aliases = [
        'cellattr'       => Cell\AttrDecorator::class,
        'cellvarattr'    => Cell\VarAttrDecorator::class,
        'cellclass'      => Cell\ClassDecorator::class,
        'cellicon'       => Cell\Icon::class,
        'cellmapper'     => Cell\Mapper::class,
        'celllink'       => Cell\Link::class,
        'celltemplate'   => Cell\Template::class,
        'celleditable'   => Cell\Editable::class,
        'cellcallable'   => Cell\CallableDecorator::class,
        'rowclass'       => Row\ClassDecorator::class,
        'rowvarattr'     => Row\VarAttr::class,
        'rowseparatable' => Row\Separatable::class,
    ];

    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $factories = [
        Cell\AttrDecorator::class      => InvokableFactory::class,
        Cell\VarAttrDecorator::class   => InvokableFactory::class,
        Cell\ClassDecorator::class     => InvokableFactory::class,
        Cell\Icon::class               => InvokableFactory::class,
        Cell\Mapper::class             => InvokableFactory::class,
        Cell\Link::class               => InvokableFactory::class,
        Cell\Template::class           => InvokableFactory::class,
        Cell\Editable::class           => InvokableFactory::class,
        Cell\CallableDecorator::class  => InvokableFactory::class,
        Row\ClassDecorator::class      => InvokableFactory::class,
        Row\VarAttr::class             => InvokableFactory::class,
        Row\Separatable::class         => InvokableFactory::class,
    ];

    /**
     * Don't share header by default
     *
     * @var bool
     */
    protected $shareByDefault = false;

    /**
     * @param mixed $plugin
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof AbstractDecorator) {
            return;
        }
        throw new \DomainException('Invalid Decorator Implementation');
    }
}
