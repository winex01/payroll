<?php

namespace App\Http\Controllers\Admin\Traits;

use Winex01\BackpackPermissionManager\Http\Controllers\Traits\UserPermissions;

trait CoreTraits
{
    use UserPermissions;
    use WidgetTrait;
    use EmployeeTrait;
}