<?php

namespace App\Http\Controllers\Admin\Traits;

use Illuminate\Support\Carbon;

trait AdditionalPermissions
{
    // CRUD controller access condition
    public function datePermissions($attribute = 'date')
    {
        // Hide or show action buttons
        // only allow modify if effectivity_date >= today
        $this->crud->operation(['list', 'update', 'delete', 'show'], function () use ($attribute) {
            $this->crud->setAccessCondition(['update', 'delete'], function ($entry) use ($attribute) {
                $date = Carbon::parse($entry->{$attribute})->startOfDay(); // Set time to midnight
                $today = now()->startOfDay(); // Set today’s date to midnight as well
                return $date >= $today;
            });
        });
    }
}
