<?php

namespace App\Http\Controllers\Admin\Traits;

trait FieldTrait
{
    public function booleanField($name, $options = [], $default = 0)
    {
        if (!$options) {
            $options = [
                0 => 'No',
                1 => 'Yes'
            ];
        }

        $this->crud->field([
            'name' => $name,
            'type' => 'radio',
            'default' => $default,
            'options' => $options,
        ]);
    }
}
