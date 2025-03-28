<?php

namespace App\Traits;

use App\Facades\HelperFacade;

trait FieldTrait
{
    public function field($name)
    {
        $this->crud->removeFields([
            $name,
            str_replace('.', '__', $name)
        ]);

        return $this->crud->field($name)->label(HelperFacade::strToHumanReadable($name));
    }

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

    public function morphFields($relationship, $table = null)
    {
        $this->morphColumnsFields($relationship, $table, 'field');
    }
}
