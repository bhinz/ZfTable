<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace ZfTable\Example\TableExample;

use ZfTable\AbstractTable;

class Editable extends AbstractTable
{

    protected $config = [
        'name'              => 'Editable table (Db-click on pale yellow space)',
        'showQuickSearch'   => false,
        'itemCountPerPage'  => 10,
        'showColumnFilters' => true,
        'rowAction'         => '/table/updateRow',
    ];

    protected $headers = [
        'idcustomer' => ['title' => 'Id', 'width' => '50'],
        'name'       => ['title' => 'Name', 'filters' => 'text'],
        'edit1'      => ['title' => 'Edit 1',  'editable' => true],
        'edit2'      => ['title' => 'Edit 2'],
        'surname'    => ['title' => 'Surname', 'filters' => 'text'],
        'street'     => ['title' => 'Street', 'filters' => 'text'],
        'city'       => ['title' => 'City'],
        'active'     => ['title' => 'Active', 'width' => 100],
    ];

    public function init()
    {
        $this->getHeader('edit2')->getCell()->addDecorator('editable');
        $this->getRow()->addDecorator(
            'varattr',
            ['name' => 'data-row', 'value' => '%s', 'vars' => ['idcustomer']]
        );
    }

    protected function initFilters($query)
    {
        if ($value = $this->getParamAdapter()->getValueOfFilter('name')) {
            $query->where("name like '%" . $value . "%' ");
        }
        if ($value = $this->getParamAdapter()->getValueOfFilter('surname')) {
            $query->where("surname like '%" . $value . "%' ");
        }
        if ($value = $this->getParamAdapter()->getValueOfFilter('street')) {
            $query->where("street like '%" . $value . "%' ");
        }
    }
}
