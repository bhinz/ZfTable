<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */
namespace ZfTable;

use Zend\View\Resolver;
use Zend\View\Renderer\PhpRenderer;
use ZfTable\Options\ModuleOptions;

class Render extends AbstractCommon
{
    /**
     * PhpRenderer object
     * @var PhpRenderer
     */
    protected $renderer;

    /**
     *
     * @var ModuleOptions
     */
    protected $options;

    /**
     *
     * @param AbstractTable $table
     */
    public function __construct($table)
    {
        $this->setTable($table);
    }

    /**
     * Rendering paginator
     *
     * @return string
     */
    public function renderPaginator()
    {
        $paginator = $this->getTable()->getSource()->getPaginator();
        $paginator->setView($this->getRenderer());
        $res = $this->getRenderer()->paginationControl($paginator, 'Sliding', 'paginator-slide');
        return $res;
    }

     /**
     * Rendering json for dataTable
      *
     * @return string
     */
    public function renderDataTableJson()
    {
        $res = [];
        $render = $this->getTable()->getRow()->renderRows('array');
        $res['sEcho'] = $render;
        $res['iTotalDisplayRecords'] = $this->getTable()->getSource()->getPaginator()->getTotalItemCount();
        $res['aaData'] = $render;

        return json_encode($res);
    }

    public function renderNewDataTableJson()
    {

        $render = $this->getTable()->getRow()->renderRows('array');

        $res = [
            'draw' => $render,
            'recordsFiltered' => $this->getTable()->getSource()->getPaginator()->getTotalItemCount(),
            'data' => $render,
        ];

        return json_encode($res);
    }

    /**
     * Rendering init view for dataTable
     *
     * @return string
     */
    public function renderDataTableAjaxInit()
    {
        $tableConfig = $this->getTable()->getOptions();
                
        $renderedHeads = $this->renderHead();

        $view = new \Zend\View\Model\ViewModel();
        $view->setTemplate('data-table-init');
        if ($tableConfig->getShowColumnFilters()) {
            $renderedFilters = $this->renderFilters();
            $view->setVariable('filters', $renderedFilters);
        }
        $view->setVariable('headers', $renderedHeads);
        $view->setVariable('attributes', $this->getTable()->getAttributes());

        return $this->getRenderer()->render($view);

    }

    public function renderCustom($template)
    {

        $tableConfig = $this->getTable()->getOptions();
        $rowsArray = $this->getTable()->getRow()->renderRows('array_assc');

        $view = new \Zend\View\Model\ViewModel();
        $view->setTemplate($template);

        $view->setVariable('rows', $rowsArray);

        $view->setVariable('paginator',              $this->renderPaginator());
        $view->setVariable('paramsWrap',             $this->renderParamsWrap());
        $view->setVariable('itemCountPerPage',       $this->getTable()->getParamAdapter()->getItemCountPerPage());
        $view->setVariable('quickSearch',            $this->getTable()->getParamAdapter()->getQuickSearch());
        $view->setVariable('name',                   $tableConfig->getName());
        $view->setVariable('itemCountPerPageValues', $tableConfig->getValuesOfItemPerPage());
        $view->setVariable('showQuickSearch',        $tableConfig->getShowQuickSearch());
        $view->setVariable('showPagination',         $tableConfig->getShowPagination());
        $view->setVariable('showItemPerPage',        $tableConfig->getShowItemPerPage());
        $view->setVariable('showExportToCSV',        $tableConfig->getShowExportToCSV());

        return $this->getRenderer()->render($view);
    }

