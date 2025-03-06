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
    public function scopeActive(Builder $query, $date = null): Builder
    {
        if ($date == null) {
            $date = now()->toDateString();
        }

        $query->whereIn('employment_details.id', function ($query) use ($date) {
            $query->selectRaw('MAX(employment_details.id)') // Get the latest record (MAX(id)) for each combination
                ->from('employment_details')
                ->where('effectivity_date', '<=', $date) // Only consider records where effectivity_date <= today
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
