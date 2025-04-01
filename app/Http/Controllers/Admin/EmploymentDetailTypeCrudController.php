<?php

namespace App\Http\Controllers\Admin;

use App\Traits\CoreTrait;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class EmploymentDetailTypeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    use CoreTrait;

    public function setup()
    {
        CRUD::setModel(\App\Models\EmploymentDetailType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employment-detail-type');
        CRUD::setEntityNameStrings('employment detail type', 'employment detail types');

        $this->userPermissions();

        $this->crud->query->orderBy('lft', 'asc');
    }

    protected function setupListOperation()
    {
        $this->column('name');
        $this->column('validation');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation($this->validateUnique('name'));

        $this->field('name');
        $this->field('validation')->validationRules('required');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        CRUD::set('reorder.label', 'name');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        CRUD::set('reorder.max_level', 1);

        // if you don't fully trust the input in your database, you can set
        // "escaped" to true, so that the label is escaped before being shown
        // you can also enable it globally in config/backpack/operations/reorder.php
        CRUD::set('reorder.escaped', true);
    }
}
