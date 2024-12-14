<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\Traits\TimeFormatTrait;

class ShiftSchedule extends Model
{
    use ModelTraits;
    use TimeFormatTrait;

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
        foreach ($this->working_hours as $wk) {
            if (!empty($wk)) {
                $start = $this->hourDisplayFormat($wk['start']);
                $end = $this->hourDisplayFormat($wk['end']);
                $value[] = $start . ' - ' . $end;
            }
        }

        return implode(",<br>", $value);
    }

    public function getDayStartDetailsAttribute()
    {
        if ($this->open_time) {
            return;
        }

        return $this->hourDisplayFormat($this->day_start);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
