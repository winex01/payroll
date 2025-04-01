<?php

namespace App\Http\Controllers\Admin;

use App\Traits\CoreTrait;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class PayrollGroupCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use CoreTrait;

    public function setup()
    {
        CRUD::setModel(\App\Models\PayrollGroup::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/payroll-group');
        CRUD::setEntityNameStrings('payroll group', 'payroll groups');

        $this->userPermissions();
    }

    protected function setupListOperation()
    {
        CRUD::setFromDb();
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation($this->validateUnique('name'));
        CRUD::setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
