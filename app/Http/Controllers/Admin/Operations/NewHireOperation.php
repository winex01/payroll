<?php

namespace App\Http\Controllers\Admin\Operations;

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
            //          'target' => '_blank',
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
            // You logic goes here...
            // dd('got to ' . __METHOD__, $inputs, $entry);
            // TODO



            // show a success message
            \Alert::success('Something was done!')->flash();
        });
    }
}
