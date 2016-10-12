<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */


namespace ZfTable\Example\TableExample;

use ZfTable\AbstractTable;

class Separatable extends AbstractTable
{

    protected $config = [
        'name' => 'Separatable decorator',
        'showPagination' => true,
        'showQuickSearch' => false,
        'showItemPerPage' => true,
    ];

    /**
     * @var array Definition of headers
     */
    protected $headers = [
        'idcustomer' => ['title' => 'Id', 'width' => '50'],
        'name'       => ['title' => 'Name' , 'separatable' => true],
        'surname'    => ['title' => 'Surname'],
        'street'     => ['title' => 'Street'],
        'city'       => ['title' => 'City' , 'separatable' => true],
        'active'     => ['title' => 'Active' , 'width' => 100],
    ];

    public function init()
    {
        $this->getRow()->addDecorator('separatable', ['defaultColumn' => 'city']);
    }

    protected function initFilters($query)
    {

    }
}
