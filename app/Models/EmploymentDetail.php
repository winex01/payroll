<?php

namespace App\Models;

use App\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Scopes\EmployeeNotSoftDeletedScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([EmployeeNotSoftDeletedScope::class])]
class EmploymentDetail extends Model
{
    use ModelTraits;

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
        if ($date === null) {
            $date = today()->toDateString();
        }

        return $query->whereRaw("
            employment_details.effectivity_date = (
                SELECT MAX(ed2.effectivity_date)
                FROM employment_details ed2
                WHERE ed2.employee_id = employment_details.employee_id
                AND ed2.employment_detail_type_id = employment_details.employment_detail_type_id
                AND ed2.effectivity_date <= ?
            )
        ", [$date]);
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
