<?php
namespace ZfTable\Form;

use Zend\Form\Form;

class TableForm extends Form
{
    public function __construct($columnFields = null)
    {
        //Create the generic fields for the table
        parent::__construct('ZFTable');
        $this->setAttribute('method', 'post');
        $this->add([
            'name' => 'zfTableItemPerPage',
            'attributes' => [
                'type'  => 'text',
            ],
        ]);
        $this->add([
            'name' => 'zfTableQuickSearch',
            'attributes' => [
                'type'  => 'text',
            ],
        ]);
        $this->add([
            'name' => 'zfTableOrder',
            'attributes' => [
                'type'  => 'text',
            ],
        ]);
        $this->add([
            'name' => 'zfTableColumn',
            'attributes' => [
                'type'  => 'text',
            ],
        ]);

        //Creates a field for each of the columns in the table
        foreach ($columnFields as $fieldName) {
            $this->add([
                'name' => 'zft_' . $fieldName,
                'attributes' => [
                    'type'  => 'text',
                ],
            ]);
        }
    }
}
