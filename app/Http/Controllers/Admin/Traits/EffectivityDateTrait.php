<?php

namespace App\Http\Controllers\Admin\Traits;

use Illuminate\Support\Carbon;

trait EffectivityDateTrait
{
    // field
    public function effectivityDateFilter()
    {
        $this->crud->field('effectivity_date')->label('Date')->type('date')->size(4);
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

    // NOTE:: dont forget to add active scope in model. if you use historyQueriesFilter method/function
    // field submit query
    public function historyQueriesFilter($query)
    {
        $history = request('history');
        $effectivityDate = request('effectivity_date');

        if ($history && $effectivityDate) {
            // no groupBy and only effectivity_date
            $query->whereDate('effectivity_date', '<=', $effectivityDate);
        } elseif ($effectivityDate) {
            // groupBy and using effectivity date filter
            $query->active($effectivityDate);
        } elseif ($history) {
            // no groupBy
            // do nothing / or no query / show all records
        } else {
            // groupBy and using current date
            $query->active();
        }
    }
}
