<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use App\Http\Controllers\Admin\Traits\CoreTraits;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Controllers\Admin\FetchRoutes\SetupEmployeeFetchRoutes;
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

    use CoreTraits;
    use FilterOperation;
    use SetupEmployeeFetchRoutes;

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
        $this->crud->field('gender');
        $this->crud->field('civilStatus');
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
            $civilStatus = request('civilStatus');

            if ($gender) {
                $query->where('gender_id', $gender);
            }

            if ($civilStatus) {
                $query->where('civil_status_id', $civilStatus);
            }
        });

        CRUD::setFromDb(false, true);
        $this->crud->removeColumn('photo');
        $this->employeePhoto('column', false);
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

        $this->employeePhoto('field', false);
        $this->crud->field('employee_no');
        $this->crud->field('last_name');
        $this->crud->field('first_name');
        $this->crud->field('middle_name');

        $tab = 'Personal Details';
        $this->crud->field('gender')->tab($tab);
        $this->crud->field('birth_date')->tab($tab);
        $this->crud->field('birth_place')->tab($tab);
        $name = 'civilStatus';
        $this->crud->field($name)->label($this->strToHumanReadable($name))->tab($tab);
        $this->crud->field('date_of_marriage')->tab($tab);

        $this->crud->field('mobile_no')->tab($tab);
        $this->crud->field('telephone_no')->tab($tab);
        $this->crud->field('personal_email')->tab($tab);
        $this->crud->field('company_email')->tab($tab);

        $this->crud->field('current_address')->tab($tab);
        $this->crud->field('home_address')->tab($tab);
        $this->crud->field('house_no')->tab($tab);
        $this->crud->field('street')->tab($tab);
        $this->crud->field('brgy')->tab($tab);
        $this->crud->field('city')->tab($tab);
        $this->crud->field('province')->tab($tab);
        $this->crud->field('zip_code')->tab($tab);

        $tab = 'Tin, Sss, Phil...';
        $this->crud->field('tin')->tab($tab);
        $this->crud->field('sss')->tab($tab);
        $this->crud->field('philhealth')->tab($tab);
        $this->crud->field('pagibig')->tab($tab);
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
