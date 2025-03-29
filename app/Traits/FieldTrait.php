<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Facades\HelperFacade;

trait FieldTrait
{
    public function field($nameOrDefinition)
    {
        if (is_array($nameOrDefinition)) {
            return $this->crud->field($nameOrDefinition);
        }

        $name = $nameOrDefinition;
        $nameParts = explode('.', $name);

        $this->crud->removeFields([
            $name,
            str_replace('.', '__', $name),
            Str::snake($nameParts[0]) . '_id',
        ]);

        return $this->crud->field($name)->label(HelperFacade::strToHumanReadable($nameParts[0]));
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
