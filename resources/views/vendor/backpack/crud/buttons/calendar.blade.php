@if ($crud->hasAccess('calendar', $entry))
	@if (!$crud->model->translationEnabled())

	{{-- Single edit button --}}
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/calendar') }}" bp-button="calendar" class="btn btn-sm btn-link">
		<i class="las la-business-time"></i> <span>{{ __('Calendar') }}</span>
	</a>

	@else

	{{-- Edit button group --}}
	<div class="btn-group">
	  <a href="{{ url($crud->route.'/'.$entry->getKey().'/calendar') }}" class="btn btn-sm btn-link pr-0">
	    <span><i class="las la-business-time"></i> {{ __('Calendar') }}</span>
	  </a>
	  <a class="btn btn-sm btn-link dropdown-toggle text-primary pl-1" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    <span class="caret"></span>
	  </a>
	  <ul class="dropdown-menu dropdown-menu-right">
  	    <li class="dropdown-header">{{ trans('backpack::crud.edit_translations') }}:</li>
	  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
		  	<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/calendar') }}?_locale={{ $key }}">{{ $locale }}</a>
	  	@endforeach
	  </ul>
	</div>

	@endif
@endif
