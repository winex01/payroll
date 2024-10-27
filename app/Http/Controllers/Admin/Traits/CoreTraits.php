<?php

namespace App\Http\Controllers\Admin\Traits;

use Backpack\ReviseOperation\ReviseOperation;
use App\Http\Requests\Traits\ValidateUniqueTrait;
use Winex01\BackpackPermissionManager\Http\Controllers\Traits\UserPermissions;

trait CoreTraits
{
    use ReviseOperation;
    use UserPermissions;
    use StrTrait;
    use NumberTrait;
    use WidgetTrait;
    use EmployeeTrait;
    use ValidateUniqueTrait;
}
