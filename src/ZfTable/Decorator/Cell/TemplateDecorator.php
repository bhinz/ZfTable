<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */
namespace ZfTable\Decorator\Cell;

use ZfTable\Decorator\Exception;

class TemplateDecorator extends AbstractCellDecorator
{
    /**
     * Template
     * @var string
     */
    protected $template;

    /**
     * Array of variables
     * @var null | array
     */
    protected $vars;

    /**
     * Constructor
     *
     * @param array $options
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(array $options = [])
    {
        if (!isset($options['template'])) {
            throw new Exception\InvalidArgumentException('path key in options argument requred');
        }
        $this->template = $options['template'];
        $this->vars     = is_array($options['vars']) ? $options['vars']  : [$options['vars']];
        $this->place    = (isset($options['place'])) ? $options['place'] : self::RESET_CONTEXT;
    }

    /**
     * Rendering decorator
     *
     * @param string $context
     * @return string
     */
    public function render($context)
    {
        $values = [];

        foreach ($this->vars as $var) {
            $actualRow = $this->getCell()->getActualRow();
            if (is_object($actualRow)) {
                $actualRow = $actualRow->getArrayCopy();
            }
            $values[] = $actualRow[$var];
        }
        $value = vsprintf($this->template, $values);

        if ($this->place == self::RESET_CONTEXT) {
            return $value;
        } else {
            return ($this->place == self::PRE_CONTEXT) ? $value . $context : $context . $value;
        }
    }
}
