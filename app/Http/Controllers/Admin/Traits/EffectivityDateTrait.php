<?php

namespace App\Http\Controllers\Admin\Traits;

use Illuminate\Support\Carbon;

trait EffectivityDateTrait
{
    // NOTE:: dont forget to add active scope in model.

    // CRUD controller access condition
    public function effectivityDatePermissions()
    {
        // only allow modify if effectivity_date >= today
        $this->crud->operation(['list', 'update', 'delete', 'show'], function () {
            $this->crud->setAccessCondition(['update', 'delete'], function ($entry) {
                $date = Carbon::parse($entry->effectivity_date)->startOfDay(); // Set time to midnight
                $today = now()->startOfDay(); // Set today’s date to midnight as well
                return $date >= $today;
            });
        });
    }

    // field
    public function historyFilter()
    {
        $this->crud->field([
            'name' => 'history',
            'type' => 'checkbox',
            'label' => 'Show All History',
        ]);
    }

    // field submit query
    public function historyQueriesFilter($query)
    {
        $history = request('history');
        if (!$history || $history == false || $history == 0) {
            // show only active records emp details in defaults
            $query->active();
        }
    }
}
