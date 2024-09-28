<?php

namespace App\Http\Controllers\Admin\Traits;

use Backpack\CRUD\app\Library\Widget;

trait Script
{
    public function script($path)
    {
        Widget::add()->type('script')->content(asset($path));
    }
}
