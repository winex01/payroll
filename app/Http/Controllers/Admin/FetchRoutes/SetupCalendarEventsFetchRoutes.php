<?php

namespace App\Http\Controllers\Admin\FetchRoutes;

use App\Models\ChangeShiftSchedule;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use App\Models\EmployeeShiftSchedule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use LaravelFullCalendar\Facades\Calendar;

trait SetupCalendarEventsFetchRoutes
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupCalendarCrudFetchRoutes($segment, $routeName, $controller)
    {
        Route::post($segment . '/fetch-calendar-events', [
            'as' => $routeName . '.fetchCalendarEvents',
            'uses' => $controller . '@fetchCalendarEvents',
            'operation' => 'fetchCalendarEvents',
        ]);
    }

    public function fetchCalendarEvents()
    {
        // NOTE:: this validation is different from the filter but its the validation from the ajax request.
        $validator = Validator::make(request()->all(), [
            'employee' => 'nullable|exists:employees,id',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
        ]);

        // if validation fail then return empty or nothing / calendar empty
        if ($validator->fails()) {
            return [];
        }

        $dateStart = Carbon::parse(request('date_start'));
        $dateEnd = Carbon::parse(request('date_end'));
        $periods = CarbonPeriod::create($dateStart, $dateEnd);

        $events = [];
        foreach ($periods as $period) {
            $day = strtolower($period->format('l'));
            $date = $period->toDateString();
            $events = array_merge($events, $this->employeeShiftEvents($date, $day));
            $events = array_merge($events, $this->changeShiftEvents($date));

            // TODO:: leave
            // TODO:: holiday
            // TODO:: TBD: working history? or DTR? such as absent etc...
        }

        return response()->json($events);
    }

    public function changeShiftEvents($date)
    {
        $events = [];
        $changeShift = ChangeShiftSchedule::
            where('employee_id', request('employee'))
            ->whereDate('date', $date)
            ->first();

        if ($changeShift) {
            if ($changeShift->shiftSchedule) {
                $shift = $changeShift->shiftSchedule;

                // change shift
                $events[] = [
                    'title' => ' • ' . $shift->name,
                    'start' => $date,
                    'color' => $this->calendarColor()['change_shift'],
                    'url' => $this->crud->hasAccess('show') ? url(route('shift-schedule.show', $shift->id)) : null,
                ];

                // change shift working hours
                $events[] = [
                    'title' => " Working Hours:\n" . str_replace('<br>', "\n", $shift->working_hours_details),
                    'start' => $date,
                    'textColor' => 'black',
                    'color' => date('Y-m-d') == $date ? $this->calendarColor()['today'] : $this->calendarColor()['white']
                ];

            } else {
                // null
                $events[] = [
                    'title' => '  • None',
                    'start' => $date,
                    'color' => $this->calendarColor()['change_shift'],
                ];

                $events[] = [
                    'title' => " Working Hours:\n\n\n",
                    'start' => $date,
                    'textColor' => 'black',
                    'color' => date('Y-m-d') == $date ? $this->calendarColor()['today'] : $this->calendarColor()['white']
                ];
            }

        }

        return $events;
    }

    public function employeeShiftEvents($date, $day)
    {
        $events = [];
        $empShift = EmployeeShiftSchedule::
            where('employee_id', request('employee'))
            ->active($date)
            ->with($day)
            ->first();

        // Check if the shift exists before accessing its attributes
        if ($empShift && $empShift->{$day}) {
            $shift = $empShift->{$day};

            // emp shift
            $events[] = [
                'title' => '• ' . $shift->name,
                'start' => $date,
                'color' => $this->calendarColor()['employee_shift'],
                'url' => $this->crud->hasAccess('show') ? url(route('shift-schedule.show', $shift->id)) : null,
            ];

            // working hours
            $events[] = [
                'title' => "Working Hours:\n" . str_replace('<br>', "\n", $shift->working_hours_details),
                'start' => $date,
                'textColor' => 'black',
                'color' => date('Y-m-d') == $date ? $this->calendarColor()['today'] : $this->calendarColor()['white']
            ];
        }

        return $events;
    }

    public function setCalendar()
    {
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
            'eventLimit' => true, //3, // x more link - limit
        ]);

        if (request('employee')) {
            $calendar->setCallbacks([
                'events' => "function(start, end, timezone, successCallback, failureCallback) {
                    let dateStart = start.format('YYYY-MM-DD'); // Using moment.js formatting
                    let dateEnd = end.format('YYYY-MM-DD');

                    $.ajax({
                        url: '" . route('employee-calendar.fetchCalendarEvents') . "',
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

        return $calendar;
    }
}
