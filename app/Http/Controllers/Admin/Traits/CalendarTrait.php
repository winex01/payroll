<?php

namespace App\Http\Controllers\Admin\Traits;


trait CalendarTrait
{
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
