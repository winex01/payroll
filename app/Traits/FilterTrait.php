<?php

namespace App\Traits;

trait FilterTrait
{
    public function booleanQueriesFilter($query, $name)
    {
        $request = request($name);
        if ($request !== null) {
            $query->where($name, (bool) $request);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Effectivity Date Filter
    |--------------------------------------------------------------------------
    */

    public function effectivityDateFilter()
    {
        $this->crud->field('effectivity_date')
            ->type('date')
            ->size(4);
    }

    public function historyFilter()
    {
        $this->crud->field([
            'name' => 'history',
            'type' => 'checkbox',
            'label' => 'Show All History',
        ]);
    }

    // NOTE:: dont forget to add active scopeActive in model. if you use historyQueriesFilter method/function
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

    /*
    |--------------------------------------------------------------------------
    | Employee Filter
    |--------------------------------------------------------------------------
    */
    // TODO:: change parameters and use morphTo or relationship instead of name
    public function employeeFilter($name = 'employee')
    {
        return $this->crud->field($name)
            ->type('select_ajax')
            ->label(__('Employee'))
            ->size(4)
            ->data_source(route('employee.employeeFetch'));
    }

    public function employeeQueryFilter($query, $name = 'employee')
    {
        if ($name != 'employee' && str_contains($name, '.')) {
            $request = request($name);
            $nameParts = explode('.', $name);
            if ($request) {
                $query->whereHas($nameParts[0], function ($q) use ($name) {
                    $q->where('employee_id', request($name));
                });
            }
        } else {
            $request = request($name);
            if ($request) {
                $query->where('employee_id', $request);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship Filter
    |--------------------------------------------------------------------------
    */
    public function relationshipFilter($name = 'relationship')
    {
        return $this->crud->field($name)->label(__('Relationship'));
    }

    public function relationshipQueryFilter($query, $name = 'relationship')
    {
        if ($name != 'relationship' && str_contains($name, '.')) {
            $request = request($name);
            $nameParts = explode('.', $name);
            if ($request) {
                $query->whereHas($nameParts[0], function ($q) use ($name) {
                    $q->where('relationship_id', request($name));
                });
            }
        } else {
            $request = request($name);
            if ($request) {
                $query->where('relationship_id', $request);
            }
        }
    }

}
