<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

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
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $tab = 'Personal Data';
        CRUD::column('photo')->tab($tab);
        CRUD::column('employee_no')->tab($tab);
        CRUD::column('last_name')->tab($tab);
        CRUD::column('first_name')->tab($tab);
        CRUD::column('middle_name')->tab($tab);
        CRUD::column('home_address')->tab($tab);
        CRUD::column('current_address')->tab($tab);
        CRUD::column('house_no')->tab($tab);
        CRUD::column('street')->tab($tab);
        CRUD::column('brgy')->tab($tab);
        CRUD::column('city')->tab($tab);
        CRUD::column('province')->tab($tab);
        CRUD::column('zip_code')->tab($tab);

        $tab = 'Social Agencies';
        CRUD::column('tin')->tab($tab);
        CRUD::column('sss')->tab($tab);
        CRUD::column('pagibig')->tab($tab);
        CRUD::column('philhealth')->tab($tab);
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

        $tab = 'Personal Data';
        CRUD::field('photo')->tab($tab);
        CRUD::field('employee_no')->tab($tab);
        CRUD::field('last_name')->tab($tab);
        CRUD::field('first_name')->tab($tab);
        CRUD::field('middle_name')->tab($tab);
        CRUD::field('home_address')->tab($tab);
        CRUD::field('current_address')->tab($tab);
        CRUD::field('house_no')->tab($tab);
        CRUD::field('street')->tab($tab);
        CRUD::field('brgy')->tab($tab);
        CRUD::field('city')->tab($tab);
        CRUD::field('province')->tab($tab);
        CRUD::field('zip_code')->tab($tab);

        $tab = 'Social Agencies';
        CRUD::field('tin')->tab($tab);
        CRUD::field('sss')->tab($tab);
        CRUD::field('pagibig')->tab($tab);
        CRUD::field('philhealth')->tab($tab);

        // $table->foreignId('gender_id')->after('zip_code')->nullable()->constrained()->onDelete('set null');
        // $table->date('date_of_birth')->nullable();
        // $table->string('birth_place')->nullable();
        // $table->foreignId('civil_status_id')->after('birth_place')->nullable()->constrained()->onDelete('set null');
        // $table->date('date_of_marriage')->nullable();
        // $table->string('telephone_no')->nullable();
        // $table->string('mobile_no')->nullable();
        // $table->string('personal_email')->nullable();
        // $table->string('company_email')->nullable();

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
