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
                            // console.log(response.fieldName);
                            var fieldNamesArray = Object.values(response.allFieldNames);

                            // hide all available fields when load
                            crud.fields(fieldNamesArray).forEach(function(field) {
                                if (response.fieldName == field.name) {
                                    crud.field(response.fieldName).input.value = crud.field(
                                            'value').input
                                        .value;
                                    field.show();
                                } else {
                                    // set to empty string and not null so the default value would be "-" if it's a select
                                    field.input.value = '';
                                    field.hide();
                                }
                            });

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
