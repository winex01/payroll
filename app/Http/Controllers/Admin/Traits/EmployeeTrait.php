<?php

namespace App\Http\Controllers\Admin\Traits;

trait EmployeeTrait
{
    public function whereHasEmployee()
    {
        $this->crud->query->whereHas('employee');
    }

    public function employeeColumn($column = 'employee')
    {
        // $currentTable = $this->crud->model->getTable();

        $this->crud->modifyColumn($column, [
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('employee', function ($q) use ($searchTerm) {
                    $q->where('last_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('first_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('middle_name', 'like', '%' . $searchTerm . '%');
                });
            },
            'orderLogic' => function ($query, $column, $columnDirection) {
                return $query->whereHas('employee', function ($query) use ($columnDirection) {
                    $query->orderBy('last_name', $columnDirection);
                    $query->orderBy('first_name', $columnDirection);
                    $query->orderBy('middle_name', $columnDirection);
                });
            },
            'orderable' => true,
        ]);
    }
}
