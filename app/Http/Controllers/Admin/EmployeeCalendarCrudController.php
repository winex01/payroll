<?php

namespace App\Http\Controllers\Admin;

use App\Traits\CoreTrait;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Winex01\BackpackFilter\Http\Controllers\Operations\FilterOperation;

class EmployeeCalendarCrudController extends CrudController
{
    use \App\Http\Controllers\Admin\Operations\CalendarListOperation;

    use CoreTrait;
    use FilterOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\EmployeeCalendar::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee-calendar');
        CRUD::setEntityNameStrings('employee calendar', 'employee calendars');

        $this->userPermissions();
    }

    public function setupFilterOperation()
    {
        $this->employeeFilter()->size(3);
    }

    protected function setupListOperation()
    {
        $this->filterQueries(function ($query) {
            $this->employeeQueryFilter($query);
        });
    }
}
