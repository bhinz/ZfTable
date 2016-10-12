<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */
namespace ZfTable;

use ZfTable\AbstractElement;

class Cell extends AbstractElement
{
    /**
     * Header object
     * @var Header
     */
    protected $header;

    /**
     * Footer object
     * @var Footer
     */
    protected $footer;

    /**
     *
     * @param Header|Footer $object
     */
    public function __construct($object)
    {
        if (Header::class == get_class($object)) {
            $this->header = $object;
        } elseif (Footer::class == get_class($object)) {
            $this->footer = $object;
        }
    }

    /**
     *
     * @param string $name type
     * @param array  $options type
     * @return Decorator\AbstractDecorator
     */
    public function addDecorator($name, $options = [])
    {
        $decorator = $this->getDecoratorFactory()->factoryCell($name, $options);
        $decorator->setCell($this);
        $this->attachDecorator($decorator);
// \Zend\Debug\Debug::dump(get_class($this), 'Cell');
// \Zend\Debug\Debug::dump(get_class($this->attachDecorator($decorator)), 'Cell');
// \Zend\Debug\Debug::dump(get_class($decorator), 'Cell');
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
     * Get header object
     * @return Header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set header object
     *
     * @param Header $header
     * @return $this
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     * Get footer object
     * @return Footer
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * Set footer object
     *
     * @param Footer $footer
     * @return $this
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * Get actual row
     *
     * @return array
     */
    public function getActualRow()
    {
        return $this->getTable()->getRow()->getActualRow();
    }

    /**
     * Rendering single cell
     *
     * @return string
     */
    public function render($type = 'html')
    {
        $row = $this->getTable()->getRow()->getActualRow();
        $value = '';

        if (is_array($row) || $row instanceof \ArrayAccess) {
            $value = (isset($row[$this->getHeader()->getName()])) ? $row[$this->getHeader()->getName()] : '';
        } elseif (is_object($row)) {
            $headerName = $this->getHeader()->getName();
            $methodName = 'get' . ucfirst($headerName);
            if (method_exists($row, $methodName)) {
                $value = $row->$methodName();
            } else {
                $value = (property_exists($row, $headerName)) ? $row->$headerName : '';
            }
        }

        foreach ($this->decorators as $decorator) {
            if ($decorator->validConditions()) {
                $value = $decorator->render($value);
            }
        }
        if ($type == 'html') {
            $ret = sprintf("<td %s>%s</td>", $this->getAttributes(), $value);
            $this->clearVar();
            return $ret;

        } else {
            return $value;
        }
    }
}
