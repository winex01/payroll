<?php

namespace App\Http\Controllers\Admin\Traits;

use Backpack\ReviseOperation\ReviseOperation;
use App\Http\Requests\Traits\ValidateUniqueTrait;
use App\Http\Controllers\Admin\Traits\TimeFormatTrait;
use Winex01\BackpackPermissionManager\Http\Controllers\Traits\UserPermissions;

trait CoreTraits
{
    use ReviseOperation;
    use UserPermissions;
    use StrTrait;
    use NumberTrait;
    use TimeFormatTrait;
    use WidgetTrait;
    use EmployeeTrait;
    use ValidateUniqueTrait;
    use BadgeTrait;
}
