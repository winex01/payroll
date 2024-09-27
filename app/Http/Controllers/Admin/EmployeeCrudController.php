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

        $this->crud->setOperationSetting('tabsType', 'vertical');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb();
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
        // CRUD::setFromDb();

        $tab1 = 'Personal Data';
        CRUD::field('photo')->tab($tab1);
        CRUD::field('employee_no')->tab($tab1);
        CRUD::field('last_name')->tab($tab1);
        CRUD::field('first_name')->tab($tab1);
        CRUD::field('middle_name')->tab($tab1);
        CRUD::field('tin')->tab($tab1);
        CRUD::field('sss')->tab($tab1);
        CRUD::field('pagibig')->tab($tab1);
        CRUD::field('philhealth')->tab($tab1);


        // $table->string('tin')->nullable();
        // $table->string('sss')->nullable();
        // $table->string('pagibig')->nullable();
        // $table->string('philhealth')->nullable();

        // $table->string('home_address')->nullable();
        // $table->string('current_address')->nullable();
        // $table->string('house_no')->nullable();
        // $table->string('street')->nullable();
        // $table->string('brgy')->nullable();
        // $table->string('city')->nullable();
        // $table->string('province')->nullable();
        // $table->string('zip_code')->nullable();

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
}
