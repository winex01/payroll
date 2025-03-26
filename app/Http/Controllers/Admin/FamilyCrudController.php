<?php

namespace App\Http\Controllers\Admin;

use App\Traits\CoreTrait;
use App\Http\Requests\FamilyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Winex01\BackpackFilter\Http\Controllers\Operations\FilterOperation;

/**
 * Class FamilyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FamilyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use CoreTrait;
    use FilterOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Family::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/family');
        CRUD::setEntityNameStrings('family', 'families');

        $this->userPermissions();
    }

    public function setupFilterOperation()
    {
        // $this->employeeRelationshipFilter();
        // $this->crud->field('relationship');
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
            // $this->employeeQueriesFilter($query);

            // $relation = request('relationship');
            // if ($relation) {
            //     $query->where('relationship_id', $relation);
            // }
        });

        CRUD::setFromDb(false, true);
        // $this->crud->removeColumns($this->removeItems());
        // $this->employeeColumn();
        // $this->crud->column('relationship')->after('employee');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(FamilyRequest::class);
        CRUD::setFromDb();
        // $this->crud->removeFields($this->removeItems());
        // $this->crud->field('employee')->makeFirst();
        // $this->crud->field('relationship')->after('employee');

        //note comment_text is a text field in the comment table.
        // CRUD::field('relations')->subfields([
        //     ['name' => 'employee']
        // ]);

        // $this->crud->field('relations.employee');

        // $relation = Relation::getColumns();
        // TODO:: her na!!!!!!
        dd(
            \Illuminate\Support\Facades\Schema::getColumnListing('relations') // Replace 'employees' with your table name

        );
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

    public function setupShowOperation()
    {
        $this->setupListOperation();
    }

    public function removeItems()
    {
        return [
            'employee_id',
            'relationship_id',
        ];
    }
}
