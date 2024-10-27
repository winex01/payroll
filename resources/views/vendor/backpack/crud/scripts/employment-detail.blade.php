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
                        // console.log(response);
                        if (response) {
                            var fieldNamesArray = Object.values(response.allFieldNames);

                            crud.fields(fieldNamesArray).forEach(function(field) {
                                field.hide();
                            });

                            if (response.isModel == true) {
                                crud.field(response.fieldName).input.value = crud.field('value').input
                                    .value;
                                crud.field(response.fieldName).show();
                                // crud.field(response.fieldName).onChange(function(field) {
                                //     crud.field('value').input.value = field.value;
                                // }).change();
                            }
                            // else {
                            //     if ("{{ $crud->getOperation() }}" == 'create') {
                            //         crud.field('value').input.value = null;
                            //     }

                            //     console.log(response.fieldName);

                            // }

                            crud.field('value').input.value = crud.field(response.fieldName).input
                            .value;
                            crud.field(response.fieldName).show();
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
