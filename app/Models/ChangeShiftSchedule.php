<?php

namespace App\Models;

use App\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\EmployeeNotSoftDeletedScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([EmployeeNotSoftDeletedScope::class])]
class ChangeShiftSchedule extends Model
{
    use ModelTraits;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'change_shift_schedules';
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

    public function shiftSchedule()
    {
        return $this->belongsTo(ShiftSchedule::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

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
