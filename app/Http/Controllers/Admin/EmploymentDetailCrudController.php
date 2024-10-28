<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\EmploymentDetailType;
use Illuminate\Support\Facades\Schema;
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

        $this->crud->modifyColumn('value', [
            'type' => 'closure',
            'function' => function ($entry) {
                $model = $this->strToModelName($entry->employmentDetailType->name);
                if (class_exists($model)) {
                    $value = $model::find($entry->value)->name;

                    if ($value) {
                        return $value;
                    }
                }

                $value = $entry->value;

                if (is_numeric($value)) {
                    return $this->numberToDecimals($value);
                }

                return $value;
            },
            'escaped' => false,
        ]);
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
        $this->crud->field('value')->type('hidden');

        $types = EmploymentDetailType::all();

        foreach ($types as $type) {
            $fieldName = Str::snake($type->name);
            $this->crud->{$input}([
                'name' => $fieldName,
                'wrapper' => [
                    'class' => 'form-group col-sm-6 mb-3 d-none',
                ]
            ])->after('employmentDetailType');

            $modifiedAttributes = [];

            // model/select
            if (str_contains($type->validation, 'exists')) {
                $data = [];
                $model = $this->strToModelName($fieldName);

                // if model has column name
                if (Schema::hasColumn((new $model)->getTable(), 'name')) {
                    $data = $model::pluck('name', 'id');
                } else {
                    // if model has no column name, then create custom attr name and use local scope, check DaysPerYear model
                    $data = $model::withName()->get()->pluck('name', 'id');
                }

                $modifiedAttributes = [
                    'type' => 'select_from_array',
                    'options' => $data,
                ];

            } elseif (str_contains($type->validation, 'date')) {
                $modifiedAttributes = [
                    'type' => 'date',
                ];
            } elseif (str_contains($type->validation, 'numeric')) {
                $modifiedAttributes = [
                    'type' => 'number',
                ];
            }

            $this->crud->{"modify" . ucfirst($input)}($fieldName, $modifiedAttributes);
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

        $fieldName = Str::snake($inputType->name);

        $types = EmploymentDetailType::all();

        $allFieldNames = [];
        foreach ($types as $type) {
            $allFieldNames[] = Str::snake($type->name);
        }

        $allFieldNames[] = 'value';

        return response()->json(compact('fieldName', 'allFieldNames'));
    }
}
