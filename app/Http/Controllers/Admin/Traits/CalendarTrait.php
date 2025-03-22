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

    public function dateRange($dateRange, $delimeter = '-')
    {
        $dateRange = explode($delimeter, $dateRange);

        return [
            Carbon::parse($dateRange[0])->toDateString(),
            Carbon::parse($dateRange[1])->toDateString(),
        ];
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

    public function calendarColor()
    {
        return [
            'employee_shift' => '#3a87ad',
            'change_shift' => '#42ba96',
            'regular_holiday' => '#9933cc',
            'special_holiday' => '#f88804',
            'double_holiday' => '#f3969a',
            'today' => '#fbf7e3',
            'white' => 'white',
        ];
    }
}
