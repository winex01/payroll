<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShiftScheduleRequest;
use App\Http\Controllers\Admin\Traits\CoreTraits;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShiftScheduleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShiftScheduleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use CoreTraits;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\ShiftSchedule::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shift-schedule');
        CRUD::setEntityNameStrings('shift schedule', 'shift schedules');

        $this->userPermissions();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->column('name');

        $this->crud->column([
            'name' => 'working_hours',
            'type' => 'closure',
            'function' => function ($entry) {
                return $entry->working_hours_details;
            },
            'orderable' => false,
            'escaped' => false,
        ]);

        $this->crud->column([
            'name' => 'day_start',
            'type' => 'closure',
            'function' => function ($entry) {
                return $entry->day_start_details;
            },
        ]);

        $this->crud->column([
            'name' => 'shift_policies',
            'type' => 'closure',
            'function' => function ($entry) {
                // TODO::
                return 'test123';
            },
        ]);

        $this->crud->modifyColumn('day_start', [

        ]);

        $this->crud->column('description')->limit(999);
    }

    public function setupShowOperation()
    {
        $this->setupListOperation();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->widgetBladeScript('crud::scripts.shift-schedule');

        CRUD::setValidation(ShiftScheduleRequest::class);
        CRUD::setFromDb();

        $this->crud->field('name')->hint('Example: 08:30AM-5:30PM, AM, PM, Graveyard Shift, Etc.');
        $this->crud->field('open_time');
        $this->crud->field('early_login_overtime')->size(3);
        $this->crud->field('after_shift_overtime')->size(3);
        $this->crud->field('night_differential')->size(3);

        $this->crud->field([   // repeatable
            'name' => 'working_hours',
            'type' => 'repeat',
            'fields' => [ // also works as: "fields"
                [
                    'name' => 'start',
                    'type' => 'time',
                    'wrapper' => ['class' => 'form-group col-sm-6'],
                ],
                [
                    'name' => 'end',
                    'type' => 'time',
                    'wrapper' => ['class' => 'form-group col-sm-6'],
                ],
            ],
            'init_rows' => 1, // number of empty rows to be initialized, by default 1
            'min_rows' => 1, // minimum rows allowed, when reached the "delete" buttons will be hidden
            'new_item_label' => 'Add working hours', // customize the text of the button
        ]);

        $this->crud->field([
            'name' => 'day_start',
            'type' => 'time',
        ]);

        $this->crud->field([
            'name' => 'separator',
            'type' => 'custom_html',
            'value' => 'Shift Policies:',
            'wrapper' => ['class' => 'mb-n-5']
        ])->after('day_start');
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
}
