@push('after_scripts')
@if ($crud->getOperation() == 'list')
    @include('crud::inc.form_fields_script')
@endif

<script>
    crud.field('employmentDetailType').onChange(function(field) {
        if (field.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('employment-detail.valueField') }}",
                data: {
                    employmentDetailType: field.value,
                    operation: "{{ $crud->getOperation() }}",
                },
                success: function(response) {
                    // console.log(response);
                    if (response) {
                        if (response.operation == 'list') {
                            /* SELECT FIELDS */
                            crud.fields(response.selectFields).forEach(function(field) {
                                if (response.dynamicField === field.name) {
                                    field.show();
                                }else {
                                    field.hide();
                                }
                            });

                            // if employmentDetailType is select field
                            if (response.isDynamicFieldSelect == true) {
                                crud.field(response.dynamicField).onChange(function(field) {
                                    crud.field('value').input.value = field.value;
                                }).change();
                            }

                        }else { // create or edit
                            // SELECT FIELDS
                            crud.fields(response.selectFields).forEach(function(field) {
                                if (response.dynamicField === field.name) {
                                    // in edit assign value from db into field
                                    if (response.operation == 'update') {
                                        crud.field(response.dynamicField).input.value = crud.field('value').input.value;
                                    }

                                    field.require();
                                    field.show();
                                }else {
                                    // set to empty string and not null so the default value would be "-" if it's a select
                                    field.input.value = '';
                                    field.unrequire();
                                    field.hide();
                                }
                            });

                            // INPUT FIELDS
                            crud.fields(response.inputFields).forEach(function(field) {
                                if (response.dynamicField === field.name) {
                                    // in edit assign value from db into field
                                    if (response.operation == 'update') {
                                        crud.field(response.dynamicField).input.value = crud.field('value').input.value;
                                    }

                                    field.require();
                                    field.show();
                                }else {
                                    // set to empty string and not null so the default value would be "-" if it's a select
                                    field.input.value = '';
                                    field.unrequire();
                                    field.hide();
                                }
                            });

                            crud.field(response.dynamicField).onChange(function(field) {
                                crud.field('value').input.value = field.value;
                            }).change();
                        }
                    } else {
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
