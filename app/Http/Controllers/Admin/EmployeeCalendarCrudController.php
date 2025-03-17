<?php

namespace App\Http\Controllers\Admin;

use LaravelFullCalendar\Facades\Calendar;
use App\Http\Controllers\Admin\Traits\CoreTraits;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Winex01\BackpackFilter\Http\Controllers\Operations\FilterOperation;
use App\Http\Controllers\Admin\FetchRoutes\SetupCalendarCrudFetchRoutes;

/**
 * Class EmployeeCalendarCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCalendarCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;

    use CoreTraits;
    use FilterOperation;
    use SetupCalendarCrudFetchRoutes;

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

    public function setupFilterOperation()
    {
        $this->employeeRelationshipFilter();
    }

    protected function setupListOperation()
    {
        CRUD::setOperationSetting('searchableTable', false);

        $this->filterQueries(function ($query) {
            $this->employeeQueriesFilter($query);
        });
    }

    public function index()
    {
        $this->crud->hasAccessOrFail('list');

        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? mb_ucfirst($this->crud->entity_name_plural);

        $calendar = Calendar::setOptions([
            'header' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'month,basicWeek',
            ],
            'buttonText' => [
                'today' => 'Today',
                'month' => 'Month',
                'week' => 'Week',
            ],
            'selectable' => true,
        ]);

        if (request('employee')) {
            $calendar->setCallbacks([
                'events' => "function(start, end, timezone, successCallback, failureCallback) {
                    let dateStart = start.format('YYYY-MM-DD'); // Using moment.js formatting
                    let dateEnd = end.format('YYYY-MM-DD');

                    // console.log(dateStart);
                    // console.log(dateEnd);

                    $.ajax({
                        url: '" . route('employee-calendar.fetchEmployeeShift') . "',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            employee: '" . request('employee') . "',
                            date_start: dateStart,
                            date_end: dateEnd
                        },
                        success: function(response) {
                            successCallback(response);
                        },
                        error: function() {
                            failureCallback();
                        }
                    });
                }"
            ]);
        }

        $this->data['calendar'] = $calendar;

        // loast custom calendar view instead of default list.blade.php
        return view('crud::calendar', $this->data);
    }


}
