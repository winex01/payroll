@push('after_scripts')
    @if ($crud->getOperation() == 'list')
        <script>
            function handleSelectTypeChange() {
                let selectedValue = $('[name="employmentDetailType"]').val();

                if (selectedValue) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('employment-detail.valueField') }}",
                        data: {
                            id: selectedValue,
                        },
                        success: function(response) {
                            if (response) {
                                console.log(response);
                                // TODO:: show select field class model

                            } else {
                                new Noty({
                                    type: "danger",
                                    text: "<strong>Error</strong><br>The selected item is invalid."
                                }).show();
                            }
                        }
                    });
                }
            }

            $('[name="employmentDetailType"]').on('change', handleSelectTypeChange);

            $(document).ready(function() {
                $('[name="employmentDetailType"]').trigger('change');
            });
        </script>
    @else
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

                                // event set value for the specific field to copy value to value field.
                                crud.field(response.fieldName).onChange(function(field) {
                                    crud.field('value').input.value = field.value;
                                }).change();

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
    @endif
@endpush
