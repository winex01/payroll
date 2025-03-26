<?php

namespace App\Traits;

trait ColumnTrait
{
    /*
    |--------------------------------------------------------------------------
    | Employee
    |--------------------------------------------------------------------------
    */
    public function employeePhoto($fieldOrColumn = 'column', $relationship = true)
    {
        $this->crud->{$fieldOrColumn}([
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

    public function employeeColumn($column = 'employee', $linkTo = null)
    {
        // if column not exist then we create it
        if (!isset($this->crud->settings()['list.columns'][$column])) {
            // if raw column or FK column exist then we remove it.
            if (isset($this->crud->settings()['list.columns']['employee_id'])) {
                $this->crud->removeColumn('employee_id');
            }
            $this->crud->column($column)->makeFirst();
        }

        $this->crud->modifyColumn($column, [
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) use ($linkTo) {
                    if ($linkTo) {
                        return $linkTo;
                    }
                    return backpack_url($column['name'] . '/' . $related_key . '/show');
                },
                'title' => function ($crud, $column, $entry, $related_key) {
                    if (!$entry->employee->employee_no) {
                        return;
                    }

                    return 'EMP NO: ' . $entry->employee->employee_no;
                }
                // 'target' => '_blank'
            ],

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
        ]);
    }
}
