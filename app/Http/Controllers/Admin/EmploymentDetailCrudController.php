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
        $this->field('employmentDetailType')->size(4);
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
                ]);
            }
        }

        $this->historyFilter();
    }

    public function filterQueries(\Closure $callback = null)
    {
        if (!$this->crud->hasAccess('filters')) {
            return;
        }

        // make sure to run only filterValidations on list and export operation,
        // because we put the filterQueries in setupListOperation and most of the time
        // we inherit all setupListOperaiton into our showOperation and cause error.,
        if (in_array($this->crud->getOperation(), ['list', 'export'])) {
            if ($this->filterValidations()) {
                if ($callback) {
                    $callback($this->crud->query);
                }
            }

            return redirect()->back()->withInput(request()->input());
        }
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

        $this->widgetBladeScript('crud::scripts.employment-detail');
        $this->crud->setDefaultPageLength(25);

        $currentTable = $this->crud->model->getTable();
        $detailsTypeTable = 'employment_detail_types';

        // default order on details type column, if sort is active wther asc/desc check button modify column orderLogic
        if (!CRUD::getRequest()->has('order')) {
            $this->crud->query->leftJoin($detailsTypeTable, $detailsTypeTable . '.id', '=', $currentTable . '.employment_detail_type_id')
                ->orderBy($detailsTypeTable . '.lft', 'asc')
                ->select($currentTable . '.*');
        }

        $this->employeeColumn();
        $this->column('employmentDetailType.name');
        $this->column('formatted_value')->label(__('Value'));
        $this->column('effectivity_date');
    }

    public function setupShowOperation()
    {
        $this->setupListOperation();
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

        $this->field('employee')->makeFirst();
        $this->field('employmentDetailType')->size(6);
        $this->field('value')->type('hidden');
        $this->employmentDetailTypes();
        $this->field('effectivity_date');
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
        $validator = Validator::make(request()->all(), [
            'employmentDetailType' => 'required|exists:employment_detail_types,id',
        ]);

        if ($validator->fails()) {
            \Alert::error($validator->errors()->all())->flash();
            return false;
        }

        $selectFields = [];
        $inputFields = [];
        foreach (EmploymentDetailType::pluck('name')->toArray() as $type) {
            $typeName = Str::snake($type);
            $tempModel = $this->strToModelName($typeName);
            if (class_exists($tempModel)) {
                $selectFields[] = $typeName;
            } else {
                $inputFields[] = $typeName;
                $inputFields[] = 'value';
            }
        }

        // selected employmentDetailType field
        $employmentDetailType = EmploymentDetailType::findOrFail(request('employmentDetailType'));
        $employmentDetailType = Str::snake($employmentDetailType->name);

        return response()->json(compact(
            'selectFields',
            'inputFields',
            'employmentDetailType',
        ));
    }
}
