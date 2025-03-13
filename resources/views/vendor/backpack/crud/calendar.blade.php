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
          <div class="col-sm-9">
            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
              <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">

                @include('crud::inc.button_stack', ['stack' => 'top'])

              </div>
            @endif
          </div>
          @if($crud->getOperationSetting('searchableTable'))
          <div class="col-sm-3">
            <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none">
              <div class="input-icon">
                <span class="input-icon-addon">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                </span>
                <input type="search" class="form-control" placeholder="{{ trans('backpack::crud.search') }}..."/>
              </div>
            </div>
          </div>
          @endif
        </div>

        {{-- Backpack List Filters --}}
        @if ($crud->filtersEnabled())
          @include('crud::inc.filters_navbar')
        @endif

        <div class="row card">
            <div id='calendar'></div>
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
  @stack('crud_list_styles')
@endsection

@section('after_scripts')
  @include('crud::inc.datatables_logic')

  <script src='{{ basset('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js') }}'></script>

<script>

// document.addEventListener('DOMContentLoaded', function() {
//     var calendarEl = document.getElementById('calendar');
//     var calendar = new FullCalendar.Calendar(calendarEl, {
//         initialView: 'dayGridMonth',
//         events: [
//             { title: 'Meeting', start: '2025-03-10', color: '#FF5733' }, // Red
//             { title: 'Workshop', start: '2025-03-10', color: '#33FF57' }, // Green
//             { title: 'Conference', start: '2025-03-12', end: '2025-03-14', color: '#3357FF' }, // Blue
//             { title: 'Webinar', start: '2025-03-12', color: '#FFC300' } // Yellow
//         ]
//     });
//     calendar.render();
// });

// document.addEventListener('DOMContentLoaded', function() {
//     var calendarEl = document.getElementById('calendar');
//     var calendar = new FullCalendar.Calendar(calendarEl, {
//         initialView: 'dayGridMonth',
//         events: [
//             { title: 'Meeting', start: '2025-03-10', color: '#FF5733' },
//             { title: 'Workshop', start: '2025-03-10', color: '#33FF57' }
//         ],
//         datesSet: function(info) {
//             console.log('View changed to:', info.view.type);
//             console.log('Current start date:', info.start); // Start date of the new view
//             console.log('Current end date:', info.end);     // End date of the new view
//             console.log('Current active date:', info.startStr); // Start date as a string

//             // Example: Load new events dynamically when user navigates
//             fetchEvents(info.start, info.end);
//         }
//     });

//     calendar.render();

//     function fetchEvents(start, end) {
//         console.log('Fetching events for:', start, 'to', end);
//         // You can make an AJAX request here to get new events
//         // alert('TEST WTF');
//     }
// });


// document.addEventListener('DOMContentLoaded', function() {
//     var calendarEl = document.getElementById('calendar');
//     var calendar = new FullCalendar.Calendar(calendarEl, {
//         initialView: 'dayGridMonth',
//         events: function(fetchInfo, successCallback, failureCallback) {
//             // Fetch events via AJAX
//             $.ajax({
//                 url: '/get-events', // Replace with your endpoint
//                 method: 'GET',
//                 dataType: 'json',
//                 success: function(response) {
//                     var events = response.map(event => ({
//                         title: event.title,
//                         start: event.start,
//                         color: event.color,
//                         description: event.description // Append description
//                     }));
//                     successCallback(events);
//                 },
//                 error: function() {
//                     failureCallback();
//                 }
//             });
//         },
//         eventDidMount: function(info) {
//             // Append description as a tooltip
//             $(info.el).tooltip({
//                 title: info.event.extendedProps.description,
//                 placement: 'top',
//                 trigger: 'hover',
//                 container: 'body'
//             });
//         }
//     });

//     calendar.render();
// });

