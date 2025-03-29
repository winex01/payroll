<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Facades\HelperFacade;
use Illuminate\Support\Facades\Schema;

trait ColumnTrait
{
    public function column($name)
    {
        $nameParts = explode('.', $name);

        $this->crud->removeColumns([
            $name,
            str_replace('.', '__', $name),
            Str::snake($nameParts[0]) . '_id',
        ]);

        $limit = 999;

        // if $name has dot notation then we assume its a relationship
        if (str_contains($name, '.')) {
            return $this->crud->column([
                'name' => $name,
                'label' => HelperFacade::strToHumanReadable(explode('.', $name)[0]),
                'limit' => $limit,
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
        $label = HelperFacade::strToHumanReadable(str_replace('_details', '', $name));

        // check if column exist in db table, and db data type
        if (Schema::hasColumn($modelTable, $name)) {
            $type = Schema::getColumnType($modelTable, $name);

            // for now lets just assign if datatype is date and let auto otherwise.
            if ($type == 'date') {
                // TODO:: searchLogic and orderLogic
                return $this->crud->column($name)->label($label)->type('date')->limit($limit);//->$type($type)
            }
        }

        return $this->crud->column($name)->label($label)->limit($limit);
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
    public function employeeColumn($name = 'employee', $label = 'employee')
    {
        $this->crud->removeColumns([
            $name,
            str_replace('.', '__', $name),
            Str::snake($name) . '_id',
        ]);

        return $this->crud->column([
            'name' => $name,
            'label' => __('Employee'),
            'searchLogic' => function ($query, $column, $searchTerm) {
                // we use $column['entity'] in orWhereHas bec. there are only 2 posibilities we use this,
                // but normally we ue orWhereHas($nameParts[0]) or explode the name using dot notation and
                // take the 0 element array.
                // 1. employee
                // 2. relation.employee (polymorph etc..)
                $query->orWhereHas($column['entity'], function ($q) use ($searchTerm) {
                    $q->where('last_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('first_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('middle_name', 'like', '%' . $searchTerm . '%');
                });
            },
            'orderable' => true,
            'orderLogic' => function ($query, $column, $columnDirection) {
                $modelTable = $this->crud->model->getTable();
                $relationTable = null;

                // if name has dot or . notation we assume its a polyrmorph
                if (str_contains($column['name'], '.')) {
                    $columnParts = explode('.', $column['entity']);
                    $relationTable = $this->crud->model->{$columnParts[0]}()->getModel()->getTable();

                    // join the polymorph
                    $query->leftJoin($relationTable, function ($join) use ($modelTable, $relationTable) {
                        $join->on("$relationTable.relationable_id", '=', "$modelTable.id")
                            ->where("$relationTable.relationable_type", '=', $this->crud->model::class);
                    });

                    $query->leftJoin("employees", "employees.id", '=', "$relationTable.employee_id");
                } else {
                    $query->leftJoin("employees", "employees.id", '=', $modelTable . '.employee_id');
                }

                $query->orderBy("employees.last_name", $columnDirection)
                    ->orderBy("employees.first_name", $columnDirection)
                    ->orderBy("employees.middle_name", $columnDirection)
                    ->select("$modelTable.*");

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
