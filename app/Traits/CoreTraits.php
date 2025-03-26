<?php

namespace App\Traits;

use Backpack\ReviseOperation\ReviseOperation;
use Winex01\BackpackPermissionManager\Http\Controllers\Traits\UserPermissions;

trait CoreTraits
{
    use FieldTrait;
    use FilterTrait;
    use HelperTrait;
    use UserPermissions;
    use ReviseOperation;
    use ValidationTrait;
    use Permissions;
}