// document.addEventListener('DOMContentLoaded', function() {
//     var calendarEl = document.getElementById('calendar');
//     var calendar = new FullCalendar.Calendar(calendarEl, {
//         initialView: 'dayGridMonth',
//         events: function(fetchInfo, successCallback, failureCallback) {
//             // Hardcoded events returned via callback function
//             var events = [
//                 {
//                     title: 'Meeting',
//                     start: '2025-03-10',
//                     color: '#FF5733',
//                     description: 'Discuss project updates'
//                 },
//                 {
//                     title: 'Workshop',
//                     start: '2025-03-10',
//                     color: '#33FF57',
//                     description: 'Hands-on training session'
//                 },
//                 {
//                     title: 'Conference winex',
//                     start: '2025-03-12',
//                     end: '2025-03-14',
//                     color: '#3357FF',
//                     description: 'Annual business conference'
//                 }
//             ];

//             // Pass events to FullCalendar
//             successCallback(events);
//         },
//         eventDidMount: function(info) {
//             // Append description as a tooltip
//             $(info.el).tooltip({
//                 title: info.event.extendedProps.description, // Get description from event
//                 placement: 'top',
//                 trigger: 'hover',
//                 container: 'body'
//             });
//         }
//     });

//     calendar.render();
// });


// document.addEventListener('DOMContentLoaded', function() {
//     var calendarEl = document.getElementById('calendar');
//     var calendar = new FullCalendar.Calendar(calendarEl, {
//         initialView: 'dayGridMonth',
//         editable: true, // Enables dragging
//         events: function(fetchInfo, successCallback, failureCallback) {
//             var events = [
//                 {
//                     id: '1',
//                     title: 'Meeting',
//                     start: '2025-03-10',
//                     color: '#FF5733',
//                     description: 'Discuss project updates'
//                 },
//                 {
//                     id: '2',
//                     title: 'Workshop',
//                     start: '2025-03-10',
//                     color: '#33FF57',
//                     description: 'Hands-on training session'
//                 },
//                 {
//                     id: '3',
//                     title: 'Conference',
//                     start: '2025-03-12',
//                     end: '2025-03-14',
//                     color: '#3357FF',
//                     description: 'Annual business conference'
//                 }
//             ];
//             successCallback(events);
//         },
//         eventDidMount: function(info) {
//             $(info.el).tooltip({
//                 title: info.event.extendedProps.description,
//                 placement: 'top',
//                 trigger: 'hover',
//                 container: 'body'
//             });
//         },
//         eventClick: function(info) {
//             alert('Event Clicked: ' + info.event.title);
//         },
//         eventDrop: function(info) {
//             alert('Event Moved: ' + info.event.title + '\nNew Date: ' + info.event.start.toISOString().split('T')[0]);
//         }
//     });

//     calendar.render();
// });

// document.addEventListener('DOMContentLoaded', function() {
//     var calendarEl = document.getElementById('calendar');
//     var calendar = new FullCalendar.Calendar(calendarEl, {
//         initialView: 'dayGridMonth',
//         editable: true, // Enables dragging
//         selectable: true, // Enables selecting date range
//         events: function(fetchInfo, successCallback, failureCallback) {
//             var events = [
//                 {
//                     id: '1',
//                     title: 'Meeting',
//                     start: '2025-03-10',
//                     color: '#FF5733',
//                     description: 'Discuss project updates'
//                 },
//                 {
//                     id: '2',
//                     title: 'Workshop',
//                     start: '2025-03-10',
//                     color: '#33FF57',
//                     description: 'Hands-on training session'
//                 },
//                 {
//                     id: '3',
//                     title: 'Conference',
//                     start: '2025-03-12',
//                     end: '2025-03-14',
//                     color: '#3357FF',
//                     description: 'Annual business conference'
//                 }
//             ];
//             successCallback(events);
//         },
//         eventDidMount: function(info) {
//             $(info.el).tooltip({
//                 title: info.event.extendedProps.description,
//                 placement: 'top',
//                 trigger: 'hover',
//                 container: 'body'
//             });
//         },
//         eventClick: function(info) {
//             alert('Event Clicked: ' + info.event.title);
//         },
//         eventDrop: function(info) {
//             alert('Event Moved: ' + info.event.title + '\nNew Date: ' + info.event.start.toISOString().split('T')[0]);
//         },
//         dateClick: function(info) {
//             alert('Date Clicked: ' + info.dateStr);
//         },
//         select: function(info) {
//             alert('Selected Date Range:\nStart: ' + info.startStr + '\nEnd: ' + info.endStr);
//         }
//     });

