<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */


namespace Application\Table;

use ZfTable\AbstractTable;

class ImportListTable extends AbstractTable
{

    protected $config = [
        'name'             => 'Lista importów',
        'showPagination'   => true,
        'showQuickSearch'  => true,
        'showItemPerPage'  => true,
        'itemCountPerPage' => 20,
        'areFilters'       => true,
        'rowAction'        => 'updateRow'
    ];

    /**
     * @var array Definition of headers
     */
    protected $headers = [
        'category_title' => ['title' => 'Marka', 'filters' => 'text', 'sortable' => true, 'separatable' => true],
        'created_at'     => ['title' => 'Data importu', 'filters' => 'text', 'editable' => true],
        'goto-not-voted' => ['title'  => 'Nie ocenione', 'sortable' => false],
        'goto-all'       => ['title'  => 'Wszystkie', 'sortable' => false],
        'report'         => ['title' => 'Report', 'sortable' => false]
    ];

    protected function init()
    {
        $this->getRow()->addDecorator('separator', ['defaultColumn' => 'category_title']);
        $this->getRow()->addDecorator('varattr', ['name' => 'data-row', 'value' => '%s', 'vars' => ['id']]);

        $this->getHeader('category_title')->getCell()->addDecorator('editable', []);

        $this->getHeader('goto-all')->getCell()->addDecorator('template', [
            'template' => '<a href="/application/index/index/%s/1" target="_blank">Click (%s)</a>',
            'vars' => ['id', 'count-all']
        ]);

        $this->getHeader('goto-not-voted')->getCell()->addDecorator('template', [
            'template' => '<a href="/application/index/index/%s/2" target="_blank">Click (%s)</a>',
            'vars' => ['id', 'count-not-voted']
        ]);

        $this->getHeader('report')->getCell()->addDecorator('template', [
            'template' => '<a href="/application/index/report/%s" target="_blank">Generate </a>',
            'vars' => ['id']
        ]);
    }

    protected function initFilters($query)
    {
        if ($value = $this->getParamAdapter()->getValueOfFilter('zff_category_title')) {
            $query->where("c.title like '%" . $value . "%' ");
        }

        if ($value = $this->getParamAdapter()->getValueOfFilter('zff_created_at')) {
            $query->where("i.created_at like '%" . $value . "%' ");
        }
    }
}
