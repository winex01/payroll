<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\EmploymentDetailType;
use App\Http\Requests\EmploymentDetailRequest;
use App\Http\Controllers\Admin\Traits\CoreTraits;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EmploymentDetailCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmploymentDetailCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use CoreTraits;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\EmploymentDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employment-detail');
        CRUD::setEntityNameStrings('employment detail', 'employment details');

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
        CRUD::setFromDb();

        $this->crud->removeColumns([
            'employment_detail_type_id',
        ]);

        $this->employeeColumn();
        $this->crud->column('employmentDetailType')->after('employee');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->widgetBladeScript('crud::scripts.employment-detail');

        CRUD::setValidation(EmploymentDetailRequest::class);
        CRUD::setFromDb();

        $this->input('field');
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // register any Model Events defined on fields
        $this->crud->registerFieldEvents();


        $request = $this->crud->getStrippedSaveRequest($request);


        $type = EmploymentDetailType::findOrFail($request['employmentDetailType']);
        // dd($type);


        // insert item in the db
        $item = $this->crud->create($request);
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
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

    public function input($input = 'field')
    {
        $input = ucfirst($input);

        $this->crud->{'remove' . $input . 's'}([
            'employee_id',
            'employment_detail_type_id',
        ]);

        $this->crud->{$input}('employee')->makeFirst();
        $this->crud->{$input}('employmentDetailType')->size(6)->after('employee');
        $this->crud->field('value')->size(6);

        $valueInputs = EmploymentDetailType::pluck('name');

        foreach ($valueInputs as $valueInput) {
            $temp = $this->strToModelName($valueInput);
            if (class_exists($temp)) {
                $data = [];
                if (\Illuminate\Support\Facades\Schema::hasColumn((new $temp)->getTable(), 'name')) {
                    $data = $temp::pluck('name', 'id');
                } else {
                    $data = $temp::withName()->get()->pluck('name', 'id');
                }

                $this->crud->{$input}([
                    'name' => Str::snake($valueInput),
                    'label' => ucfirst(strtolower($valueInput)),
                    'type' => 'select_from_array',
                    'options' => $data,
                    'wrapper' => [
                        'class' => 'form-group col-sm-6 mb-3 d-none',
                    ]
                ])->after('employmentDetailType');
            }
        }
    }

    protected function setupCustomRoutes($segment, $routeName, $controller)
    {
        \Illuminate\Support\Facades\Route::post($segment . '/valueField', [
            'as' => $routeName . '.valueField',
            'uses' => $controller . '@valueField',
            'operation' => 'valueField',
        ]);
    }

    public function valueField()
    {
        $this->crud->hasAccessToAny(['create', 'update']);

        $inputType = EmploymentDetailType::find(request('id'));

        if (!$inputType) {
            return false;
        }

        $temp = $this->strToModelName($inputType->name);

        $isModel = false;
        $fieldName = $inputType->name;

        if (class_exists($temp)) {
            $isModel = true;
            $fieldName = Str::snake($fieldName);
        }

        $allFieldNames = EmploymentDetailType::pluck('name');

        // filter
        $allFieldNames = $allFieldNames->filter(function ($name) {
            return class_exists($this->strToModelName($name));
        });

        // Transform the names using map() first
        $allFieldNames = $allFieldNames->map(function ($name) {
            return Str::snake($name);
        });

        $allFieldNames->push('value'); // append

        return response()->json(compact('isModel', 'fieldName', 'allFieldNames'));
    }
}
