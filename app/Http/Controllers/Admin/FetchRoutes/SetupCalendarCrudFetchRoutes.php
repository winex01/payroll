<?php

namespace App\Http\Controllers\Admin\FetchRoutes;

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
        $validator = Validator::make(request()->all(), [
            'employee' => 'nullable|exists:employees,id',
        ]);

        if ($validator->fails()) {
            return [];
        }

        $results = [];

        // events: [
        //     //{ id: '1', title: 'Employee Shift', start: '2025-03-10', color: '#0d6efd' },
        //     //{ id: '2', title: 'Change Shift', start: '2025-03-10', color: '#198754' },
        //     //{ id: '3', title: 'Leave', start: '2025-03-10', color: '#FF9900' },
        //     //{ id: '4', title: 'Absent', start: '2025-03-10', color: '#dc3545' },
        //     //{ id: '5', title: 'Regular Holiday', start: '2025-03-10', color: '#6c757d' },
        //     //{ id: '6', title: 'Special Holiday', start: '2025-03-10', color: '#9933cc' }
        // ],

        // TODO::
        // get employee shift schedule and create iteration

        $results[] = [
            'id' => 1,
            'title' => 'Employee Shift - empId: ' . request()->employee,
            'start' => '2025-03-10',
            'color' => '#0d6efd'
        ];

        $results[] = [
            'id' => 2,
            'title' => 'Change Shift',
            'start' => '2025-03-10',
            'color' => '#198754'
        ];

        return response()->json($results);
    }
}
