<?php

namespace App\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait CalendarOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupCalendarRoutes($segment, $routeName, $controller)
    {
        Route::get($segment . '/{id}/calendar', [
            'as' => $routeName . '.calendar',
            'uses' => $controller . '@calendar',
            'operation' => 'calendar',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupCalendarDefaults()
    {
        CRUD::allowAccess('calendar');

        CRUD::operation('calendar', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            CRUD::addButton('line', 'calendar', 'view', 'crud::buttons.calendar', 'beginning');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function calendar($id)
    {
        CRUD::hasAccessOrFail('calendar');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Calendar ' . $this->crud->entity_name;

        // load the view
        return view('crud::operations.calendar', $this->data);
    }
}
