<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */
namespace ZfTable\Example\TableExample;

use ZfTable\AbstractTable;

class NewPluginCondition extends AbstractTable
{
    protected $config = [
        'name'            => 'New condition plugin (Between, GreaterThan, LessThan )',
        'showPagination'  => true,
        'showQuickSearch' => false,
        'showItemPerPage' => true,
    ];

    /**
     * @var array Definition of headers
     */
    protected $headers = [
        'idcustomer' => ['title' => 'Id', 'width' => '50'],
        'name'       => ['title' => 'Name'],
        'surname'    => ['title' => 'Surname'],
        'street'     => ['title' => 'Street'],
        'city'       => ['title' => 'City'],
        'age'        => ['title' => 'Age'],
        'active'     => ['title' => 'Active' , 'width' => 100],
    ];

    public function init()
    {
        $this->getHeader('age')->getCell()->addDecorator('varattr', ['style' => 'color: blue'])
                ->addCondition('between', ['column' => 'age' , 'min' => 10, 'max' => 30]);

        $this->getHeader('age')->getCell()->addDecorator('varattr', ['style' => 'rgb(255, 0, 245)'])
                ->addCondition('lessthan', ['column' => 'age' , 'value' => 10]);

        $this->getHeader('age')->getCell()->addDecorator('varattr', ['style' => 'color: red'])
                ->addCondition('greaterthan', ['column' => 'age' , 'value' => 30]);
    }

    protected function initFilters($query)
    {

    }
}
