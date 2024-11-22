<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FamilyRequest;
use App\Http\Controllers\Admin\Traits\CoreTraits;
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

    use CoreTraits;
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
        $this->employeeRelationshipFilter();
        $this->crud->field('familyType');
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
            $this->employeeQueriesFilter($query);

            $familyType = request('familyType');
            if ($familyType) {
                $query->where('family_type_id', $familyType);
            }
        });

        CRUD::setFromDb(false, true);
        $this->input('column');
        $this->employeeColumn();

        $this->crud->modifyColumn('familyType', [
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas($column['name'], function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            },
            'orderable' => true,
            'orderLogic' => function ($query, $column, $columnDirection) {
                return $query
                    ->leftJoin('family_types', 'family_types.id', '=', 'families.family_type_id')
                    ->orderBy('family_types.name', $columnDirection)
                    ->select('families.*');
            },
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
        CRUD::setValidation(FamilyRequest::class);
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

    public function setupShowOperation()
    {
        $this->setupListOperation();
    }

    public function input($input = 'field')
    {
        $input = ucfirst($input);

        $this->crud->{'remove' . $input . 's'}([
            'employee_id',
            'family_type_id',
        ]);

        $this->crud->{$input}('employee')->before('last_name');
        $name = 'familyType';
        $this->crud->{$input}($name)->label($this->strToHumanReadable($name))->after('employee');
    }

}
