<?php

namespace App\Http\Controllers\Admin;

use App\Traits\CoreTrait;
use App\Http\Requests\ChangeShiftScheduleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Winex01\BackpackFilter\Http\Controllers\Operations\FilterOperation;

class ChangeShiftScheduleCrudController extends CrudController
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
        CRUD::setModel(\App\Models\ChangeShiftSchedule::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/change-shift-schedule');
        CRUD::setEntityNameStrings('change shift', 'change shifts');

        $this->userPermissions();
        $this->datePermissions();
    }

    public function setupFilterOperation()
    {
        $this->employeeFilter();
        $this->field('date_range')->type('date_range')->size(4);
        $this->field('shiftSchedule')->size(4);
    }

    protected function setupListOperation()
    {
        $this->filterQueries(function ($query) {
            $this->employeeQueryFilter($query);

            $dateRange = request('date_range');
            if ($dateRange) {
                $query->whereBetween('date', $this->dateRange($dateRange));
            }

            $shiftSchedule = request('shiftSchedule');
            if ($shiftSchedule) {
                $query->where('shift_schedule_id', $shiftSchedule);
            }
        });

        $this->employeeColumn();
        $this->column('date');
        $this->column('shiftSchedule.name');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ChangeShiftScheduleRequest::class);
        $this->field('employee');
        $this->field('date');
        $this->field('shiftSchedule');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
}
