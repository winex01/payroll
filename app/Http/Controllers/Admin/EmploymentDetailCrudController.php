<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\EmploymentDetail;
use App\Models\EmploymentDetailType;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\EmploymentDetailRequest;
use App\Http\Controllers\Admin\Traits\CoreTraits;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Winex01\BackpackFilter\Http\Controllers\Operations\FilterOperation;

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
    use \App\Http\Controllers\Admin\Operations\NewHireOperation;

    use CoreTraits;
    use FilterOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(EmploymentDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employment-detail');
        CRUD::setEntityNameStrings('employment detail', 'employment details');

        $this->userPermissions();

        // only allow modify if effectivity_date >= today
        $this->crud->operation(['list', 'update', 'delete', 'show'], function () {
            $this->crud->setAccessCondition(['update', 'delete'], function ($entry) {
                $date = Carbon::parse($entry->effectivity_date)->startOfDay(); // Set time to midnight
                $today = now()->startOfDay(); // Set today’s date to midnight as well
                return $date >= $today;
            });
        });
    }

    public function setupFilterOperation()
    {
        $this->employeeRelationshipFilter();
        $this->crud->field('employmentDetailType')->size(4);

        $valueOptions = [];

        if (request('employmentDetailType') && request('value')) {
            $type = EmploymentDetailType::find(request('employmentDetailType'));
            if ($type) {
                $tempModel = $this->strToModelName($type->name);
                if (class_exists($tempModel)) {
                    $valueOptions = $tempModel::get()->pluck('name', 'id')->toArray();
                }
            }
        }

        // i added this, to trick the validation from package so it wont fired the invalid bec. it check the value from options in
        // select from array if not exist then it will return failed validation, so we added it here instead of overriding the
        // package validation. check blade file if you want to see the selected option event employment-detal.blade.php
        $valueOptions = array_merge(['0' => '-'], $valueOptions); // append

        $this->crud->field([
            'name' => 'value',
            'type' => 'select_from_array',
            'options' => $valueOptions,
            'wrapper' => [
                'class' => 'form-group col-sm-4 mb-3 d-none',
            ],
        ]);

        $this->crud->field([
            'name' => 'history',
            'type' => 'checkbox',
            'label' => 'Show All History',
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->setDefaultPageLength(25);

        $this->widgetBladeScript('crud::scripts.employment-detail');

        $this->filterQueries(function ($query) {
            $this->employeeQueriesFilter($query);

            $type = request('employmentDetailType');
            if ($type) {
                $query->where('employment_detail_type_id', $type);
            }

            $value = request('value');
            if ($value && $value != 0) {
                $query->where('value', $value);
            }

            $history = request('history');
            if (!$history || $history == false || $history == 0) {
                // show only active records emp details in defaults
                $query->active();
            }
        });

        CRUD::setFromDb(false, true);

        $currentTable = $this->crud->model->getTable();
        $detailsTypeTable = 'employment_detail_types';

        // default order on details type column, if sort is active wther asc/desc check button modify column orderLogic
        if (!CRUD::getRequest()->has('order')) {
            $this->crud->query->leftJoin($detailsTypeTable, $detailsTypeTable . '.id', '=', $currentTable . '.employment_detail_type_id')
                ->orderBy($detailsTypeTable . '.lft', 'asc')
                ->select($currentTable . '.*');
        }

        $this->crud->removeColumns(['employment_detail_type_id']);

        $this->employeeColumn();
        $this->crud->column('employmentDetailType')->label('Employment detail type.')->after('employee');

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

        // details type column
        $this->crud->modifyColumn('employmentDetailType', [
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas($column['name'], function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            },

            'orderable' => true,
            'orderLogic' => function ($query, $column, $columnDirection) use ($currentTable, $detailsTypeTable) {
                return $query
                    ->leftJoin($detailsTypeTable, $detailsTypeTable . '.id', '=', $currentTable . '.employment_detail_type_id')
                    ->orderBy($detailsTypeTable . '.name', $columnDirection)
                    ->select($currentTable . '.*');
            },
        ]);
    }

    public function setupShowOperation()
    {
        $this->setupListOperation();
        $this->crud->removeColumn('employee_id');
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

        $this->crud->removeFields(['employee_id', 'employment_detail_type_id']);

        $this->crud->field('employee')->makeFirst();
        $this->crud->field('employmentDetailType')->size(6)->after('employee');
        $this->crud->field('value')->type('hidden');

        $this->employmentDetailTypes();
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

    protected function setupCustomRoutes($segment, $routeName, $controller)
    {
        Route::post($segment . '/valueField', [
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
        $fieldNameHumanReadable = $this->strToHumanReadable($inputType->name);

        $types = EmploymentDetailType::all();

        $allFieldNames = [];
        foreach ($types as $type) {
            $allFieldNames[] = Str::snake($type->name);
        }

        $allFieldNames[] = 'value';
        $temp = null;

        // use in list opt, filters.
        $selectOptions = null;
        $tempModel = $this->strToModelName($fieldName);
        if (class_exists($tempModel)) {
            $selectOptions = $tempModel::all();
        }

        return response()->json(
            compact(
                'temp',
                'fieldName',
                'fieldNameHumanReadable',
                'allFieldNames',
                'selectOptions'
            )
        );
    }
}
