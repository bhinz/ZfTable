<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */
namespace ZfTable;

use ZfTable\AbstractElement;
use ZfTable\Cell;

class Footer extends AbstractElement
{
    /**
     * colspan of the column
     *
     * @var int
     */
    protected $colspan;

    /**
     * Content of footer
     *
     * @var string
     */
    protected $content;

    /**
     * Cell object
     * @var Cell
     */
    protected $cell;

    /**
     * Table of options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Array of options
     *
     * @param string $name
     * @param array $options
     */
    public function __construct($name, $options = [])
    {
        $this->name = $name;
        $this->cell = new Cell($this);
        $this->setOptions($options);
    }

    /**
     * Set options like content, colspan
     *
     * @param string $name
     * @param array $options
     * @return Decorator\Footer\AbstractFooterDecorator
     */
    public function addDecorator($name, $options = [])
    {
        $decorator = $this->getDecoratorFactory()->factoryFooter($name, $options);
        $this->attachDecorator($decorator);
        $decorator->setFooter($this);
// \Zend\Debug\Debug::dump(get_class($this), 'Footer');
// \Zend\Debug\Debug::dump(get_class($this->attachDecorator($decorator)), 'Footer');
// \Zend\Debug\Debug::dump(get_class($decorator), 'Footer');
        return $decorator;
    }

    /**
     * @return Decorator\DecoratorFactory
     */
    protected function getDecoratorFactory()
    {
        return $this->table->getDecoratorFactory();
    }

    /**
     * Get list of options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set options like content, colspan
     *
     * @param array $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->content = (isset($options['content'])) ? $options['content'] : '';

        if (isset($options['colspan'])) {
            $this->addAttr('colspan', $options['colspan']);
        }
        return $this;
    }

    /**
     * Return cell object
     *
     * @return Cell
     */
    public function getCell()
    {
        return $this->cell;
    }

    /**
     * Set cell object
     *
     * @param Cell $cell
     */
    public function setCell($cell)
    {
        $this->cell = $cell;
    }

    /**
     * Set name of header
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name of header
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set footer content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get footer content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get colspan of column
     *
     * @return int
     */
    public function getColspan()
    {
        return $this->colspan;
    }

    /**
     * Set colspan of column
     *
     * @param int $colspan
     */
    public function setColspan($colspan)
    {
        $this->colspan = $colspan;
    }

    /**
     * Set reference to table
     *
     * @param $table
     * @return void|\ZfTable\AbstractCommon
     */
    public function setTable($table)
    {
        $this->table = $table;
        $this->getCell()->setTable($table);
    }

    /**
     * Init footer
     */
    protected function initRendering()
    {
    }

    /**
     * Rendering footer element
     *
     * @return string
     */
    public function render()
    {
        $this->initRendering();
        $render = $this->getContent();

        foreach ($this->decorators as $decorator) {
            $render = $decorator->render($render);
        }
        return sprintf('<td %s>%s</td>', $this->getAttributes(), $render);
    }
}
