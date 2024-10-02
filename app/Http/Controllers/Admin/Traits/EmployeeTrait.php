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
        // $currentTable = $this->crud->model->getTable();

        if (isset($this->crud->settings()['list.columns'][$column])) {
            $this->crud->column($column);
        }

        $this->crud->modifyColumn($column, [
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas($column['name'], function ($q) use ($searchTerm) {
                    $q->where('last_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('first_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('middle_name', 'like', '%' . $searchTerm . '%');
                });
            },
            'orderLogic' => function ($query, $column, $columnDirection) {
                return $query->whereHas($column['name'], function ($query) use ($columnDirection) {
                    $query->orderBy('last_name', $columnDirection);
                    $query->orderBy('first_name', $columnDirection);
                    $query->orderBy('middle_name', $columnDirection);
                });
            },
            'orderable' => true,

            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) use ($linkTo) {
                    if ($linkTo) {
                        return $linkTo;
                    }

                    return backpack_url($column['name'] . '/' . $related_key . '/show');
                },
                // 'target' => '_blank'
            ]
        ]);
    }
}
