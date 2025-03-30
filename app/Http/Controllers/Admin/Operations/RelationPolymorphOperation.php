<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Traits\CoreTrait;
use App\Http\Requests\RelationRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Winex01\BackpackFilter\Http\Controllers\Operations\FilterOperation;

trait RelationPolymorphOperation
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use CoreTrait;
    use FilterOperation;

    public function setupFilterOperation()
    {
        $this->employeeFilter('relation.employee');
        $this->field('relation.relationship');
    }

    protected function setupListOperation()
    {
        $this->filterQueries(function ($query) {
            $this->employeeQueryFilter($query, 'relation.employee');
            $this->relationshipQueryFilter($query, 'relation.relationship');
        });

        $this->morphColumns('relation');
        $this->employeeColumn('relation.employee');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(RelationRequest::class);
        $this->morphFields('relation');
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
