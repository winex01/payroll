<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Facades\HelperFacade;
use Illuminate\Support\Facades\Schema;
use Backpack\ReviseOperation\ReviseOperation;
use Winex01\BackpackPermissionManager\Http\Controllers\Traits\UserPermissions;

trait CoreTrait
{
    use FieldTrait;
    use FilterTrait;
    use HelperTrait;
    use ColumnTrait;
    use PermissionTrait;
    use UserPermissions;
    use ReviseOperation;
    use ValidationTrait;

    // TODO:: remove this, transfer to field and column trait.
    public function morphColumnsFields($relationship, $table = null, $type)
    {
        $table = $table ?? $this->crud->model->{$relationship}()->getModel()->getTable();

        $cols = Schema::getColumnListing($table);

        foreach ($cols as $col) {
            if (in_array($col, ['id', 'created_at', 'updated_at', 'deleted_at'])) {
                continue;
            }

            if (Str::endsWith($col, ['able_id', 'able_type'])) {
                continue;
            }

            $colType = Schema::getColumnType($table, $col);
            $col = str_replace('_id', '', $col);
            $name = $relationship . '.' . $col;
            $field = $this->crud->{$type}($name)->label(HelperFacade::strToHumanReadable($col));

            if ($colType == 'date') {
                $field->type('date');
            }
        }
    }
}
