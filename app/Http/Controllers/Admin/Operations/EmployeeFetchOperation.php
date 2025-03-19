<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\Employee;
use Illuminate\Support\Facades\Route;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

trait EmployeeFetchOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupEmployeeFetchRoutes($segment, $routeName, $controller)
    {
        Route::post($segment . '/employee-fetch', [
            'as' => $routeName . '.employeeFetch',
            'uses' => $controller . '@employeeFetch',
            'operation' => 'employeeFetch',
        ]);
    }

    public function employeeFetch()
    {
        $search_term = request()->input('q');
        $page = request()->input('page', 1); // Get the current page or default to 1
        $results = null;

        $query = Employee::select('id', 'first_name', 'last_name', 'middle_name'); // Base query

        if ($search_term) {
            $query->where(function ($query) use ($search_term) {
                $query->where('last_name', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('first_name', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('middle_name', 'LIKE', '%' . $search_term . '%');
            });
        }

        // Paginate the results
        $results = $query->paginate(5, ['*'], 'page', $page);

        return response()->json($results);
    }
}
