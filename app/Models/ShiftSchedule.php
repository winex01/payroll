<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\Traits\BadgeTrait;
use App\Http\Controllers\Admin\Traits\TimeFormatTrait;

class ShiftSchedule extends Model
{
    use ModelTraits;
    use TimeFormatTrait;
    use BadgeTrait;

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

        return $this->day_start;
    }

    public function getShiftPoliciesDetailsAttribute()
    {
        $text = '';

        if (!$this->open_time) {
            $text .= $this->badgeBoolean($this->early_login_overtime) . ' - Early login overtime';
            $text .= '<br><div class="mb-1"></div>';
        }

        $text .= $this->badgeBoolean($this->after_shift_overtime) . ' - After shift overtime';
        $text .= '<br><div class="mb-1"></div>';
        $text .= $this->badgeBoolean($this->night_differential) . ' - Night differential';
        $text .= '<br>';

        return $text;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
