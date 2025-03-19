@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.list') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none" bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</h1>
        <p class="ms-2 ml-2 mb-0" id="datatable_info_stack" bp-section="page-subheading">{!! $crud->getSubheading() ?? '' !!}</p>
    </section>
@endsection

@section('content')
  {{-- Default box --}}
  <div class="row" bp-section="crud-operation-list">

    {{-- THE ACTUAL CONTENT --}}
    <div class="{{ $crud->getListContentClass() }}">

        <div class="row mb-2 align-items-center">
          <div class="col-sm-12">
            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
              <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">

                @include('crud::inc.button_stack', ['stack' => 'top'])

              </div>
            @endif
          </div>
        </div>

        {{-- Backpack List Filters --}}
        @if ($crud->filtersEnabled())
          @include('crud::inc.filters_navbar')
        @endif

        <div class="card">
            <div class="row" style="margin-left: 12px;">
                <ul class="custom-legend mt-2">
                    <li><span class="custom-employee-shift"></span> Employee Shift</li>
                    <li><span class="custom-change-shift"></span> Change Shift</li>
                    <li><span class="custom-regular-holiday"></span> Regular Holiday</li>
                    <li><span class="custom-special-holiday"></span> Special Holiday</li>
                    <li><span class="custom-double-holiday"></span> Double Holiday</li>
                </ul>
            </div>

            <ul class="mt-2" style="margin-left: 4px;">
                @if ($crud->hasAccess('clickAndSelect'))
                    <li>Click or drag select date to change shift schedule.</li>
                @endif
            </ul>

            <div class="row m-1">
                {!! $calendar->calendar() !!}
            </div>
        </div>


        @if ( $crud->buttons()->where('stack', 'bottom')->count() )
            <div id="bottom_buttons" class="d-print-none text-sm-left">
                @include('crud::inc.button_stack', ['stack' => 'bottom'])
                <div id="datatable_button_stack" class="float-right float-end text-right hidden-xs"></div>
            </div>
        @endif

    </div>

  </div>

@endsection

@section('after_styles')
  {{-- CRUD LIST CONTENT - crud_list_styles stack --}}
  <link href="{{ asset('packages/fullcalendar/3.10.2/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />

  <style type="text/css">
    .custom-legend {
        list-style: none; /* Remove default bullets */
        display: flex; /* Make list horizontal */
        flex-wrap: wrap; /* Allow wrapping */
        gap: 15px; /* Space between items */
        padding: 0;
        margin: 0;
    }

    .custom-legend li {
        display: flex; /* Align icon & text */
        align-items: center;
        gap: 5px; /* Space between box and text */
        white-space: nowrap; /* Prevents wrapping */
    }

    .custom-legend span {
        width: 16px;
        height: 16px;
        display: inline-block;
        border: 1px solid #ccc;
    }

    /* Colors */
    .custom-employee-shift { background-color: {{ \App\Facades\HelperFacade::calendarColor()['employee_shift'] }}; }
    .custom-change-shift { background-color: {{ \App\Facades\HelperFacade::calendarColor()['change_shift'] }}; }
    .custom-regular-holiday { background-color: {{ \App\Facades\HelperFacade::calendarColor()['regular_holiday'] }}; }
    .custom-special-holiday { background-color: {{ \App\Facades\HelperFacade::calendarColor()['special_holiday'] }}; }
    .custom-double-holiday { background-color: {{ \App\Facades\HelperFacade::calendarColor()['double_holiday'] }}; }
</style>

  @stack('crud_list_styles')
@endsection

@section('after_scripts')
@include('crud::inc.datatables_logic')
<script src="{{ asset('packages/fullcalendar/2.2.7/moment.min.js') }}"></script>
<script src="{{ asset('packages/fullcalendar/3.10.2/fullcalendar.min.js') }}"></script>

{!! $calendar->script() !!}

{{-- CRUD LIST CONTENT - crud_list_scripts stack --}}
  @stack('crud_list_scripts')
@endsection
