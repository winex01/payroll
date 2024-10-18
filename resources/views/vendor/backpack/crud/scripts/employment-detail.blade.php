@php
    // dd(route('employment-detail-type.find', 1));
@endphp

@push('after_scripts')
    <script>
        crud.field('employmentDetailType').onChange(function(field) {
            // if (field.value == 1) {
            //     crud.field('date_of_marriage').hide();
            // } else {
            //     crud.field('date_of_marriage').show();
            // }

            if (field.value) {
                $.ajax({
                    type: "post",
                    url: "{{ route('employment-detail-type.find') }}",
                    data: {
                        id: field.value,
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            }

        }).change();
    </script>
@endpush
