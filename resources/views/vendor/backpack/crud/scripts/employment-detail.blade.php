@push('after_scripts')
@if ($crud->getOperation() == 'list')
    @include('crud::inc.form_fields_script')
@endif

<script>
    crud.field('employmentDetailType').onChange(function(field) {
        // reset select value to - only if its not from a fail validation, the reason because.
        // we want that if user tried to change the field type the value/model field select will reset to -
        // but if it's a failed validation so we will not reset it and we want to retain the old value for the field
        const validationErrors = "{{ $errors->any() }}" == "1";

        if (crud.action == 'create' && !validationErrors) {
            crud.field('value').input.value = '';
        }

        if (field.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('employment-detail.valueField') }}",
                data: {
                    employmentDetailType: field.value,
                },
                success: function(response) {
                    if (response) {
                        /* SELECT FIELDS */
                        crud.fields(response.selectFields).forEach(function(field) {
                            if (response.employmentDetailType === field.name) {
                                crud.field(response.employmentDetailType).input.value = crud.field('value').input.value;
                                field.show();
                            }else {
                                // set to empty string and not null so the default value would be "-" if it's a select
                                field.input.value = '';
                                field.hide();
                            }

                            // event set value for the specific field to copy value to value field.
                            crud.field(response.employmentDetailType).onChange(function(field) {
                                crud.field('value').input.value = field.value;
                            }).change();
                        });

                        /* INPUT FIELDS only in create anad edit */
                        if (crud.action == 'create' || crud.action == 'edit') {
                            crud.fields(response.inputFields).forEach(function(field) {
                                if (response.employmentDetailType === field.name) {
                                    crud.field(response.employmentDetailType).input.value = crud.field('value').input.value;
                                    field.show();
                                }else {
                                    // set to empty string and not null so the default value would be "-" if it's a select
                                    field.input.value = '';
                                    field.hide();
                                }
                            });

                            // event set value for the specific field to copy value to value field.
                            crud.field(response.employmentDetailType).onChange(function(field) {
                                crud.field('value').input.value = field.value;
                            }).change();
                        }
                    } else {
                        console.log(response);
                        new Noty({
                            type: "danger",
                            text: "<strong>Error:</strong>The selected item is invalid."
                        }).show();
                    }
                }
            });
        }
    }).change();
</script>
@endpush
