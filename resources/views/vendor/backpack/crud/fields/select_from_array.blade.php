@php
    $field['allows_null'] = $field['allows_null'] ?? $crud->model::isColumnNullable($field['name']);
    $field['value'] = old_empty_or_null($field['name'], '') ??  $field['value'] ?? $field['default'] ?? '';
    $field['multiple'] = $field['allows_multiple'] ?? $field['multiple'] ?? false;

    if ($crud->getOperation() == 'list') {
        $field['allows_null'] = true;
        if (request()->has($field['name'])) {
            $field['value'] = old_empty_or_null($field['name'], '') ??  request($field['name']);
        }
    }
@endphp
{{-- select from array --}}
@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')
    @if($field['multiple'])<input type="hidden" name="{{ $field['name'] }}" value="" @if(in_array('disabled', $field['attributes'] ?? [])) disabled @endif />@endif
    <select
        name="{{ $field['name'] }}" data-init-function="bpFieldInitSelect2Element"
        data-placeholder="{{ isset($field['placeholder']) ? $field['placeholder'] : '-' }}"
        data-close-on-select="{{ isset($field['close_on_select']) ? $field['close_on_select'] : true }}"
        data-allows-clear="{{ isset($field['allows_clear']) ? $field['allows_clear'] : true }}"
        @include('crud::fields.inc.attributes', ['default_class' => 'form-control form-select'])
        @if ($field['multiple']) multiple bp-field-main-input @endif
        @if ($crud->getOperation() == 'list')
            data-filter-type="select2"
        @endif
        >

        @if ($field['allows_null'] && !$field['multiple'])
            <option value="">-</option>
        @endif
        @if (count($field['options']))
            @foreach ($field['options'] as $key => $value)
                @if($key == $field['value'] || (is_array($field['value']) && in_array($key, $field['value'])))
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        @endif
    </select>

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
    @endphp

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('after_styles')
        <!-- include select2 css-->
        <link href="{{ basset('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ basset('https://cdn.jsdelivr.net/npm/select2-bootstrap-theme@0.1.0-beta.10/dist/select2-bootstrap.min.css') }}"
            rel="stylesheet" />
    @endpush

    @push('after_scripts')
        <script src="{{ basset('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js') }}"></script>

        <script>
            function bpFieldInitSelect2Element(element) {
                // element will be a jQuery wrapped DOM node
                if (!element.hasClass("select2-hidden-accessible")) {
                    let $isFieldInline = element.data('field-is-inline');

                    var placeholder = element.attr('data-placeholder');
                    var allowClear = element.attr('data-allows-clear');
                    var closeOnSelect = element.attr('data-close-on-select');

                    element.select2({
                        theme: "bootstrap",
                        dropdownParent: $isFieldInline ? $('#inline-create-dialog .modal-content') : document.body,
                        placeholder: placeholder,
                        allowClear: allowClear,
                        closeOnSelect: closeOnSelect,
                    });
                }
            }
        </script>

        @if ($crud->getOperation() == 'list')
            <script>
                $(document).ready(function() {
                    var attr = 'select[data-filter-type=select2]';
                    var placeholder = $(attr).attr('data-placeholder');
                    var allowClear = $(attr).attr('data-allows-clear');
                    var closeOnSelect = $(attr).attr('data-close-on-select');

                    $(attr).select2({
                        theme: "bootstrap",
                        dropdownParent: document.body,
                        allowClear: allowClear,
                        placeholder: placeholder,
                        closeOnSelect: closeOnSelect,
                    });
                });
            </script>
        @endif
    @endpush
@endif

