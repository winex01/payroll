<?php

namespace App\Http\Controllers\Admin;

use App\Traits\CoreTrait;
use App\Http\Requests\EmployeeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Controllers\Admin\Operations\EmployeeFetchOperation;
use Winex01\BackpackFilter\Http\Controllers\Operations\FilterOperation;

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

    use CoreTrait;
    use FilterOperation;
    use EmployeeFetchOperation;

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
        $this->field('gender');
        $this->field('civilStatus');
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
            $gender = request('gender');
            if ($gender) {
                $query->where('gender_id', $gender);
            }

            $civilStatus = request('civilStatus');
            if ($civilStatus) {
                $query->where('civil_status_id', $civilStatus);
            }
        });

        CRUD::setFromDb(false, true);
        $this->imageColumn('photo');
        $this->column('gender.name')->after('middle_name');
        $this->column('civilStatus.name')->after('birth_place');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     *
     */
    protected function setupCreateOperation()
    {
        $this->widgetBladeScript('crud::scripts.employee');

        CRUD::setValidation(EmployeeRequest::class);

        $this->imageField('photo');
        $this->field('employee_no');
        $this->field('last_name');
        $this->field('first_name');
        $this->field('middle_name');

        $tab = __('Personal Details');
        $this->field('gender')->tab($tab);
        $this->field('birth_date')->tab($tab);
        $this->field('birth_place')->tab($tab);
        $this->field('civilStatus')->tab($tab);
        $this->field('date_of_marriage')->tab($tab);

        $this->field('mobile_no')->tab($tab);
        $this->field('telephone_no')->tab($tab);
        $this->field('personal_email')->tab($tab);
        $this->field('company_email')->tab($tab);

        $this->field('current_address')->tab($tab);
        $this->field('home_address')->tab($tab);
        $this->field('house_no')->tab($tab);
        $this->field('street')->tab($tab);
        $this->field('brgy')->tab($tab);
        $this->field('city')->tab($tab);
        $this->field('province')->tab($tab);
        $this->field('zip_code')->tab($tab);

        $tab = __('Tin, Sss, Phil...');
        $this->field('tin')->tab($tab);
        $this->field('sss')->tab($tab);
        $this->field('philhealth')->tab($tab);
        $this->field('pagibig')->tab($tab);
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
        $this->setupListOperation();
    }
}