//     calendar.render();
// });

// document.addEventListener('DOMContentLoaded', function() {
//     var calendarEl = document.getElementById('calendar');
//     var calendar = new FullCalendar.Calendar(calendarEl, {
//         initialView: 'dayGridMonth',
//         editable: true, // Enables dragging
//         selectable: true, // Enables selecting date range
//         events: function(fetchInfo, successCallback, failureCallback) {
//             var events = [
//                 {
//                     id: '1',
//                     title: 'Meeting \n Lorem Ipsum \n Dolor test 123',
//                     start: '2025-03-10',
//                     color: '#FF5733',
//                     description: 'Discuss project updates'
//                 },
//                 {
//                     id: '2',
//                     title: 'Workshop',
//                     start: '2025-03-10',
//                     color: '#33FF57',
//                     description: 'Hands-on training session'
//                 },
//                 {
//                     id: '3',
//                     title: 'Conference',
//                     start: '2025-03-12',
//                     end: '2025-03-14',
//                     color: '#3357FF',
//                     description: 'Annual business conference'
//                 }
//             ];
//             successCallback(events);
//         },
//         eventDidMount: function(info) {
//             $(info.el).tooltip({
//                 title: info.event.extendedProps.description,
//                 placement: 'top',
//                 trigger: 'hover',
//                 container: 'body'
//             });
//         },
//         eventClick: function(info) {
//             alert('Event Clicked: ' + info.event.title);
//         },
//         eventDrop: function(info) {
//             alert('Event Moved: ' + info.event.title + '\nNew Date: ' + info.event.start.toISOString().split('T')[0]);
//         },
//         dateClick: function(info) {
//             var newEvent = {
//                 id: String(Date.now()), // Unique ID
//                 title: 'New Event',
//                 start: info.dateStr,
//                 color: '#FF9900',
//                 description: 'Manually added event'
//             };
//             calendar.addEvent(newEvent);
//             alert('Added Event: ' + newEvent.title + '\nDate: ' + newEvent.start);
//         },
//         select: function(info) {
//             var newEvent = {
//                 id: String(Date.now()), // Unique ID
//                 title: 'Selected Event',
//                 start: info.startStr,
//                 end: info.endStr,
//                 color: '#9900FF',
//                 description: 'Selected range event'
//             };
//             calendar.addEvent(newEvent);
//             alert('Added Event: ' + newEvent.title + '\nStart: ' + newEvent.start + '\nEnd: ' + newEvent.end);
//         }
//     });

//     calendar.render();
// });

// document.addEventListener('DOMContentLoaded', function() {
//     var calendarEl = document.getElementById('calendar');
//     var calendar = new FullCalendar.Calendar(calendarEl, {
//         // initialView: 'dayGridMonth',
//         initialView: 'multiMonthYear',
//         editable: true,
//         selectable: true,
//         dayMaxEventRows: true, // Enables the +X more button
//         eventOrder: "id", // Sort events by ID instead of title
//         events: [
//             { id: '1', title: 'Meeting with Team A', start: '2025-03-10', color: '#FF5733' },
//             { id: '2', title: 'Lunch with Client', start: '2025-03-10', color: '#33FF57' },
//             { id: '3', title: 'Project Deadline', start: '2025-03-10', color: '#3357FF' },
//             { id: '4', title: 'Conference Call', start: '2025-03-10', color: '#FF33A1' },
//             { id: '5', title: 'Final Review', start: '2025-03-10', color: '#FF9900' },
//             { id: '6', title: 'Lorem Ipsum', start: '2025-03-10', color: '#3357FF' },
//             { id: '7', title: 'Dolor New Sa', start: '2025-03-10', color: '#3357FF' },
//             { id: '8', title: 'Last Mariblis', start: '2025-03-10', color: '#3357FF' },
//             { id: '9', title: 'New Rat Lorem', start: '2025-03-10', color: '#3357FF' }
//         ]
//     });

