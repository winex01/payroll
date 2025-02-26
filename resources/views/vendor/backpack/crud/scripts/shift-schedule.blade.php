@push('after_scripts')
    <script>
        crud.field('open_time').onChange(function(field) {
            var openTimeTrueHide = [
                'early_login_overtime',
                'working_hours',
                'day_start',
                'late',
            ];

            var openTimeFalseHide = [
                //
            ];

            if (field.value == true) {
                crud.fields(openTimeTrueHide).forEach(function(field) {
                    field.hide();
                });

                crud.fields(openTimeFalseHide).forEach(function(field) {
                    field.show();
                });
            } else {
                crud.fields(openTimeTrueHide).forEach(function(field) {
                    field.show();
                });

                crud.fields(openTimeFalseHide).forEach(function(field) {
                    field.hide();
                });
            }
        }).change();
    </script>
@endpush
