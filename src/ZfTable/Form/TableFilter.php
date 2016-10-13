<?php

namespace ZfTable\Form;

use Zend\InputFilter\InputFilter;

class TableFilter extends InputFilter
{

    public function __construct($columnFields = null)
    {
        //Create an input to filter the items of a generic table
        $this->add([
            'name'     => 'zfTableItemPerPage',
            'allowEmpty' => true,
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => 0,
                        'max'      => 30,
                    ],
                ],
            ],
        ]);
        $this->add([
            'name'     => 'zfTableQuickSearch',
            'allowEmpty' => true,
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => 0,
                        'max'      => 40,
                    ],
                ],
            ],
        ]);
        $this->add([
            'name'     => 'zfTableOrder',
            'allowEmpty' => true,
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => 0,
                        'max'      => 10,
                    ],
                ],
            ],
        ]);
        $this->add([
            'name'     => 'zfTableColumn',
            'allowEmpty' => true,
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => 0,
                        'max'      => 30,
                    ],
                ],
            ],
        ]);
        //Creates a filter for each of the input fields
        foreach ($columnFields as $fieldName) {
            $this->add([
                'name'     => 'zft_' . $fieldName,
                'allowEmpty' => true,
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 30,
                        ],
                    ],
                ],
            ]);
        }
    }
}
