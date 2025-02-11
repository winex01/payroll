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
            $gender = request('gender');
            $civilStatus = request('civilStatus');

            if ($gender) {
                $query->where('gender_id', $gender);
            }

            if ($civilStatus) {
                $query->where('civil_status_id', $civilStatus);
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
        $this->widgetBladeScript('crud::scripts.employee');

        CRUD::setValidation(EmployeeRequest::class);

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
    }

    private function input($input = 'field')
    {
        $this->employeePhoto($input, false);
        $this->crud->{$input}('employee_no');
        $this->crud->{$input}('last_name');
        $this->crud->{$input}('first_name');
        $this->crud->{$input}('middle_name');

        $tab = 'Personal Details';
        $this->crud->{$input}('gender')->tab($tab);
        $this->crud->{$input}('birth_date')->tab($tab);
        $this->crud->{$input}('birth_place')->tab($tab);
        $name = 'civilStatus';
        $this->crud->{$input}($name)->label($this->strToHumanReadable($name))->tab($tab);
        $this->crud->{$input}('date_of_marriage')->tab($tab);

        $this->crud->{$input}('mobile_no')->tab($tab);
        $this->crud->{$input}('telephone_no')->tab($tab);
        $this->crud->{$input}('personal_email')->tab($tab);
        $this->crud->{$input}('company_email')->tab($tab);

        $this->crud->{$input}('current_address')->tab($tab);
        $this->crud->{$input}('home_address')->tab($tab);
        $this->crud->{$input}('house_no')->tab($tab);
        $this->crud->{$input}('street')->tab($tab);
        $this->crud->{$input}('brgy')->tab($tab);
        $this->crud->{$input}('city')->tab($tab);
        $this->crud->{$input}('province')->tab($tab);
        $this->crud->{$input}('zip_code')->tab($tab);



        $tab = 'Tin, Sss, Phil...';
        $this->crud->{$input}('tin')->tab($tab);
        $this->crud->{$input}('sss')->tab($tab);
        $this->crud->{$input}('philhealth')->tab($tab);
        $this->crud->{$input}('pagibig')->tab($tab);
    }

    protected function setupEmployeeFetchRoutes($segment, $routeName, $controller)
    {
        \Illuminate\Support\Facades\Route::post($segment . '/fetch', [
            'as' => $routeName . '.fetch',
            'uses' => $controller . '@fetch',
            'operation' => 'fetch',
        ]);
    }

    public function fetch()
    {
        $search_term = request()->input('q');
        $page = request()->input('page', 1); // Get the current page or default to 1
        $results = null;

        $query = \App\Models\Employee::select('id', 'first_name', 'last_name', 'middle_name'); // Base query

        if ($search_term) {
            $query->where(function ($query) use ($search_term) {
                $query->where('last_name', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('first_name', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('middle_name', 'LIKE', '%' . $search_term . '%');
            });
        }

        // Paginate the results
        $results = $query->paginate(5, ['*'], 'page', $page);


        return response()->json($results);
    }


}
