<?php

namespace App\Http\Controllers\Admin\FetchRoutes;

use App\Models\Employee;
use Illuminate\Support\Facades\Route;

trait SetupEmployeeFetchRoutes
{
    protected function setupEmployeeFetchRoutes($segment, $routeName, $controller)
    {
        Route::post($segment . '/fetch', [
            'as' => $routeName . '.fetch',
            'uses' => $controller . '@fetch',
            'operation' => 'fetch',
        ]);
    }

    public function fetch()
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
