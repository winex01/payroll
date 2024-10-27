@push('after_scripts')
    <script>
        crud.field('employmentDetailType').onChange(function(field) {
            if (field.value) {
                $.ajax({
                    type: "post",
                    url: "{{ route('employment-detail.valueField') }}",
                    data: {
                        id: field.value,
                    },
                    success: function(response) {
                        if (response) {
                            var fieldNamesArray = Object.values(response.allFieldNames);

                            crud.fields(fieldNamesArray).forEach(function(field) {
                                field.hide();
                            });

                            if (response.isModel == true) {
                                crud.field(response.fieldName).input.value = crud.field('value').input
                                    .value;
                                crud.field(response.fieldName).show();
                                crud.field(response.fieldName).onChange(function(field) {
                                    if ("{{ $crud->getOperation() }}" == 'create') {
                                        crud.field('value').input.value = field.value;
                                    } else {
                                        crud.field('value').input.value = null;
                                    }
                                }).change();
                            } else {
                                if ("{{ $crud->getOperation() }}" == 'create') {
                                    crud.field('value').input.value = null;
                                }

                                crud.field('value').show();
                            }
                        } else {
                            new Noty({
                                type: "danger",
                                text: "<strong>Error</strong><br>The selected item is invalid."
                            }).show();
                        }
                    }
                });
            }
        }).change();
    </script>
@endpush
