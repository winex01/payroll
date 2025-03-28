<?php

namespace App\Http\Controllers\Admin\Operations;

use Illuminate\Support\Str;
use App\Models\EmploymentDetail;
use App\Models\EmploymentDetailType;
use App\Http\Requests\NewHireRequest;
use Backpack\CRUD\app\Http\Controllers\Operations\Concerns\HasForm;

trait NewHireOperation
{
    use HasForm;

    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupNewHireRoutes(string $segment, string $routeName, string $controller): void
    {
        $this->formRoutes(
            operationName: 'newHire',
            routesHaveIdSegment: false,
            segment: $segment,
            routeName: $routeName,
            controller: $controller
        );
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupNewHireDefaults(): void
    {
        $this->formDefaults(
            operationName: 'newHire',
            buttonStack: 'top', // alternatives: top, bottom
            // buttonMeta: [
            //     'icon' => 'la la-home',
            //     'label' => 'New Hire',
            //     'wrapper' => [
            //         'target' => '_blank',
            //         'class' => 'btn btn-primary'
            //     ],
            // ],
        );

        $this->crud->operation('newHire', function () {
            $this->crud->setValidation(NewHireRequest::class);
            $this->crud->field('employee');
            $this->employmentDetailTypes(hidden: false);
            $this->crud->field('effectivity_date');

        });
    }

    /**
     * Method to handle the GET request and display the View with a Backpack form
     *
     */
    public function getNewHireForm(): \Illuminate\Contracts\View\View
    {
        $this->crud->hasAccessOrFail('newHire');

        return $this->formView();
    }

    /**
     * Method to handle the POST request and perform the operation
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function postNewHireForm()
    {
        $this->crud->hasAccessOrFail('newHire');

        return $this->formAction(id: null, formLogic: function ($inputs, $entry) {
            $types = EmploymentDetailType::pluck('name', 'id');

            foreach ($types as $typeId => $type) {
                $fieldName = Str::snake($type);

                EmploymentDetail::firstOrCreate(
                    [
                        'employee_id' => $inputs['employee'],
                        'employment_detail_type_id' => $typeId,
                        'effectivity_date' => $inputs['effectivity_date'],
                        'value' => $inputs[$fieldName],
                    ]
                );
            }

            // show a success message
            \Alert::success(trans('backpack::crud.insert_success'))->flash();
        });
    }

    public function employmentDetailTypes($hidden = true)
    {
        $types = EmploymentDetailType::all();
        foreach ($types as $type) {
            $fieldName = Str::snake($type->name);
            $modifiedAttributes = [];

            // model/select
            if (str_contains($type->validation, 'exists')) {
                $model = $this->strToModelName($fieldName);
                $data = $model::all();

                $data = $data->mapWithKeys(function ($item) {
                    return [$item->id => $item->name];
                })->toArray();

                $modifiedAttributes = [
                    'type' => 'select_from_array',
                    'options' => $data,
                ];
            } elseif (str_contains($type->validation, 'date')) {
                $modifiedAttributes = [
                    'type' => 'date',
                ];
            } elseif (str_contains($type->validation, 'numeric')) {
                $modifiedAttributes = [
                    'type' => 'number',
                    'default' => 0,
                ];
            }

            $this->crud->field(
                array_merge(
                    [
                        'name' => $fieldName,
                        'wrapper' => [
                            'class' => 'form-group col-sm-6 mb-3 ' . ($hidden ? 'd-none' : ''),
                        ],
                    ],
                    $modifiedAttributes
                )
            )->after('employmentDetailType');
        }
    }
}
