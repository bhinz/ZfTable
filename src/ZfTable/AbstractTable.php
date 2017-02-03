<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */
namespace ZfTable;

use ZfTable\Table\TableInterface;
use ZfTable\Params\AdapterInterface as ParamAdapterInterface;
use ZfTable\Params\AdapterArrayObject;
use ZfTable\Table\Exception;
use ZfTable\Options\ModuleOptions;

use ZfTable\Form\TableForm;
use ZfTable\Form\TableFilter;
use Zend\ServiceManager\ServiceManager;

abstract class AbstractTable extends AbstractElement implements TableInterface
{
    /**
     * Collection of headers objects
     * @var array
     */
    protected $headersObjects;

    /**
     * List of headers with title and width option
     * @var array
     */
    protected $headers;

    /**
     * Collection of footers objects
     * @var array
     */
    protected $footersObjects;

    /**
     * List of footers
     * @var array
     */
    protected $footers;

    /**
     * Database adapter
     * @var \Zend\Db\Adapter\Adapter
     */
    protected $adapter;

    /**
     *
     * @var Source\SourceInterface
     */
    protected $source;

    /**
     *
     * @var Row
     */
    protected $row;

    /**
     * Data after execute of query
     * @var array | \Zend\Paginator\Paginator
     */
    protected $data;

    /**
     * Render object responsible for rendering
     * @var Render
     */
    protected $render;

    /**
     * Params adapter which responsible for universal mapping parameters from diffrent
     * source (default params, Data Table params, JGrid params)
     * @var ParamAdapterInterface
     */
    protected $paramAdapter;

    /**
     * Flag to know if table has been initializable
     * @var boolean
     */
    private $tableInit = false;

    /**
     * Default classes for table
     * @var array
     */
    protected $class = ['table', 'table-bordered', 'table-condensed', 'table-hover', 'table-striped', 'dataTable'];

    /**
     * Options base ond ModuleOptions and config array
     * @var Options\ModuleOptions
     */
    protected $config;

    /**
     * @var TableForm
     */
    protected $form;

    /**
     *
     * @var TableFilter
     */
    protected $filter;

    /**
     * @var Decorator\DecoratorFactory
     */
    protected $decoratorFactory;

    /**
     * Check if table has been initializable
     * @return boolean
     */
    public function isTableInit()
    {
        return $this->tableInit;
    }

    /**
     * Set module options
     *
     * @param  array|\Traversable|ModuleOptions $options
     * @return AbstractTable
     */
    public function setOptions($options)
    {
        $this->config = array_merge((array)$options, (array)$this->config);
        return $this;
    }

    /**
     * Return Params adapter
     *
     * which responsible for universal mapping parameters from different
     * source (default params, Data Table params, JGrid params)
     *
     * @return ParamAdapterInterface
     */
    public function getParamAdapter()
    {
        return $this->paramAdapter;
    }

    /**
     *
     * @param $params
     * @throws Exception\InvalidArgumentException
     */
    public function setParamAdapter($params)
    {
        if ($params instanceof Params\AdapterInterface) {
            $this->paramAdapter = $params;
        } elseif ($params instanceof \Zend\Stdlib\Parameters) {
            $this->paramAdapter = new AdapterArrayObject($params);
        } else {
            throw new Exception\InvalidArgumentException(
                'Parameter must be instance of AdapterInterface or \Zend\Stdlib\Parameters'
            );
        }
        $this->paramAdapter->setTable($this);
        $this->paramAdapter->init();
    }

    /**
     *
     * @return array | \Zend\Paginator\Paginator
     * @throws Exception\LogicException
     */
    public function getData()
    {
        if (!$this->data) {
            $source = $this->getSource();
            if (!$source) {
                throw new Exception\LogicException('Source data is required');
            }
            return $source->getData();
        }
        return [];
    }

    /**
     *
     * @return Source\SourceInterface
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     *
     * @param \Zend\Db\Sql\Select |  $source
     * @return AbstractTable
     * @throws Exception\LogicException
     */
    public function setSource($source)
    {

        if ($source instanceof \Zend\Db\Sql\Select) {
            $source = new Source\SqlSelect($source);
        } elseif ($source instanceof \Doctrine\ORM\QueryBuilder) {
            $source = new Source\DoctrineQueryBuilder($source);
        } elseif ($source instanceof \Doctrine\ODM\MongoDB\Query\Builder) {
            $source = new Source\DoctrineODMMongoDBQueryBuilder($source);
        } elseif ($source instanceof \Doctrine\MongoDB\Query\Builder) {
            $source = new Source\DoctrineMongoDBQueryBuilder($source);
        } elseif (is_array($source)) {
            $source = new Source\ArrayAdapter($source);
        } else {
            throw new Exception\LogicException('This type of source is undefined');
        }

        $source->setTable($this);
        $this->source = $source;
        return $this;
    }

    /**
     * Get database adapter
     *
     * @return \Zend\Db\Adapter\Adapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Set database adapter
     *
     * @param \Zend\Db\Adapter\Adapter $adapter
     * @return $this
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * Get decorator factory
     *
     * @return Decorator\DecoratorFactory
     */
    public function getDecoratorFactory()
    {
        if (!$this->decoratorFactory) {
            $this->decoratorFactory = new Decorator\DecoratorFactory(new ServiceManager());
        }
        return $this->decoratorFactory;
    }

