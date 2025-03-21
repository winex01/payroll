<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShiftSchedule;
use App\Http\Controllers\Admin\Traits\CoreTraits;
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

    use CoreTraits;
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
        $this->employeeRelationshipFilter();
        $this->crud->field('date_range')->type('date_range')->size(4);

        $valueOptions = ShiftSchedule::get()->pluck('name', 'id');
        $valueOptions = $valueOptions->prepend('- (Rest Day)', -1)->toArray();

        $this->crud->field([
            'name' => 'shift_schedule',
            'type' => 'select_from_array',
            'options' => $valueOptions,
            'allows_null' => true,
        ])->size(4);
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
            $this->employeeQueriesFilter($query);

            $shiftSchedule = request('shift_schedule');
            if ($shiftSchedule) {
                if ($shiftSchedule == -1) {
                    $query->whereNull('shift_schedule_id');
                } else {
                    $query->where('shift_schedule_id', $shiftSchedule);
                }
            }

            // TODO:: date range
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
