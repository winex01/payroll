@push('after_scripts')
    @if ($crud->getOperation() == 'list')
        {{-- <script>
            $(document).ready(function() {
                // Listen for changes to any checkbox with the class "form-check-input"
                $('input.form-check-input[type="checkbox"]').on('change', function() {
                    // Find the closest hidden input field that is a sibling of the checkbox
                    var hiddenInput = $(this).closest('div.form-check').find('input[type="hidden"]');

                    // Update the value of the hidden input based on the checkbox state
                    if ($(this).is(':checked')) {
                        hiddenInput.val('1'); // Assign 1 if checked
                    } else {
                        hiddenInput.val('0'); // Assign 0 if unchecked
                    }
                });
            });
        </script> --}}


        <script>
            var valueSelector = '[name="value"]';

            function handleSelectTypeChange() {
                let selectedTypeValue = $('[name="employmentDetailType"]').val();

                if (selectedTypeValue) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('employment-detail.valueField') }}",
                        data: {
                            id: selectedTypeValue,
                        },
                        success: function(response) {
                            // console.log(response);
                            if (response) {
                                if (response.selectOptions) {
                                    // change label value into the corresponding field model
                                    $(valueSelector).closest('.form-group').find('label').text(response
                                        .fieldNameHumanReadable);

                                    $(valueSelector).parent().removeClass('d-none');

                                    // Get the value from the URL
                                    var params = new URLSearchParams(window.location.search);
                                    var queryParamsValue = params.get(
                                        'value'); // Url query parameter
                                    var queryParamsDetailType = params.get(
                                        'employmentDetailType');

                                    // Clear existing options
                                    $(valueSelector).empty();

                                    // Add a default placeholder option
                                    $(valueSelector).append("<option value='0'>-</option>");

                                    // Append each option from the response
                                    response.selectOptions.forEach(function(item) {
                                        const option = $('<option>', {
                                            value: item.id,
                                            text: item.name,
                                            selected: item.id.toString() ===
                                                queryParamsValue // convert item.id to string to compare it to url params value string
                                        });
                                        $(valueSelector).append(option);
                                    });

                                    if (selectedTypeValue != queryParamsDetailType) {
                                        $(valueSelector).val(0);
                                    }
                                } else {
                                    $(valueSelector).parent().addClass('d-none');
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
            }

            $('[name="employmentDetailType"]').on('change', handleSelectTypeChange);

            $(document).ready(function() {
                $('[name="employmentDetailType"]').trigger('change');
            });
        </script>
    @else
        <script>
            crud.field('employmentDetailType').onChange(function(field) {
                // reset select value to -
                if (crud.action == 'create') {
                    crud.field('value').input.value = '';
                }

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