//     calendar.render();
// });


// document.addEventListener('DOMContentLoaded', function() {
//     var calendarEl = document.getElementById('calendar');
//     var calendar = new FullCalendar.Calendar(calendarEl, {
//         initialView: 'multiMonthYear', // Start with multiMonthYear view
//         editable: true,
//         selectable: true,
//         dayMaxEventRows: true,
//         eventOrder: "id",
//         customButtons: {
//             toggleView: {
//                 text: 'Toggle View',
//                 click: function() {
//                     var currentView = calendar.view.type;
//                     var newView = currentView === 'dayGridMonth' ? 'multiMonthYear' : 'dayGridMonth';
//                     calendar.changeView(newView);
//                 }
//             }
//         },
//         headerToolbar: {
//             left: 'prev,next today',
//             center: 'title',
//             right: 'toggleView' // Add custom toggle button
//         },
//         events: [
//             { id: '1', title: 'Meeting with Team A', start: '2025-03-10', color: '#FF5733' },
//             { id: '2', title: 'Lunch with Client', start: '2025-03-10', color: '#33FF57' },
//             { id: '3', title: 'Project Deadline', start: '2025-03-10', color: '#3357FF' },
//             { id: '4', title: 'Conference Call', start: '2025-03-10', color: '#FF33A1' },
//             { id: '5', title: 'Final Review', start: '2025-03-10', color: '#FF9900' },
//             { id: '6', title: 'Lorem Ipsum', start: '2025-03-10', color: '#3357FF' },
//             { id: '7', title: 'Dolor New Sa', start: '2025-03-10', color: '#3357FF' },
//             { id: '8', title: 'Last Mariblis', start: '2025-03-10', color: '#3357FF' },
//             { id: '9', title: 'New Rat Lorem', start: '2025-03-10', color: '#3357FF' }
//         ]
//     });

//     calendar.render();
// });


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var toggleButtonText = 'Year View'; // Initial button text

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: true,
        selectable: true,
        dayMaxEventRows: true,
        eventOrder: "id",
        customButtons: {
            toggleView: {
                text: toggleButtonText, // Set initial button text
                click: function() {
                    var currentView = calendar.view.type;
                    var newView = currentView === 'dayGridMonth' ? 'multiMonthYear' : 'dayGridMonth';
                    var newText = newView === 'dayGridMonth' ? 'Year View' : 'Month View';

                    calendar.changeView(newView);
                    calendar.setOption('customButtons', {
                        toggleView: {
                            text: newText,
                            click: arguments.callee // Keep the same function reference
                        }
                    });

                    // Re-render toolbar to apply the updated button text
                    calendar.render();
                }
            }
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'toggleView' // Add the toggle button
        },
        events: [
            { id: '1', title: 'Employee Shift', start: '2025-03-10', color: '#0d6efd' },
            { id: '2', title: 'Change Shift', start: '2025-03-10', color: '#198754' },
            { id: '3', title: 'Leave', start: '2025-03-10', color: '#FF9900' },
            { id: '4', title: 'Absent', start: '2025-03-10', color: '#dc3545' },
            { id: '5', title: 'Regular Holiday', start: '2025-03-10', color: '#6c757d' },
            { id: '6', title: 'Special Holiday', start: '2025-03-10', color: '#9933cc' }
        ],
        dayCellDidMount: function (info) {
            let date = info.date.toISOString().split('T')[0]; // Get YYYY-MM-DD format

            // Example: Shade March 10 and March 15
            if (date === '2025-03-09' || date === '2025-03-15') {
                // info.el.style.backgroundColor = '#ffebcc'; // Light Orange Shade
                // info.el.style.backgroundColor = '#3357FF';
            }
        }
    });

    calendar.render();
});


</script>

  {{-- CRUD LIST CONTENT - crud_list_scripts stack --}}
  @stack('crud_list_scripts')
@endsection
