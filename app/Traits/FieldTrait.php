<?php

namespace App\Traits;

trait FieldTrait
{
    public function booleanField($name, $options = [])
    {
        if (!$options) {
            $options = [
                false => 'No',
                true => 'Yes'
            ];
        }

        return $this->crud->field([
            'name' => $name,
            'type' => 'radio',
            'options' => $options,
        ]);
    }

    public function imageField($name)
    {
        return $this->crud->field([
            'name' => $name,
            'type' => 'upload',
            'height' => ($this->crud->getOperation() == 'show') ? '100px' : '25px',
            'width' => ($this->crud->getOperation() == 'show') ? '100px' : '25px',
            'withFiles' => [
                'disk' => 'public',
                'path' => $name,
            ],
            'orderable' => false,
        ])->makeFirst();

    }

    public function morphField($relationship, $table = null)
    {
        $this->morphType($relationship, $table, 'field');
    }
}
