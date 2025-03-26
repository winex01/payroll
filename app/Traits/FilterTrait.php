<?php

namespace App\Traits;

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
