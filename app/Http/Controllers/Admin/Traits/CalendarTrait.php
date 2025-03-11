<?php

namespace App\Http\Controllers\Admin\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;


trait CalendarTrait
{
    public function dateFormat($date)
    {
        // if you want to change the date format, dont change this! but instead change the config.backpack.ui
        return Carbon::parse($date)
            ->locale(App::getLocale())
            ->isoFormat(config('backpack.ui.default_date_format'));
    }

    public function daysOfWeek()
    {
        return [
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday',
        ];
    }
}
