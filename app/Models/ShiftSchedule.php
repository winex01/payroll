<?php

namespace App\Models;

use App\Traits\HelperTrait;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class ShiftSchedule extends Model
{
    use ModelTrait;
    use HelperTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'shift_schedules';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];

    protected $casts = [
        'working_hours' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function isRestDay()
    {
        if ($this->id == 1) {
            return true;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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
    public function getWorkingHoursDetailsAttribute()
    {
        if ($this->open_time) {
            return;
        }

        $value = [];

        if ($this->working_hours) {
            foreach ($this->working_hours as $wk) {
                if (!empty($wk)) {
                    $start = $this->hourDisplayFormat($wk['start']);
                    $end = $this->hourDisplayFormat($wk['end']);
                    $value[] = $start . ' - ' . $end;
                }
            }
        }

        return implode(",<br>", $value);
    }

    public function getDayStartDetailsAttribute()
    {
        if ($this->open_time) {
            return;
        }

        return $this->day_start;
    }

    public function getShiftPoliciesDetailsAttribute()
    {
        $enabledPolicies = [];
        foreach (['early_login_overtime', 'after_shift_overtime', 'night_differential', 'late', 'undertime',] as $policy) {
            if ($this->{$policy} == true) {
                $enabledPolicies[] = $this->strToHumanReadable($policy);
            }
        }

        return implode('<br>', $enabledPolicies);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