    /**
     * Rendering table
     *
     * @return string
     */
    public function renderTableAsHtml()
    {
        $tableConfig = $this->getTable()->getOptions();

        $renderHead = '';
        if ($tableConfig->getShowColumnFilters()) {
            $renderHead .= $this->renderFilters();
        }
        $renderHead .= $this->renderHead();
        $renderHead  = sprintf('<thead>%s</thead>', $renderHead);

        $renderBody  = '';
        $renderBody .= $this->getTable()->getRow()->renderRows();

        $renderFoot  = '';
        $renderFoot .= $this->renderFoot();
        $renderFoot  = sprintf('<tfoot>%s</tfoot>', $renderFoot);

        $table = sprintf('<table %s>%s%s%s</table>', $this->getTable()->getAttributes(), $renderHead, $renderBody, $renderFoot);

        $view = new \Zend\View\Model\ViewModel();
        $view->setTemplate('container');

        $view->setVariable('table', $table);

        $view->setVariable('paginator',              $this->renderPaginator());
        $view->setVariable('paramsWrap',             $this->renderParamsWrap());
        $view->setVariable('itemCountPerPage',       $this->getTable()->getParamAdapter()->getItemCountPerPage());
        $view->setVariable('quickSearch',            $this->getTable()->getParamAdapter()->getQuickSearch());
        $view->setVariable('name',                   $tableConfig->getName());
        $view->setVariable('itemCountPerPageValues', $tableConfig->getValuesOfItemPerPage());
        $view->setVariable('showQuickSearch',        $tableConfig->getShowQuickSearch());
        $view->setVariable('showPagination',         $tableConfig->getShowPagination());
        $view->setVariable('showItemPerPage',        $tableConfig->getShowItemPerPage());
        $view->setVariable('showExportToCSV',        $tableConfig->getShowExportToCSV());

        return $this->getRenderer()->render($view);
    }

    /**
     * Rendering filters
     *
     * @return string
     */
    public function renderFilters()
    {
        $headers = $this->getTable()->getHeaders();
        $render = '';

        foreach ($headers as $name => $params) {
            if (isset($params['filters'])) {
                $value = $this->getTable()->getParamAdapter()->getValueOfFilter($name);
                $id = 'zft_' . $name;

                if (is_string($params['filters'])) {
                    $element = new \Zend\Form\Element\Text($id);
                } else {
                    $element = new \Zend\Form\Element\Select($id);
                    $element->setValueOptions($params['filters']);
                }
                $element->setAttribute('class', 'filter form-control');
                $element->setValue($value);

                $render .= sprintf('<td>%s</td>', $this->getRenderer()->formRow($element));
            } else {
                $render .= '<td></td>';
            }
        }
        return sprintf('<tr>%s</tr>', $render);
    }

    /**
     * Rendering head
     *
     * @return string
     */
    public function renderHead()
    {
        $headers = $this->getTable()->getHeaders();
        $render = '';
        foreach ($headers as $name => $title) {
            $render .= $this->getTable()->getHeader($name)->render();
        }
        $render = sprintf('<tr class="zf-title">%s</tr>', $render);
        return $render;
    }

    /**
     * Rendering foot
     *
     * @return string
     */
    public function renderFoot()
    {
        $footers = $this->getTable()->getFooters();
        $render = '';

        foreach ($footers as $name => $title) {
            $render .= $this->getTable()->getFooter($name)->render();
        }
        $render = sprintf('<tr class="zf-foot">%s</tr>', $render);
        return $render;
    }

    /**
     * Rendering params wrap to ajax communication
     *
     * @return string
     */
    public function renderParamsWrap()
    {
        $view = new \Zend\View\Model\ViewModel();

        $view->setTemplate('default-params');
        $view->setVariable('column',           $this->getTable()->getParamAdapter()->getColumn());
        $view->setVariable('itemCountPerPage', $this->getTable()->getParamAdapter()->getItemCountPerPage());
        $view->setVariable('order',            $this->getTable()->getParamAdapter()->getOrder());
        $view->setVariable('page',             $this->getTable()->getParamAdapter()->getPage());
        $view->setVariable('quickSearch',      $this->getTable()->getParamAdapter()->getQuickSearch());
        $view->setVariable('rowAction',        $this->getTable()->getOptions()->getRowAction());

        return $this->getRenderer()->render($view);
    }

    /**
     * Init renderer object
     */
    protected function initRenderer()
    {
        $renderer = new PhpRenderer();

        $plugins = $renderer->getHelperPluginManager();
        $config  = new \Zend\Form\View\HelperConfig;
        $config->configureServiceManager($plugins);

        $resolver = new Resolver\AggregateResolver();
        $map = new Resolver\TemplateMapResolver($this->getTable()->getOptions()->getTemplateMap());
        $resolver->attach($map);

        $renderer->setResolver($resolver);
        $this->renderer = $renderer;
    }

    /**
     * Get PHPRenderer
     * @return PhpRenderer
     */
    public function getRenderer()
    {
        if (!$this->renderer) {
            $this->initRenderer();
        }
        return $this->renderer;
    }

    /**
     * Set PhpRenderer
     * @param \Zend\View\Renderer\PhpRenderer $renderer
     */
    public function setRenderer(PhpRenderer $renderer)
    {
        $this->renderer = $renderer;
    }
}
