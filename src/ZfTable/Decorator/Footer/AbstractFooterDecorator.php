<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */
namespace ZfTable\Decorator\Footer;

use ZfTable\Decorator\AbstractDecorator;

abstract class AbstractFooterDecorator extends AbstractDecorator
{
    /**
     * Footer object
     * @var \ZfTable\Footer
     */
    protected $footer;

    /**
     *
     * @return \ZfTable\Footer
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     *
     * @param \ZfTable\Footer $footer
     * @return \ZfTable\Decorator\Footer\AbstractFooterDecorator
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
        return $this;
    }
}
