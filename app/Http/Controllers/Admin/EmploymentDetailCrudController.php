<?php

namespace App\Http\Controllers\Admin;

use App\Facades\HelperFacade;
use App\Traits\CoreTrait;
use Illuminate\Support\Str;
use App\Models\EmploymentDetail;
use Illuminate\Support\Facades\App;
use App\Models\EmploymentDetailType;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\EmploymentDetailRequest;
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

    use CoreTrait;
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
        $this->datePermissions('effectivity_date');
    }

    public function setupFilterOperation()
    {
        $this->employeeFilter();
        $this->effectivityDateFilter();
        $this->field('employmentDetailType')->attribute('formatted_name')->size(4);
        $this->field('value')->type('hidden');

        foreach (EmploymentDetailType::all() as $type) {
            $tempModel = $this->strToModelName($type->name);
            if (class_exists($tempModel)) {
                $valueOptions = $tempModel::get()->pluck('name', 'id')->toArray();

                $this->crud->field([
                    'name' => Str::snake($type->name),
                    'label' => HelperFacade::strToHumanReadable($type->name),
                    'type' => 'select_from_array',
                    'options' => $valueOptions,
                    'wrapper' => [
                        'class' => 'form-group col-sm-4 mb-4 d-none ',
                    ],
                ])->after('employmentDetailType');
            }
        }

        $this->historyFilter();
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
            $this->employeeQueryFilter($query);

            $detailType = request('employmentDetailType');
            if ($detailType) {
                $query->where('employment_detail_type_id', $detailType);
            }

            foreach (EmploymentDetailType::all() as $type) {
                $fieldName = $type->name;
                $tempModel = $this->strToModelName($fieldName);
                if (class_exists($tempModel)) {
                    $request = request($fieldName);
                    if ($request) {
                        $query->where('value', $request);
                    }
                }
            }

            $this->historyQueriesFilter($query);
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

        $this->employeeColumn();
        $this->column('employmentDetailType')->attribute('formatted_name')->after('employee');

        $this->crud->modifyColumn('value', [
            'escaped' => false,
            'value' => function ($entry) {
                return $entry->formatted_value;
            },
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
        $this->crud->field('employmentDetailType')
            ->attribute('formatted_name')
            ->size(6)
            ->after('employee');
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
