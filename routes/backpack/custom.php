<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('employee', 'EmployeeCrudController');
    Route::crud('family', 'FamilyCrudController');
    Route::crud('company', 'CompanyCrudController');
    Route::crud('department', 'DepartmentCrudController');
    Route::crud('employment-detail', 'EmploymentDetailCrudController');
    Route::crud('employment-detail-type', 'EmploymentDetailTypeCrudController');
    Route::crud('payroll-group', 'PayrollGroupCrudController');
    Route::crud('shift-schedule', 'ShiftScheduleCrudController');
    Route::crud('employee-shift-schedule', 'EmployeeShiftScheduleCrudController');
    Route::crud('employee-calendar', 'EmployeeCalendarCrudController');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
