<?php

namespace App\Http\Controllers\Admin;

use App\Traits\CoreTrait;
use App\Http\Requests\ChangeShiftScheduleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Winex01\BackpackFilter\Http\Controllers\Operations\FilterOperation;

/**
 * Class ChangeShiftScheduleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ChangeShiftScheduleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use CoreTrait;
    use FilterOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
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
        $this->crud->field('date_range')->type('date_range')->size(4);
        $this->crud->field('shiftSchedule')->size(4);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
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
        $this->crud->column('date')->type('date');
        $this->crud->column('shiftSchedule')->label(__('Shift Schedule'));
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ChangeShiftScheduleRequest::class);
        $this->crud->field('employee');
        $this->crud->field('date')->type('date');
        $this->crud->field('shiftSchedule');
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
}
