<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class EmploymentDetailsActiveScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Filter for records where effectivity_date is less than or equal to today
        $builder->where('effectivity_date', '<=', now()->toDateString());

        // Subquery to select the latest record for each employee_id and employment_detail_type_id
        $builder->whereIn('employment_details.id', function ($query) {
            $query->selectRaw('MAX(employment_details.id)') // Get the latest record (MAX(id)) for each combination
                ->from('employment_details')
                ->where('effectivity_date', '<=', now()->toDateString()) // Only consider records where effectivity_date <= today
                ->groupBy('employee_id', 'employment_detail_type_id'); // Group by employee_id and employment_detail_type_id
        });
    }
}
