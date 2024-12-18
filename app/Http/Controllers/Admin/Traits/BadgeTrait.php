<?php

namespace App\Http\Controllers\Admin\Traits;

trait BadgeTrait
{
    public function booleanBadge(bool $bool)
    {
        if ($bool) {
            return '<span class="badge badge-success bg-success">Yes</span>';
        }

        return '<span class="badge badge-danger bg-danger">No</span>';
    }
}
