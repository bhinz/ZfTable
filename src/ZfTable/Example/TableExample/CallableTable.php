<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace ZfTable\Example\TableExample;

use ZfTable\AbstractTable;

class CallableTable extends AbstractTable
{

    protected $config = [
        'name'            => 'Callable',
        'showPagination'  => true,
        'showQuickSearch' => false,
        'showItemPerPage' => true,
    ];

    /**
     * @var array Definition of headers
     */
    protected $headers = [
        'idcustomer'     => ['title' => 'Id', 'width' => '50'],
        'callableColumn' => ['title' => 'Closure' ,'sortable' => false],
        'name'           => ['title' => 'Name', 'separatable' => true],
        'surname'        => ['title' => 'Surname'],
        'street'         => ['title' => 'Street'],
        'city'           => ['title' => 'City', 'separatable' => true],
        'active'         => ['title' => 'Active', 'width' => 100],
    ];

    public function init()
    {
        $this->getHeader('callableColumn')->getCell()->addDecorator('callable', [
            'callable' => function ($context, $record) {
                return ' Imię : ' . $record['name'] . ', Nazwisko: '. $record['surname'];
            }
        ]);
    }
}
