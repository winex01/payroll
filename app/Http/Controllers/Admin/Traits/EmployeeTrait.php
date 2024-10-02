<?php

namespace App\Http\Controllers\Admin\Traits;

trait EmployeeTrait
{
    public function whereHasEmployee()
    {
        $this->crud->query->whereHas('employee');
    }
}
