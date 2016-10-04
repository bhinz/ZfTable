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
        'cellattr'       => Decorator\Cell\AttrDecorator::class,
        'cellvarattr'    => Decorator\Cell\VarAttrDecorator::class,
        'cellclass'      => Decorator\Cell\ClassDecorator::class,
        'cellicon'       => Decorator\Cell\Icon::class,
        'cellmapper'     => Decorator\Cell\Mapper::class,
        'celllink'       => Decorator\Cell\Link::class,
        'celltemplate'   => Decorator\Cell\Template::class,
        'celleditable'   => Decorator\Cell\Editable::class,
        'cellcallable'   => Decorator\Cell\CallableDecorator::class,
        'rowclass'       => Decorator\Row\ClassDecorator::class,
        'rowvarattr'     => Decorator\Row\VarAttr::class,
        'rowseparatable' => Decorator\Row\Separatable::class,
    ];

    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $factories = [
        Decorator\Cell\AttrDecorator::class      => InvokableFactory::class,
        Decorator\Cell\VarAttrDecorator::class   => InvokableFactory::class,
        Decorator\Cell\ClassDecorator::class     => InvokableFactory::class,
        Decorator\Cell\Icon::class               => InvokableFactory::class,
        Decorator\Cell\Mapper::class             => InvokableFactory::class,
        Decorator\Cell\Link::class               => InvokableFactory::class,
        Decorator\Cell\Template::class           => InvokableFactory::class,
        Decorator\Cell\Editable::class           => InvokableFactory::class,
        Decorator\Cell\CallableDecorator::class  => InvokableFactory::class,
        Decorator\Row\ClassDecorator::class      => InvokableFactory::class,
        Decorator\Row\VarAttr::class             => InvokableFactory::class,
        Decorator\Row\Separatable::class         => InvokableFactory::class,
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
