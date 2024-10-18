<?php

namespace App\Http\Controllers\Admin\Traits;

use Backpack\CRUD\app\Library\Widget;

trait WidgetTrait
{
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
}
