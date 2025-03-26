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
    public function employeeRelationshipFilter()
    {
        return $this->crud->field('employee')
            ->type('select_ajax')
            ->size(4)
            ->data_source(route('employee.employeeFetch'));
    }

    public function employeeQueriesFilter($query)
    {
        $employee = request('employee');
        if ($employee) {
            $query->where('employee_id', $employee);
        }
    }
}
