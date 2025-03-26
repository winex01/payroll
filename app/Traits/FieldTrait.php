<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Facades\HelperFacade;
use Illuminate\Support\Facades\Schema;

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
            // in filterOperation: chain method and use ->type('select_from_array') so you can select 3 state: 1. null/- 2. False, 3 True
            'type' => 'radio',
            'options' => $options,
        ])->size(2);
    }

    public function morphField($relationship, $table = null)
    {
        $this->morphType($relationship, $table, 'field');
    }
}
