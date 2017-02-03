<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */
namespace ZfTable\Decorator;

use RuntimeException;
use Zend\ServiceManager\Exception\InvalidServiceException;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Factory\InvokableFactory;

class DecoratorPluginManager extends AbstractPluginManager
{
    /**
     * Default set of aliases
     *
     * @var array
     */
    protected $aliases = [
        'cellattr'       => Cell\AttrDecorator::class,
        'cellvarattr'    => Cell\VarAttrDecorator::class,
        'cellclass'      => Cell\ClassDecorator::class,
        'cellicon'       => Cell\IconDecorator::class,
        'cellmapper'     => Cell\MapperDecorator::class,
        'celllink'       => Cell\LinkDecorator::class,
        'celltemplate'   => Cell\TemplateDecorator::class,
        'celleditable'   => Cell\EditableDecorator::class,
        'cellcallable'   => Cell\CallableDecorator::class,
        'rowclass'       => Row\ClassDecorator::class,
        'rowvarattr'     => Row\VarAttrDecorator::class,
        'rowseparatable' => Row\SeparatableDecorator::class,
        'headerclass'    => Header\ClassDecorator::class,
        'footerclass'    => Footer\ClassDecorator::class,
    ];

    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $factories = [
        Cell\AttrDecorator::class       => InvokableFactory::class,
        Cell\VarAttrDecorator::class    => InvokableFactory::class,
        Cell\ClassDecorator::class      => InvokableFactory::class,
        Cell\IconDecorator::class       => InvokableFactory::class,
        Cell\MapperDecorator::class     => InvokableFactory::class,
        Cell\LinkDecorator::class       => InvokableFactory::class,
        Cell\TemplateDecorator::class   => InvokableFactory::class,
        Cell\EditableDecorator::class   => InvokableFactory::class,
        Cell\CallableDecorator::class   => InvokableFactory::class,
        Row\ClassDecorator::class       => InvokableFactory::class,
        Row\VarAttrDecorator::class     => InvokableFactory::class,
        Row\SeparatableDecorator::class => InvokableFactory::class,
        Header\ClassDecorator::class    => InvokableFactory::class,
        Footer\ClassDecorator::class    => InvokableFactory::class,
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
        try {
            $this->validate($plugin);
        } catch (InvalidServiceException $ex) {
            throw new RuntimeException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }
    
    public function validate($plugin)
    {
        if ($plugin instanceof AbstractDecorator) {
            return;
        }
        throw new \DomainException('Invalid Decorator Implementation');
    }
}
