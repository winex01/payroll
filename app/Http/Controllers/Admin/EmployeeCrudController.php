<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use App\Http\Controllers\Admin\Traits\CoreTraits;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
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
            $gender = request()->input('gender');
            $civilStatus = request()->input('civilStatus');

            if ($gender) {
                $query->where('gender_id', $gender);
            }

            if ($civilStatus) {
                $query->where('civil_status_id', $gender);
            }
        });

        $this->input('column');
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
        $name = 'civilStatus';
        $this->crud->{$input}($name)->label($this->strToHumanReadable($name))->tab($tab);
        $this->crud->{$input}('date_of_marriage')->tab($tab);
    }
}
