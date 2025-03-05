<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Scopes\Traits\EmployeeNotSoftDeletedScopeTrait;

class EmployeeShiftSchedule extends Model
{
    use ModelTraits;
    use EmployeeNotSoftDeletedScopeTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'employee_shift_schedules';
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

    public function monday()
    {
        return $this->belongsTo(ShiftSchedule::class, 'monday_id');
    }

    public function tuesday()
    {
        return $this->belongsTo(ShiftSchedule::class, 'tuesday_id');
    }

    public function wednesday()
    {
        return $this->belongsTo(ShiftSchedule::class, 'wednesday_id');
    }

    public function thursday()
    {
        return $this->belongsTo(ShiftSchedule::class, 'thursday_id');
    }

    public function friday()
    {
        return $this->belongsTo(ShiftSchedule::class, 'friday_id');
    }

    public function saturday()
    {
        return $this->belongsTo(ShiftSchedule::class, 'saturday_id');
    }

    public function sunday()
    {
        return $this->belongsTo(ShiftSchedule::class, 'sunday_id');
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

        $query->whereIn('employee_shift_schedules.id', function ($query) use ($date) {
            $query->selectRaw('MAX(employee_shift_schedules.id)') // Get the latest record (MAX(id)) for each combination
                ->from('employee_shift_schedules')
                ->where('effectivity_date', '<=', $date) // Only consider records where effectivity_date <= today
                ->groupBy('employee_id'); // Group by employee_id
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
