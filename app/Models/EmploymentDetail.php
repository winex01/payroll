<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Scopes\Traits\EmployeeNotSoftDeletedScopeTrait;

class EmploymentDetail extends Model
{
    use ModelTraits;
    use EmployeeNotSoftDeletedScopeTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'employment_details';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function employmentDetailType()
    {
        return $this->belongsTo(EmploymentDetailType::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive(Builder $query): Builder
    {
        // Filter for records where effectivity_date is less than or equal to today
        $query->where('effectivity_date', '<=', now()->toDateString());

        // Subquery to select the latest record for each employee_id and employment_detail_type_id
        $query->whereIn('employment_details.id', function ($query) {
            $query->selectRaw('MAX(employment_details.id)') // Get the latest record (MAX(id)) for each combination
                ->from('employment_details')
                ->where('effectivity_date', '<=', now()->toDateString()) // Only consider records where effectivity_date <= today
                ->groupBy('employee_id', 'employment_detail_type_id'); // Group by employee_id and employment_detail_type_id
        });

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
