<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use App\Http\Controllers\Admin\Traits\WidgetHelper;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Winex01\BackpackFilter\Http\Controllers\Operations\FilterOperation;
use Winex01\BackpackPermissionManager\Http\Controllers\Traits\UserPermissions;

/**
 * Class EmployeeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use UserPermissions;
    use WidgetHelper;
    use FilterOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee');
        CRUD::setEntityNameStrings('employee', 'employees');

        $this->userPermissions();
    }

    public function setupFilterOperation()
    {
        $this->crud->field([
            'name' => 'status',
            'label' => __('Status'),
            'type' => 'select_from_array',
            'options' => [
                1 => 'Connected',
                2 => 'Disconnected'
            ],
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);

        //
        $this->crud->field([
            'name' => 'date_range',
            'label' => __('Date Range'),
            'type' => 'date_range',
            'wrapper' => [
                'class' => 'form-group col-md-3'
            ]
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->input('column');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(EmployeeRequest::class);

        $this->widgetScript('assets/js/admin/forms/employee.js');

        $this->input('field');

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

    public function setupShowOperation()
    {
        $this->crud->setOperationSetting('tabsEnabled', true);
        $this->setupListOperation();

        $this->crud->modifyColumn('photo', [
            'height' => '100px',
            'width' => '100px'
        ]);
    }

    private function input($input = 'field')
    {
        $this->crud->{$input}([
            'name' => 'photo',
            'type' => ($input == 'field') ? 'upload' : 'image',
            'withFiles' => [
                'disk' => 'public',
                'path' => 'photos',
            ]
        ]);

        $this->crud->{$input}('employee_no');
        $this->crud->{$input}('last_name');
        $this->crud->{$input}('first_name');
        $this->crud->{$input}('middle_name');

        $tab = 'Tin, Sss, Phil...';
        $this->crud->{$input}('tin')->tab($tab);
        $this->crud->{$input}('sss')->tab($tab);
        $this->crud->{$input}('philhealth')->tab($tab);
        $this->crud->{$input}('pagibig')->tab($tab);

        $tab = 'Contacts';
        $this->crud->{$input}('mobile_no')->tab($tab);
        $this->crud->{$input}('telephone_no')->tab($tab);
        $this->crud->{$input}('personal_email')->tab($tab);
        $this->crud->{$input}('company_email')->tab($tab);

        $tab = 'Address';
        $this->crud->{$input}('current_address')->tab($tab);
        $this->crud->{$input}('home_address')->tab($tab);
        $this->crud->{$input}('house_no')->tab($tab);
        $this->crud->{$input}('street')->tab($tab);
        $this->crud->{$input}('brgy')->tab($tab);
        $this->crud->{$input}('city')->tab($tab);
        $this->crud->{$input}('province')->tab($tab);
        $this->crud->{$input}('zip_code')->tab($tab);

        $tab = 'More Details...';
        $this->crud->{$input}('gender')->tab($tab);
        $this->crud->{$input}('birth_date')->tab($tab);
        $this->crud->{$input}('birth_place')->tab($tab);
        $this->crud->{$input}('civilStatus')->tab($tab);
        $this->crud->{$input}('date_of_marriage')->tab($tab);
    }
}
