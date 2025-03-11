<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\CoreTraits;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EmployeeCalendarCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCalendarCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;

    use CoreTraits;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\EmployeeCalendar::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee-calendar');
        CRUD::setEntityNameStrings('employee calendar', 'employee calendars');

        $this->userPermissions();
    }

    public function index()
    {
        $this->crud->hasAccessOrFail('list');

        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? mb_ucfirst($this->crud->entity_name_plural);

        // loast custom calendar view instead of default list.blade.php
        return view('crud::calendar', $this->data);
    }
}
