<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace ZfTable\Example\TableExample;

use ZfTable\AbstractTable;

class AdditionalParams extends AbstractTable
{

    protected $config = [
        'name' => 'Additional Params',
        'showPagination' => true,
        'showQuickSearch' => false,
        'showItemPerPage' => true,
        'itemCountPerPage' => 10,
        'showColumnFilters' => false,
        'showExportToCSV ' => false,
        'valuesOfItemPerPage' => [5, 10, 20, 50 , 100 , 200],
    ];

     //Definition of headers
    protected $headers = [
        'idcustomer' => ['title' => 'Id', 'width' => '50'],
        'name'       => ['title' => 'Name'],
        'surname'    => ['title' => 'Surname'],
        'street'     => ['title' => 'Street'],
        'city'       => ['title' => 'City'],
        'active'     => ['title' => 'Active' , 'width' => 100],
    ];

    public function init()
    {

    }

    protected function initFilters($query)
    {
        if ($value = $this->getParamAdapter()->getPureValueOfFilter('name')) {
            $query->where("name like '%".$value."%' ");
        }
        if ($value = $this->getParamAdapter()->getPureValueOfFilter('surname')) {
            $query->where("surname like '%".$value."%' ");
        }
    }
}