    /**
     * Set decorator factory
     *
     * @param Decorator\DecoratorFactory $decoratorFactory
     * @return $this
     */
    public function setDecoratorFactory(Decorator\DecoratorFactory $decoratorFactory)
    {
        $this->decoratorFactory = $decoratorFactory;
        return $this;
    }

    /**
     * Rendering table
     *
     * @param string $type (html | dataTableAjaxInit | dataTableJson)
     * @param null $template
     * @throws Exception\InvalidArgumentException
     * @return string
     */
    public function render($type = 'html', $template = null)
    {
        if (!$this->isTableInit()) {
            $this->initializable();
        }

        if ($type == 'html') {
            return $this->getRender()->renderTableAsHtml();
        } elseif ($type == 'dataTableAjaxInit') {
            return $this->getRender()->renderDataTableAjaxInit();
        } elseif ($type == 'dataTableJson') {
            return $this->getRender()->renderDataTableJson();
        } elseif ($type == 'custom') {
            return $this->getRender()->renderCustom($template);
        } elseif ($type == 'newDataTableJson') {
            return $this->getRender()->renderNewDataTableJson();
        } else {
            throw new Exception\InvalidArgumentException(sprintf('Invalid type %s', $type));
        }

    }

    /**
     * Init configuration like setting header, decorators, filters and others
     *
     * (call in render method as well)
     */
    protected function initializable()
    {
        if (!$this->getParamAdapter()) {
            throw new Exception\LogicException('Param Adapter is required');
        }

        if (!$this->getSource()) {
            throw new Exception\LogicException('Source data is required');
        }

        $this->init = true;

        if (count($this->headers)) {
            $this->setHeaders($this->headers);
        }

        if (count($this->footers)) {
            $this->setFooters($this->footers);
        }

        $this->init();

        $this->initFilters($this->getSource()->getSource());
    }


    /**
     * @deprecated since version 2.0
     *
     * Function replace by initFilters
     */
    protected function initQuickSearch()
    {

    }

    /**
     * Init filters for quick search or filters for each column
     * @param \Zend\Db\Sql\Select $query
     */
    protected function initFilters($query)
    {

    }

    /**
     *
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        foreach ($headers as $name => $options) {
            $this->addHeader($name, $options);
        }
        return $this;
    }

    /**
     * Return array of headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     *
     * @param string $name type
     * @return Header | boolean
     * @throws Exception\LogicException
     */
    public function getHeader($name)
    {
        if (!count($this->headersObjects)) {
            throw new Exception\LogicException('Table hasn\'t got defined headers');
        }

        if (!isset($this->headersObjects[$name])) {
            throw new \RuntimeException('Header name doesn\'t exist');
        }
        return $this->headersObjects[$name];
    }

    /**
     * Add new header
     *
     * @param string $name
     * @param array $options
     */
    public function addHeader($name, $options)
    {
        $header = new Header($name, $options);
        $header->setTable($this);
        $this->headersObjects[$name] = $header;
    }

    /**
     *
     * @param array $footers
     * @return $this
     */
    public function setFooters(array $footers)
    {
        $this->footers = $footers;
        foreach ($footers as $name => $options) {
            $this->addFooter($name, $options);
        }
        return $this;
    }

    /**
     * Return array of footers
     *
     * @return array
     */
    public function getFooters()
    {
        return $this->footers;
    }

    /**
     *
     * @param string $name type
     * @return Footer | boolean
     * @throws Exception\LogicException
     */
    public function getFooter($name)
    {
        if (!count($this->footersObjects)) {
            throw new Exception\LogicException('Table hasn\'t got defined footers');
        }
        if (!isset($this->footersObjects[$name])) {
            throw new \RuntimeException('Footer name doesn\'t exist');
        }
        return $this->footersObjects[$name];
    }

    /**
     * Add new footer
     *
     * @param string $name
     * @param array $options
     */
    public function addFooter($name, $options)
    {
        $footer = new Footer($name, $options);
        $footer->setTable($this);
        $this->footersObjects[$name] = $footer;
    }

    /**
     * Get Row object
     *
     * @return Row
     */
    public function getRow()
    {
        if (!$this->row) {
            $this->row = new Row($this);
        }
        return $this->row;
    }

    /**
     * Set row object
     *
     * @param $row Row
     * @return $this
     */
    public function setRow($row)
    {
        $this->row = $row;
        return $this;
    }

    /**
     * Get Render object
     *
     * @return Render
     */
    public function getRender()
    {
        if (!$this->render) {
            $this->render = new Render($this);
        }
        return $this->render;
    }

    /**
     * Get render object
     * @param \ZfTable\Render $render
     */
    public function setRender(Render $render)
    {
        $this->render = $render;
    }

    /**
     * Rendering table
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     *
     * @return ModuleOptions
     * @throws \Exception
     */
    public function getOptions()
    {
        if (is_array($this->config)) {
            $this->config = new ModuleOptions($this->config);
        } elseif (!$this->config instanceof ModuleOptions) {
            throw new \Exception('Config class problem');
        }
        return $this->config;
    }

    /**
     *
     * @return TableForm
     */
    public function getForm()
    {
        if (!$this->form) {
            $this->form = new TableForm(array_keys($this->headers));
        }
        return $this->form;
    }

    /**
     *
     * @return TableFilter
     */
    public function getFilter()
    {
        if (!$this->filter) {
            $this->filter = new TableFilter(array_keys($this->headers));
        }
        return $this->filter;
    }
}
