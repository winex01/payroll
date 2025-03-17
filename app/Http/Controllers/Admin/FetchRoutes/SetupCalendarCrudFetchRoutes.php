<?php

namespace App\Http\Controllers\Admin\FetchRoutes;

use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use App\Models\EmployeeShiftSchedule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

trait SetupCalendarCrudFetchRoutes
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
        Route::post($segment . '/fetch-employee-shift', [
            'as' => $routeName . '.fetchEmployeeShift',
            'uses' => $controller . '@fetchEmployeeShift',
            'operation' => 'fetchEmployeeShift',
        ]);
    }

    public function fetchEmployeeShift()
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

        $results = [];

        $dateStart = Carbon::parse(request('date_start'));
        $dateEnd = Carbon::parse(request('date_end'));

        $periods = CarbonPeriod::create($dateStart, $dateEnd);

        foreach ($periods as $period) {
            $day = strtolower($period->format('l'));
            $date = $period->toDateString();

            $empShift = EmployeeShiftSchedule::
                where('employee_id', request('employee'))
                ->active($date)
                ->with($day)
                ->first();

            // Check if the shift exists before accessing its attributes
            if ($empShift && $empShift->{$day}) {
                $results[] = [
                    'id' => $date . '-employee-shift',
                    'title' => '• ' . $empShift->{$day}->name,
                    'start' => $date,
                    'url' => url(route('shift-schedule.show', $empShift->{$day}->id)),
                ];
            }
        }

        // TODO:: change shift
        // TODO:: leave
        // TODO:: holiday
        // TODO:: TBD: working history? or DTR? such as absent etc...
        return response()->json($results);
    }
}
