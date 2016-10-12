<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace ZfTable\Example\TableExample;

use ZfTable\AbstractTable;

class ArrayAdapter extends AbstractTable
{

    protected $config = [
        'name' => 'Array Adapter',
        'showPagination' => true,
        'showQuickSearch' => false,
        'showItemPerPage' => true,
        'showColumnFilters' => true,
    [;

    /**
     * @var array Definition of headers
     */
    protected $headers = [
        'idcustomer' => ['title' => 'Id', 'width' => '50'],
        'name'       => ['title' => 'Name' , 'separatable' => true , 'filters' => 'text'],
        'surname'    => ['title' => 'Surname' , 'filters' => 'text'],
        'street'     => ['title' => 'Street' , 'filters' => 'text'],
        'city'       => ['title' => 'City' , 'separatable' => true , 'filters' => 'text'],
        'active'     => ['title' => 'Active' , 'width' => 100],
    ];

    public function init()
    {

    }

    protected function initFilters($arrayData)
    {
        $keys = [];

        foreach ($arrayData as $key => $row) {
            if ($value = $this->getParamAdapter()->getValueOfFilter('name')) {
                if (strpos($row['name'], $value) === false && !isset($keys[$key])) {
                    $keys[] = $key;
                }
            }
            if ($value = $this->getParamAdapter()->getValueOfFilter('surname')) {
                if (strpos($row['surname'], $value) === false && !isset($keys[$key])) {
                    $keys[] = $key;
                }
            }
            if ($value = $this->getParamAdapter()->getValueOfFilter('street')) {
                if (strpos($row['street'], $value) === false && !isset($keys[$key])) {
                    $keys[] = $key;
                }
            }
            if ($value = $this->getParamAdapter()->getValueOfFilter('city')) {
                if (strpos($row['city'], $value) === false && !isset($keys[$key])) {
                    $keys[] = $key;
                }
            }
        }

        foreach ($keys as $key) {
            unset($arrayData[$key]);
        }
    }
}
