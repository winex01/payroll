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
        $this->data('column');
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

        $this->data('field');
    }

    private function data($data = 'field')
    {
        $this->script('assets/js/admin/forms/employee.js');

        CRUD::{$data}('photo');
        CRUD::{$data}('employee_no');
        CRUD::{$data}('last_name');
        CRUD::{$data}('first_name');
        CRUD::{$data}('middle_name');

        $tab = 'Tin, Sss, Phil...';
        CRUD::{$data}('tin')->tab($tab);
        CRUD::{$data}('sss')->tab($tab);
        CRUD::{$data}('philhealth')->tab($tab);
        CRUD::{$data}('pagibig')->tab($tab);

        $tab = 'Contacts';
        CRUD::{$data}('mobile_no')->tab($tab);
        CRUD::{$data}('telephone_no')->tab($tab);
        CRUD::{$data}('personal_email')->tab($tab);
        CRUD::{$data}('company_email')->tab($tab);

        $tab = 'Address Details';
        CRUD::{$data}('current_address')->tab($tab);
        CRUD::{$data}('home_address')->tab($tab);
        CRUD::{$data}('house_no')->tab($tab);
        CRUD::{$data}('street')->tab($tab);
        CRUD::{$data}('brgy')->tab($tab);
        CRUD::{$data}('city')->tab($tab);
        CRUD::{$data}('province')->tab($tab);
        CRUD::{$data}('zip_code')->tab($tab);

        $tab = 'More Data...';
        CRUD::{$data}('gender')->tab($tab);
        CRUD::{$data}('date_of_birth')->tab($tab);
        CRUD::{$data}('birth_place')->tab($tab);
        CRUD::{$data}('civilStatus')->tab($tab);
        CRUD::{$data}('date_of_marriage')->tab($tab);
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
    }
}
