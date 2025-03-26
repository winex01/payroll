<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Backpack\CRUD\app\Library\Widget;

trait HelperTrait
{
    public function numberToDecimals($value, $decimals = 2, $dec_point = '.', $thousands_sep = ',')
    {
        return number_format($value, $decimals, $dec_point, $thousands_sep);
    }

    public function strToHumanReadable($string, $capitalizeAllWords = false)
    {
        $snakeCase = Str::replace('_', ' ', Str::snake($string)); // Convert camelCase to snake_case and replace underscores

        return $capitalizeAllWords ? ucwords($snakeCase) : ucfirst($snakeCase); // Use ucwords() or ucfirst() based on the second parameter
    }

    public function strToModelName($string, $modelPath = 'App\Models\\')
    {
        return $modelPath . Str::studly($string);
    }

    public function hourDisplayFormat($hour)
    {
        return Carbon::create($hour)->format('h:i A'); // 12 hr AM/PM
    }

    public function widgetScript($path)
    {
        Widget::add()->type('script')->content(asset($path));
    }

    public function widgetBladeScript($path)
    {
        Widget::add()->type('view')->view($path); // crud::scripts.employee
    }

    public function widgetView($path)
    {
        Widget::add()->type('view')->content($path);
    }

    public function badgeBoolean(bool $bool)
    {
        if ($bool) {
            return '<span class="badge badge-success bg-success">Yes</span>';
        }

        return '<span class="badge badge-danger bg-danger">No</span>';
    }

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
