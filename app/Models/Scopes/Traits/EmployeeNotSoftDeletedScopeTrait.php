<?php

namespace App\Models\Scopes\Traits;

use App\Models\Scopes\EmployeeNotSoftDeletedScope;

trait EmployeeNotSoftDeletedScopeTrait
{
    protected static function booted(): void
    {
        static::addGlobalScope(new EmployeeNotSoftDeletedScope);
    }
}
