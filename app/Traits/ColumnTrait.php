<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Facades\HelperFacade;
use Illuminate\Support\Facades\Schema;

trait ColumnTrait
{
    public function column($name)
    {
        $this->crud->removeColumns([
            $name,
            str_replace('.', '__', $name)
        ]);

        // if $name has dot notation then we assume its a relationship
        if (str_contains($name, '.')) {
            return $this->crud->column([
                'name' => $name,
                'label' => HelperFacade::strToHumanReadable(explode('.', $name)[0]),
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $entity = explode('.', $column['entity']);
                    $joinTable = $this->crud->model->{$entity[0]}()->getModel()->getTable();

                    // check first if attribute or column exist in database table
                    if (Schema::hasColumn($joinTable, $column['attribute'])) {
                        $query->orWhereHas($entity[0], function ($q) use ($column, $searchTerm) {
                            $q->where($column['attribute'], 'like', '%' . $searchTerm . '%');
                        });
                    }
                },
                'orderable' => true,
                'orderLogic' => function ($query, $column, $columnDirection) {
                    $entity = explode('.', $column['entity']);
                    $joinTable = $this->crud->model->{$entity[0]}()->getModel()->getTable();
                    $modelTable = $this->crud->model->getTable();

                    debug($modelTable, $joinTable, $column);

                    // check first if attribute or column exist in database table
                    if (Schema::hasColumn($joinTable, $column['attribute'])) {
                        $query->leftJoin($joinTable, "$joinTable.id", '=', "$modelTable." . Str::snake($entity[0]) . "_id");
                        $query->orderBy("$joinTable.$entity[1]", $columnDirection)
                            ->select("$modelTable.*");
                    }

                    return $query;
                },
            ]);
        }

        $modelTable = $this->crud->model->getTable();
        $label = HelperFacade::strToHumanReadable($name);

        // check if column exist in db table, and db data type
        if (Schema::hasColumn($modelTable, $name)) {
            $type = Schema::getColumnType($modelTable, $name);

            // for now lets just assign if datatype is date and let auto otherwise.
            if ($type == 'date') {
                // TODO:: searchLogic and orderLogic
                return $this->crud->column($name)->label($label)->type('date');//->$type($type)
            }
        }

        return $this->crud->column($name)->label($label);
    }

    public function imageColumn($name)
    {
        $this->crud->removeColumn($name);
        return $this->crud->column([
            'name' => $name,
            'type' => 'image',
            'height' => ($this->crud->getOperation() == 'show') ? '100px' : '25px',
            'width' => ($this->crud->getOperation() == 'show') ? '100px' : '25px',
            'withFiles' => [
                'disk' => 'public',
                'path' => null,
            ],
            'orderable' => false,
        ])->makeFirst();
    }

    public function morphColumns($relationship, $table = null)
    {
        $this->morphColumnsFields($relationship, $table, 'column');
    }

    /*
    |--------------------------------------------------------------------------
    | Employee
    |--------------------------------------------------------------------------
    */
    public function employeeColumn($column = 'employee', $label = 'employee')
    {
        $this->crud->removeColumns([
            $column,
            str_replace('.', '__', $column)
        ]);

        return $this->crud->column([
            'name' => $column,
            'label' => __('Employee'),
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas($column['name'], function ($q) use ($searchTerm) {
                    $q->where('last_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('first_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('middle_name', 'like', '%' . $searchTerm . '%');
                });
            },
            'orderable' => true,
            'orderLogic' => function ($query, $tempCol, $columnDirection) use ($column) {
                $currentTable = $this->crud->model->getTable();
                $employeeTable = 'employees';
                $relationTable = null;

                if (str_contains($column, '.')) {
                    $columnParts = explode('.', $column); // Example: "relation.employee"
                    $relationTable = $this->crud->model->{$columnParts[0]}()->getModel()->getTable();

                    $query->leftJoin($relationTable, function ($join) use ($currentTable, $relationTable) {
                        $join->on("$relationTable.relationable_id", '=', "$currentTable.id")
                            ->where("$relationTable.relationable_type", '=', $this->crud->model::class);
                    });

                    $query->leftJoin($employeeTable, "$employeeTable.id", '=', "$relationTable.employee_id");
                } else {
                    $query->leftJoin($employeeTable, $employeeTable . '.id', '=', $currentTable . '.employee_id');
                }

                $query->orderBy("$employeeTable.last_name", $columnDirection)
                    ->orderBy("$employeeTable.first_name", $columnDirection)
                    ->orderBy("$employeeTable.middle_name", $columnDirection)
                    ->select("$currentTable.*");

                return $query;
            },
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('employee/' . $related_key . '/show');
                },
            ]
        ])->makeFirst();
    }
}
