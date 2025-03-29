<?php

namespace App\Http\Controllers\Admin;

use App\Traits\CoreTrait;
use App\Http\Requests\EmployeeShiftScheduleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Winex01\BackpackFilter\Http\Controllers\Operations\FilterOperation;

class EmployeeShiftScheduleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use CoreTrait;
    use FilterOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\EmployeeShiftSchedule::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee-shift-schedule');
        CRUD::setEntityNameStrings('employee shift', 'employee shifts');

        $this->userPermissions();
        $this->datePermissions('effectivity_date');
    }

    public function setupFilterOperation()
    {
        $this->employeeFilter();
        $this->effectivityDateFilter();
        $this->historyFilter();
    }

    protected function setupListOperation()
    {
        $this->filterQueries(function ($query) {
            $this->employeeQueryFilter($query);
            $this->historyQueriesFilter($query);
        });

        $this->employeeColumn();
        $this->column('effectivity_date');
        foreach ($this->daysOfWeek() as $day) {
            $this->column("$day.name");
        }
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(EmployeeShiftScheduleRequest::class);

        $this->field('employee');
        $this->field('effectivity_date');
        foreach ($this->daysOfWeek() as $day) {
            $this->field($day)->size(4);
        }
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
