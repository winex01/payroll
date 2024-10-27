<?php

namespace App\Http\Controllers\Admin\Traits;

trait NumberTrait
{
    public function numberToDecimals($value, $decimals = 2, $dec_point = '.', $thousands_sep = ',')
    {
        return number_format($value, $decimals, $dec_point, $thousands_sep);
    }
}
