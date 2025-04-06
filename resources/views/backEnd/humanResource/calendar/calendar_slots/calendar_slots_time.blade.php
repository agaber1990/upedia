@push('scripts')
<script>
    $(document).ready(function() {
        // Show start time after selecting day
        $(document).on('change', '#day_1', function() {
            var day = $(this).val();
            if (day) {
                $('#start_time_container_1').html(`
                    <label class="primary_input_label">@lang('academics.start_time')</label>
                    <select class="form-control" name="start_time_1" id="start_time_1">
                        <option value="">@lang('common.select_time')</option>
                        ${generateTimeOptions()}
                    </select>
                `);
            } else {
                $('#start_time_container_1').empty();
                $('#end_time_container_1').empty();
                $('#teachers_table').empty();
            }
        });

        $(document).on('change', '#day_2', function() {
            var day = $(this).val();
            if (day) {
                $('#start_time_container_2').html(`
                    <label class="primary_input_label">@lang('academics.start_time')</label>
                    <select class="form-control" name="start_time_2" id="start_time_2">
                        <option value="">@lang('common.select_time')</option>
                        ${generateTimeOptions()}
                    </select>
                `);
            } else {
                $('#start_time_container_2').empty();
                $('#end_time_container_2').empty();
            }
        });

        // Show end time after selecting start time
        $(document).on('change', '#start_time_1', function() {
            var startTime = $(this).val();
            if (startTime) {
                $('#end_time_container_1').html(`
                    <label class="primary_input_label">@lang('academics.end_time')</label>
                    <select class="form-control" name="end_time_1" id="end_time_1">
                        <option value="">@lang('common.select_time')</option>
                        ${generateEndTimeOptions(startTime)}
                    </select>
                `);
            } else {
                $('#end_time_container_1').empty();
                $('#teachers_table').empty();
            }
        });

        $(document).on('change', '#start_time_2', function() {
            var startTime = $(this).val();
            if (startTime) {
                $('#end_time_container_2').html(`
                    <label class="primary_input_label">@lang('academics.end_time')</label>
                    <select class="form-control" name="end_time_2" id="end_time_2">
                        <option value="">@lang('common.select_time')</option>
                        ${generateEndTimeOptions(startTime)}
                    </select>
                `);
            } else {
                $('#end_time_container_2').empty();
            }
        });

        // Generate time options for start time
        function generateTimeOptions() {
            let options = '';
            for (let hour = 0; hour < 24; hour++) {
                let displayHour = (hour % 12 === 0) ? 12 : hour % 12;
                let period = (hour < 12) ? 'AM' : 'PM';
                let value = `${hour.toString().padStart(2, '0')}:00`;
                options += `<option value="${value}">${displayHour}:00 ${period}</option>`;
            }
            return options;
        }

        // Generate end time options based on start time
        function generateEndTimeOptions(startTime) {
            let startHour = parseInt(startTime.split(':')[0]);
            let options = '';
            for (let hour = startHour + 1; hour < 24; hour++) {
                let displayHour = (hour % 12 === 0) ? 12 : hour % 12;
                let period = (hour < 12) ? 'AM' : 'PM';
                let value = `${hour.toString().padStart(2, '0')}:00`;
                options += `<option value="${value}">${displayHour}:00 ${period}</option>`;
            }
            return options;
        }
    });
</script>
@endpush