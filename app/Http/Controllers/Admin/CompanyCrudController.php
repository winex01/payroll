<?php

namespace App\Http\Controllers\Admin;

use App\Traits\CoreTrait;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class CompanyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use CoreTrait;

    public function setup()
    {
        CRUD::setModel(\App\Models\Company::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/company');
        CRUD::setEntityNameStrings('company', 'companies');

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

        $this->crud->modifyField('bir_rdo', [
            'hint' => 'Enter BIR revenue district office code.'
        ]);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
