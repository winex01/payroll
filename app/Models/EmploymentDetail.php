<?php

namespace App\Models;

use App\Traits\ModelTrait;
use App\Facades\HelperFacade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Models\Scopes\EmployeeNotSoftDeletedScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([EmployeeNotSoftDeletedScope::class])]
class EmploymentDetail extends Model
{
    use ModelTrait;

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
    public function getFormattedValueAttribute()
    {
        $model = HelperFacade::strToModelName($this->employmentDetailType->name);
        if (class_exists($model)) {
            $value = $model::find($this->value)->name;

            if ($value) {
                return $value;
            }
        }

        $value = $this->value;

        if (is_numeric($value)) {
            return HelperFacade::numberToDecimals($value);
        }

        $validator = Validator::make(['date' => $value], [
            'date' => 'required|date',
        ]);

        if ($validator->passes()) {
            $value = HelperFacade::dateFormat($value);
        }

        return $value;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
