<?php

namespace App\Http\Controllers\Admin;

use App\Traits\CoreTrait;
use App\Http\Requests\ShiftScheduleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ShiftScheduleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use CoreTrait;

    public function setup()
    {
        CRUD::setModel(\App\Models\ShiftSchedule::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shift-schedule');
        CRUD::setEntityNameStrings('shift schedule', 'shift schedules');

        $this->userPermissions();
        $this->ignoreIdPermissions(1); // 1 = Rest day
    }

    protected function setupListOperation()
    {
        $this->column('name');
        $this->column('working_hours_details')->escaped(false);
        $this->column('shift_policies_details')->escaped(false);
        $this->column('day_start_details')->escaped(false);

        $this->column('description');
    }

    public function setupShowOperation()
    {
        $this->setupListOperation();
    }

    protected function setupCreateOperation()
    {
        $this->widgetBladeScript('crud::scripts.shift-schedule');

        CRUD::setValidation(ShiftScheduleRequest::class);
        CRUD::setFromDb();

        $this->field('name')->hint('Example: 08:30AM-5:30PM, Morning Shift, Graveyard Shift, Etc.');
        $this->booleanField('open_time');

        $this->field([   // repeatable
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

        // label: Shift Policies
        $this->field([
            'name' => 'temp',
            'type' => 'custom_html',
            'value' => 'Shift Policies:',
            'wrapper' => ['class' => 'form-group col-sm-12']// this wrapper supports: bs4, bs5
        ])->after('working_hours');

        $this->field('early_login_overtime')->size(4);
        $this->field('after_shift_overtime')->size(4);
        $this->field('night_differential')->size(4);
        $this->field('late')->size(4);
        $this->field('undertime')->size(4);

        $this->field([
            'name' => 'day_start',
            'type' => 'number',
            'default' => 2,
            'attributes' => [
                'step' => 1,
                'min' => 1,
                'max' => 5,
            ],
            'wrapper' => ['class' => 'form-group col-sm-12 mt-2'],
            'prefix' => 'Hours',
            'hint' => "This value will be subtracted from the employee's working hours start time to determine
                         the official start of the workday. For example, if an employee's shift schedule is from
                         7 AM to 12 PM and 1 PM to 5 PM, the system will use 7 AM as the base time. If this value
                         is set to 2, the workday will start at 5 AM. This adjustment helps prevent overtime from
                         overlapping into the next day."
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
