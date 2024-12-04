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
        // CRUD::setFromDb();
        // CRUD::setFromDb(false, true);
        // $this->input('column');

        // // TODO::
        // $this->crud->modifyColumn('working_hours', [
        //     'type' => 'closure',
        //     'function' => function ($entry) {
        //         return 'test 123';
        //     },
        //     'escaped' => false
        // ]);

        // dd($this->crud->columns());
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

        $this->input();

        $this->crud->field([
            'name' => 'separator',
            'type' => 'custom_html',
            'value' => 'Allow if check:',
            'wrapper' => ['class' => 'mb-n-5']
        ])->after('open_time');

        // dd($this->crud->fields());
        // dd(request()->all());
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

    public function input($input = 'field')
    {
        $this->crud->{$input}('open_time');
        $this->crud->{$input}('open_time_overtime')->size(3);
        $this->crud->{$input}('early_login_overtime')->size(3);
        $this->crud->{$input}('after_shift_overtime')->size(3);
        $this->crud->{$input}('night_differential')->size(3);

        $this->crud->{$input}([   // repeatable
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

        $this->crud->{$input}([
            'name' => 'day_start',
            'type' => 'time',
        ]);
    }
}

/* TODO::
    validation for working hours repeat start and end
    validation for day start
*/
