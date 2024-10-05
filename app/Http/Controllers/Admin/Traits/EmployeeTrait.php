<?php

namespace App\Http\Controllers\Admin\Traits;

trait EmployeeTrait
{
    public function whereHasEmployee()
    {
        $this->crud->query->whereHas('employee');
    }

    public function employeeColumn($column = 'employee', $linkTo = null)
    {
        if (isset($this->crud->settings()['list.columns'][$column])) {
            $this->crud->column($column);
        }

        $this->crud->modifyColumn($column, [
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) use ($linkTo) {
                    if ($linkTo) {
                        return $linkTo;
                    }
                    return backpack_url($column['name'] . '/' . $related_key . '/show');
                },
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
