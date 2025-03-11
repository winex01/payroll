@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    $crud->entity_name_plural => url($crud->route),
    'Calendar' => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none" bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</h1>
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">{!! $crud->getSubheading() ?? __('Calendar').' '.$crud->entity_name !!}.</p>
        @if ($crud->hasAccess('list'))
            <p class="mb-0 ms-2 ml-2" bp-section="page-subheading-back-button">
                <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
            </p>
        @endif
    </section>
@endsection

@section('content')
<div class="row">
    <div id='calendar'></div>
</div>
@endsection

@push('after_scripts')
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

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: true,
        selectable: true,
        dayMaxEventRows: true, // Enables the +X more button
        eventOrder: "id", // Sort events by ID instead of title
        events: [
            { id: '1', title: 'Meeting with Team A', start: '2025-03-10', color: '#FF5733' },
            { id: '2', title: 'Lunch with Client', start: '2025-03-10', color: '#33FF57' },
            { id: '3', title: 'Project Deadline', start: '2025-03-10', color: '#3357FF' },
            { id: '4', title: 'Conference Call', start: '2025-03-10', color: '#FF33A1' },
            { id: '5', title: 'Final Review', start: '2025-03-10', color: '#FF9900' },
            { id: '6', title: 'Lorem Ipsum', start: '2025-03-10', color: '#3357FF' },
            { id: '7', title: 'Dolor New Sa', start: '2025-03-10', color: '#3357FF' },
            { id: '8', title: 'Last Mariblis', start: '2025-03-10', color: '#3357FF' },
            { id: '9', title: 'New Rat Lorem', start: '2025-03-10', color: '#3357FF' }
        ]
    });

    calendar.render();
});



</script>
@endpush
