<?php

namespace App\Http\Controllers\Admin\Traits;

trait FilterTrait
{
    public function booleanQueriesFilter($query, $name)
    {
        $request = request($name);
        if ($request !== null) {
            $query->where($name, (bool) $request);
        }
    }
}
