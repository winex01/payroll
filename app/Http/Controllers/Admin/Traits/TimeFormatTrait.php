<?php

namespace App\Http\Controllers\Admin\Traits;

use Illuminate\Support\Carbon;

trait TimeFormatTrait
{

    public function hourDisplayFormat($hour)
    {
        return Carbon::create($hour)->format('h:i A'); // 12 hr AM/PM
    }
}
