<?php

namespace App\Http\Requests\Traits;

use Illuminate\Validation\Rule;

trait ValidateUniqueTrait
{
    public function validateUnique($attribute = 'name', $column = 'name', $table = null)
    {
        if (!$table) {
            $table = $this->crud->model->getTable();
        }

        return [
            $attribute => [
                'required',
                'min:2',
                'max:255',
                Rule::unique($table, $column)
                    ->ignore(request('id')),
            ],
        ];
    }
}
