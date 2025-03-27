<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait PermissionTrait
{
    // CRUD controller access condition
    public function datePermissions($attribute = 'date')
    {
        // Hide or show action buttons
        // only allow modify if effectivity_date >= today
        $this->crud->operation(['list', 'update', 'delete', 'show'], function () use ($attribute) {
            $this->crud->setAccessCondition(['update', 'delete'], function ($entry) use ($attribute) {
                // allow if auth user has table_backdting permission
                if ($this->crud->hasAccess('backdating')) {
                    return true;
                }

                $date = Carbon::parse($entry->{$attribute})->startOfDay(); // Set time to midnight
                $today = now()->startOfDay(); // Set today’s date to midnight as well
                return $date >= $today;
            });
        });
    }

    public function ignoreIdPermissions($ids)
    {
        $ids = is_array($ids) ? $ids : [$ids]; // Ensure $ids is always an array

        $this->crud->operation(['list', 'update', 'delete', 'show'], function () use ($ids) {
            $this->crud->setAccessCondition(['update', 'delete'], function ($entry) use ($ids) {
                return !in_array($entry->id, $ids);
            });
        });
    }

}
