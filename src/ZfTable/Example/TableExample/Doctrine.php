<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace ZfTable\Example\TableExample;

use ZfTable\AbstractTable;

class Doctrine extends AbstractTable
{

    protected $config = [
        'name' => 'Doctrine 2',
        'showPagination' => true,
        'showQuickSearch' => false,
        'showItemPerPage' => true,
        'showColumnFilters' => true,
    ];

    /**
     * @var array Definition of headers
     */
    protected $headers = [
        'idcustomer' =>     ['tableAlias' => 'q', 'title' => 'Id', 'width' => '50'],
        'doctrine' =>       [
            'tableAlias' => 'q',
            'title'      => 'Doctrine closure' ,
            'filters'    => 'text',
            'sortable'   => false
        ],
        'product' =>        ['tableAlias' => 'p', 'title' => 'Product', 'filters' => 'text'],
        'name' =>           ['tableAlias' => 'q', 'title' => 'Name', 'filters' => 'text'],
        'surname' =>        ['tableAlias' => 'q', 'title' => 'Surname', 'filters' => 'text'],
        'street' =>         ['tableAlias' => 'q', 'title' => 'Street', 'filters' => 'text'],
        'city' =>           ['tableAlias' => 'q', 'title' => 'City', 'filters' => 'text'],
        'active' =>         ['tableAlias' => 'q', 'title' => 'Active', 'width' => 100],
    ];

    public function init()
    {
        $this->getHeader('doctrine')->getCell()->addDecorator('callable', [
            'callable' => function ($context, $record) {
                return $record->name . ' ' . $record->surname;
            }
        ]);

        $this->getHeader('product')->getCell()->addDecorator('callable', [
            'callable' => function ($context, $record) {
                if (is_object($record->product)) {
                    return $record->product->product;
                } else {
                    return '';
                }
            }
        ]);
    }

    //The filters could also be done with a parametrised query
    protected function initFilters($query)
    {
        if ($value = $this->getParamAdapter()->getValueOfFilter('name')) {
            $query->where($query->expr()->like('q.name', '?1'))->setParameter('1', '%' . $value . '%');
        }

        if ($value = $this->getParamAdapter()->getValueOfFilter('surname')) {
            $query->where($query->expr()->like('q.surname', '?1'))->setParameter('1', '%' . $value . '%');
        }

        if ($value = $this->getParamAdapter()->getValueOfFilter('doctrine')) {
            $query->where("q.name like '%".$value."%' OR q.surname like '%".$value."%' ");
            $expr = $query->expr();
            $query->where($expr->orX($expr->like('q.name', '?1'), $expr->like('q.surname', '?2')))
                ->setParameter('1', '%' . $value . '%')
                ->setParameter('2', '%' . $value . '%');
        }

        if ($value = $this->getParamAdapter()->getValueOfFilter('street')) {
            $query->where($query->expr()->like('q.street', '?1'))->setParameter('1', '%' . $value . '%');
        }

        if ($value = $this->getParamAdapter()->getValueOfFilter('city')) {
            $query->where($query->expr()->like('q.city', '?1'))->setParameter('1', '%' . $value . '%');
        }

        if ($value = $this->getParamAdapter()->getValueOfFilter('product')) {
            $query->where($query->expr()->like('q.product', '?1'))->setParameter('1', '%' . $value . '%');
        }
    }
}
