<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace ZfTable\Example\TableExample;

use ZfTable\AbstractTable;

class InstitutionRequests extends AbstractTable
{

    protected $config = [
        'name' => 'Institution Requests',
        'showPagination' => true,
        'showQuickSearch' => false,
        'showItemPerPage' => true,
        'itemCountPerPage' => 10,
        'showColumnFilters' => true,
    ];


    /**
     * @var array Definition of headers
     */
    protected $headers = [
        'address' => ['title' => 'Address', 'filters' => 'text'],// from institution table
        'name' => ['title' => 'Name'] ,// from user table
    ];

    public function init()
    {

    }

    protected function initFilters($query)
    {
        if ($value = $this->getParamAdapter()->getValueOfFilter('address')) {
            $query->where("address like '%".$value."%' ");
        }
    }
}
