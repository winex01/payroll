<?php

namespace App\Http\Controllers\Admin\Traits;

use Backpack\ReviseOperation\ReviseOperation;
use Winex01\BackpackPermissionManager\Http\Controllers\Traits\UserPermissions;

trait CoreTraits
{
    use ReviseOperation;
    use UserPermissions;
    use StrTrait;
    use WidgetTrait;
    use EmployeeTrait;
}
