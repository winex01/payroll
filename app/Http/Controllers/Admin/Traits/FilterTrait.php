<?php

namespace App\Http\Controllers\Admin\Traits;

trait FilterTrait
{
    use StrTrait;

    // NOTE:: for select2 multiple just chain ->type('select_multiple');
    public function filterSelect2($name = 'name', $wrapper = ['class' => 'form-group col-md-3'], $attributes = ['data-filter-type' => 'select2',])
    {
        return $this->crud->field([
            'name' => $name,
            'label' => $this->strToHumanReadable($name),
            'wrapper' => $wrapper,
            'attributes' => $attributes,
        ]);
    }
}
