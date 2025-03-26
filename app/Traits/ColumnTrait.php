<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Facades\HelperFacade;
use Illuminate\Support\Facades\Schema;

trait ColumnTrait
{
    public function morphColumn($relationship, $table = null)
    {
        $this->morphType($relationship, $table, 'column');
    }

    /*
    |--------------------------------------------------------------------------
    | Employee
    |--------------------------------------------------------------------------
    */
    // TODO:: refactor
    public function employeePhoto($fieldOrColumn = 'column', $relationship = true)
    {
        return $this->crud->{$fieldOrColumn}([
            'name' => ($relationship) ? 'employee.photo' : 'photo',
            'label' => 'Photo',
            'type' => ($fieldOrColumn == 'field') ? 'upload' : 'image',
            'height' => ($this->crud->getOperation() == 'show') ? '100px' : '25px',
            'width' => ($this->crud->getOperation() == 'show') ? '100px' : '25px',
            'withFiles' => [
                'disk' => 'public',
                // we use ternary below, bec. backpack will cause warning if path is not null if its a column.
                'path' => ($fieldOrColumn == 'column') ? null : 'photos',
            ],
            'orderable' => false,
        ])->makeFirst();

    }

    public function employeeColumn($column = 'employee', $label = 'employee')
    {
        $this->crud->removeColumn([
            $column,
            str_replace('.', '__', $column)
        ]);

        return $this->crud->column([
            'name' => $column,
            'label' => __('Employee'),
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas($column['name'], function ($q) use ($searchTerm) {
                    $q->where('last_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('first_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('middle_name', 'like', '%' . $searchTerm . '%');
                });
            },
            'orderable' => true,
            'orderLogic' => function ($query, $column, $columnDirection) {
                $currentTable = $this->crud->model->getTable();
                $leftTable = 'employees';
                return $query
                    ->leftJoin($leftTable, $leftTable . '.id', '=', $currentTable . '.employee_id')
                    ->orderBy($leftTable . '.last_name', $columnDirection)
                    ->orderBy($leftTable . '.first_name', $columnDirection)
                    ->orderBy($leftTable . '.middle_name', $columnDirection)
                    ->select($currentTable . '.*');
            },
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('employee/' . $related_key . '/show');
                },
            ]
        ])->makeFirst();
    }
}
