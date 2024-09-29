<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use App\Http\Controllers\Admin\Traits\Script;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
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
    use Script;

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

        $this->script('assets/js/admin/forms/employee.js');

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

        CRUD::modifyColumn('photo', [
            'height' => '100px',
            'width' => '100px'
        ]);
    }

    private function input($input = 'field')
    {
        CRUD::{$input}([
            'name' => 'photo',
            'type' => ($input == 'field') ? 'upload' : 'image',
            'withFiles' => [
                'disk' => 'public',
                'path' => 'photos',
            ]
        ]);

        CRUD::{$input}('employee_no');
        CRUD::{$input}('last_name');
        CRUD::{$input}('first_name');
        CRUD::{$input}('middle_name');

        $tab = 'Tin, Sss, Phil...';
        CRUD::{$input}('tin')->tab($tab);
        CRUD::{$input}('sss')->tab($tab);
        CRUD::{$input}('philhealth')->tab($tab);
        CRUD::{$input}('pagibig')->tab($tab);

        $tab = 'Contacts';
        CRUD::{$input}('mobile_no')->tab($tab);
        CRUD::{$input}('telephone_no')->tab($tab);
        CRUD::{$input}('personal_email')->tab($tab);
        CRUD::{$input}('company_email')->tab($tab);

        $tab = 'Address';
        CRUD::{$input}('current_address')->tab($tab);
        CRUD::{$input}('home_address')->tab($tab);
        CRUD::{$input}('house_no')->tab($tab);
        CRUD::{$input}('street')->tab($tab);
        CRUD::{$input}('brgy')->tab($tab);
        CRUD::{$input}('city')->tab($tab);
        CRUD::{$input}('province')->tab($tab);
        CRUD::{$input}('zip_code')->tab($tab);

        $tab = 'More Details...';
        CRUD::{$input}('gender')->tab($tab);
        CRUD::{$input}('birth_date')->tab($tab);
        CRUD::{$input}('birth_place')->tab($tab);
        CRUD::{$input}('civilStatus')->tab($tab);
        CRUD::{$input}('date_of_marriage')->tab($tab);
    }
}
