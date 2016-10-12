<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */


namespace ZfTable\Example\TableExample;

use ZfTable\AbstractTable;

class LinkDecorator extends AbstractTable
{

    /**
     * @var array Definition of headers
     */
    protected $headers = [
        'artist' => ['title' => 'Artist'],
        'title'  => ['title' => 'Title']
    ];

    public function init()
    {
        $this->getHeader('artist')->getCell()->addDecorator('link', [
            'url' => 'http://zf2/artist/%s',
            'vars' => ['id']
        ])->addCondition('equal', ['column' => 'artist', 'values' => 'Adele']);
    }
}
