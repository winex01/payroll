{{-- select2 ajax --}}
@php
    if ($crud->getOperation() == 'list') {
        if (!isset($field['wrapper'])) {
            $field['wrapper'] = ['class' => 'form-group col-md-3'];
        }

        if (isset($field['size'])) {
            $field['wrapper'] = ['class' => 'form-group col-md-' . $field['size']];
        }

        if (!isset($field['attributes'])) {
            $field['attributes'] = ['data-filter-type' => 'select2'];
        }

        $field['label'] = \App\Facades\HelperFacade::strToHumanReadable($field['label']);
    }

    $current_value = old_empty_or_null($field['name'], '') ?? ($field['value'] ?? ($field['default'] ?? ''));
    $entity_model = $crud->getRelationModel($field['entity'], -1);
    $field['allows_null'] = $field['allows_null'] ?? $entity_model::isColumnNullable($field['name']);

    //if it's part of a relationship here we have the full related model, we want the key.
if (is_object($current_value) && is_subclass_of(get_class($current_value), 'Illuminate\Database\Eloquent\Model')) {
    $current_value = $current_value->getKey();
}

if (!isset($field['options'])) {
    $options = $field['model']::all();
} else {
    $options = call_user_func($field['options'], $field['model']::query());
    }

@endphp

@include('crud::fields.inc.wrapper_start')

<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')

@if (isset($field['prefix']) || isset($field['suffix']))
    <div class="input-group">
@endif
@if (isset($field['prefix']))
    <span class="input-group-text">{!! $field['prefix'] !!}</span>
@endif
<select name="{{ $field['name'] }}" data-filter-type="select2_ajax"
    data-select-key="{{ isset($field['key']) ? $field['key'] : 'id' }}"
    data-select-attribute="{{ $field['attribute'] ?? 'name' }}"
    data-minimum-input-length="{{ isset($field['minimum_input_length']) ? $field['minimum_input_length'] : 2 }}"
    data-placeholder="{{ isset($field['placeholder']) ? $field['placeholder'] : 'search...' }}"
    data-close-on-select="{{ isset($field['close_on_select']) ? $field['close_on_select'] : true }}"
    data-data-source="{{ $field['data_source'] }}"
    data-method="{{ isset($field['method']) ? $field['method'] : 'POST' }}"
    data-delay="{{ isset($field['delay']) ? $field['delay'] : 500 }}"
    data-allow-clear="{{ isset($field['allow_clear']) ? $field['allow_clear'] : true }}" @include('crud::fields.inc.attributes', ['default_class' => 'form-control form-select'])>

    @if ($field['allows_null'])
        <option value="">-</option>
    @endif

    @if (count($options))
        @foreach ($options as $connected_entity_entry)
            @if ($current_value == $connected_entity_entry->getKey())
                <option value="{{ $connected_entity_entry->getKey() }}" selected>
                    {{ $connected_entity_entry->{$field['attribute']} }}</option>
            @else
                <option value="{{ $connected_entity_entry->getKey() }}">
                    {{ $connected_entity_entry->{$field['attribute']} }}</option>
            @endif
        @endforeach
    @endif
</select>
@if (isset($field['suffix']))
    <span class="input-group-text">{!! $field['suffix'] !!}</span>
@endif
@if (isset($field['prefix']) || isset($field['suffix']))
    </div>
@endif

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif

@include('crud::fields.inc.wrapper_end')

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);

        /* NOTE:: if you notice below the css and scripts i use different CDN source from select.blade.php select2 its because. the dump ass basset pacakge cause an error if load them twice.
                 but dont worry it wont cause error if you create multiple field same type, it will only cause a problem if you use same css/script with different type.
        */

    @endphp

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('after_styles')
        <!-- include select2 css-->
        <link href="{{ basset('https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css') }}"
            rel="stylesheet" />
        <link
            href="{{ basset('https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css') }}"
            rel="stylesheet" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('after_scripts')
        <!-- include select2 js-->
        <script src="{{ basset('https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.full.min.js') }}">
        </script>

        @if ($crud->getOperation() == 'list')
            <script>
                $(document).ready(function() {
                    var attr = 'select[data-filter-type=select2_ajax]';
                    var selectAttribute = $(attr).attr('data-select-attribute');
                    var selectKey = $(attr).attr('data-select-key');
                    var allowClear = $(attr).attr('data-allow-clear');
                    var minimumInputLength = $(attr).attr('data-minimum-input-length');
                    var placeholder = $(attr).attr('data-placeholder');
                    var closeOnSelect = $(attr).attr('data-close-on-select');
                    var dataSource = $(attr).attr('data-data-source');
                    var method = $(attr).attr('data-method');
                    var delay = $(attr).attr('data-delay');

                    $(attr).select2({
                        theme: "bootstrap",
                        dropdownParent: document.body,
                        minimumInputLength: minimumInputLength,
                        allowClear: allowClear,
                        placeholder: placeholder,
                        closeOnSelect: closeOnSelect,
                        ajax: {
                            url: dataSource,
                            dataType: 'json',
                            type: method,
                            delay: delay,
                            data: function(params) {
                                return {
                                    q: params.term, // The search term
                                    page: params.page || 1 // Current page or default to 1
                                };
                            },
                            processResults: function(data) {
                                // console.log(data);
                                return {
                                    results: $.map(data.data, function(item) {
                                        return {
                                            text: item[selectAttribute],
                                            id: item[selectKey]
                                        };
                                    }),
                                    pagination: {
                                        more: data.current_page < data
                                            .last_page // Check if there are more pages
                                    }
                                };
                            },
                            cache: true

                        }

                    })

                    // Focus the input when the Select2 dropdown opens
                    $(document).on('select2:open', function(e) {
                        window.setTimeout(function() {
                            document.querySelector('input.select2-search__field').focus();
                        }, 0);
                    });
                });
            </script>
        @endif
    @endpush
@endif
