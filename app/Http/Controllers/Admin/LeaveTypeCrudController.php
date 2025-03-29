<?php

namespace App\Http\Controllers\Admin;

use App\Traits\CoreTrait;
use App\Http\Requests\LeaveTypeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Winex01\BackpackFilter\Http\Controllers\Operations\FilterOperation;

class LeaveTypeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use CoreTrait;
    use FilterOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\LeaveType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/leave-type');
        CRUD::setEntityNameStrings('leave type', 'leave types');

        $this->userPermissions();
    }

    public function setupFilterOperation()
    {
        $this->booleanFilter('with_pay');
    }

    protected function setupListOperation()
    {
        $this->filterQueries(function ($query) {
            $this->booleanQueriesFilter($query, 'with_pay');
        });

        CRUD::setFromDb(false, true);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(LeaveTypeRequest::class);
        CRUD::setFromDb();
        $this->booleanField('with_pay');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function setupShowOperation()
    {
        $this->setupListOperation();
    }
}
