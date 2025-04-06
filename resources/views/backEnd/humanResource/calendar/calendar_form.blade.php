<section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-md-12">
                <div class="">
                    <div class="row">
                        <div class="col-md-6 mb-20">
                            <div class="primary_input mb-2">
                                <label class="primary_input_label" for="">@lang('common.course_name_en') <span
                                        class="text-danger"> *</span></label>
                                <input class="primary_input_field form-control" name="course_name_en"
                                    id="course_name_en" />
                            </div>
                        </div>
                        <div class="col-md-6 mb-20">
                            <div class="primary_input mb-2">
                                <label class="primary_input_label" for="">@lang('common.course_name_ar') <span
                                        class="text-danger"> *</span></label>
                                <input dir="rtl" class="primary_input_field form-control" name="course_name_ar"
                                    id="course_name_ar" />
                            </div>
                        </div>
                        <div class="col-md-3 mb-20">
                            <div class="primary_input">
                                <label class="primary_input_label" for="">@lang('common.categories')</label>
                                <select
                                    class="primary_select form-control {{ $errors->has('cat_id') ? ' is-invalid' : '' }}"
                                    name="cat_id" id="cat_id">
                                    <option data-display="@lang('common.categories') *" value="">@lang('common.categories') *
                                    </option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">
                                            {{ app()->getLocale() == 'en' ? $item->name_en : $item->name_ar }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('cat_id'))
                                    <span class="text-danger invalid-select"
                                        role="alert">{{ $errors->first('cat_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 mb-20">
                            <div class="primary_input">
                                <label class="primary_input_label" for="">@lang('academics.track_types')</label>
                                <select
                                    class="primary_select form-control{{ $errors->has('track_type_id') ? ' is-invalid' : '' }}"
                                    name="track_type_id" id="track_type_id"></select>
                                @if ($errors->has('track_type_id'))
                                    <span class="text-danger invalid-select"
                                        role="alert">{{ $errors->first('track_type_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 mb-20">
                            <div class="primary_input">
                                <label class="primary_input_label" for="">@lang('academics.tracks')</label>
                                <select
                                    class="primary_select form-control {{ $errors->has('track_id') ? 'is-invalid' : '' }}"
                                    name="track_id" id="track_id"></select>
                                @if ($errors->has('track_id'))
                                    <span class="text-danger invalid-select"
                                        role="alert">{{ $errors->first('track_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 mb-20">
                            <div class="primary_input">
                                <label class="primary_input_label" for="session">@lang('academics.session')</label>
                                <select class="form-control" name="session" id="session"></select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-20">
                            <div class="primary_input">
                                <label class="primary_input_label" for="start_date">@lang('academics.start_date')</label>
                                <input type="date" min="{{ date('Y-m-d') }}" class="form-control" name="start_date"
                                    id="start_date">
                            </div>
                        </div>
                        <div class="col-md-4 mb-20">
                            <div class="primary_input">
                                <label class="primary_input_label" for="end_date">@lang('academics.end_date')</label>
                                <input type="date" min="{{ date('Y-m-d') }}" class="form-control" id="end_date"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-4 mb-20">
                            <div class="primary_input">
                                <label class="primary_input_label" for="scheduled">@lang('academics.schedule')</label>
                                <select class="form-control" name="scheduled" id="scheduled"></select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
    <style>
        /* Styles for the form section */
        .primary_input {
            margin-bottom: 15px;
        }

        .primary_input_label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .primary_input_field {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .primary_select {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .text-danger {
            color: red;
        }

        .invalid-select {
            display: block;
            margin-top: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        var $locale = '{{ app()->getLocale() }}';
        $(document).ready(function() {
            // Populate fields based on category selection
            $('#cat_id').on('change', function() {
                var catId = $(this).val();
                const trackSelect = $('#track_id');
                const trackTypeSelect = $('#track_type_id');

                if (catId) {
                    $.ajax({
                        url: '/tracks-by-category/' + catId,
                        type: 'GET',
                        success: function(data) {
                            trackSelect.empty().append("<option>Select Track</option>");
                            trackTypeSelect.empty().append(
                                "<option>Select Track Type</option>");

                            data.tracks.forEach(function(track) {
                                var optionText = ($locale === 'en') ? track
                                    .track_name_en : track.track_name_ar;
                                trackSelect.append('<option value="' + track.id +
                                    '" data-level="' + track.level_number + '">' +
                                    optionText + '</option>');
                            });

                            data.valid_for.forEach(function(validFor) {
                                trackTypeSelect.append(
                                    `<option value="${validFor.id}">${validFor.name}</option>`
                                );
                            });

                            trackSelect.niceSelect('update');
                            trackTypeSelect.niceSelect('update');
                        },
                        error: function() {
                            alert('Failed to fetch tracks. Please try again.');
                        }
                    });
                } else {
                    trackSelect.empty();
                }
            });

            // Populate session and schedule based on track selection
            $('#track_id').on('change', function() {
                $.ajax({
                    url: '{{ route('getStaffByTrack') }}',
                    method: 'GET',
                    data: {
                        track_id: $(this).val()
                    },
                    success: function(response) {
                        $('#session').empty().append(
                            `<option value="${response.track.session}">${response.track.session}</option>`
                        );
                        $('#scheduled').empty().append(
                            '<option value="">@lang('academics.select_schedule') *</option>');
                        var schedules = ["once", "twice"];
                        $.each(schedules, function(index, schedule) {
                            $('#scheduled').append('<option value="' + schedule + '">' +
                                schedule + '</option>');
                        });
                    },
                    error: function() {
                        alert('Failed to fetch track data.');
                    }
                });
            });

            // Calculate end date
            function calculateEndDate() {
                var startDate = $('#start_date').val();
                var sessionCount = parseInt($('#session').val());
                var schedule = $('#scheduled').val();

                if (!startDate || !sessionCount || !schedule) {
                    $('#end_date').prop('disabled', true);
                    return;
                }

                var start = new Date(startDate);
                var endDate = new Date(start);

                var sessionsPerWeek = schedule === "once" ? 1 : 2;
                var weeksRequired = Math.ceil(sessionCount / sessionsPerWeek);

                endDate.setDate(start.getDate() + (weeksRequired * 7) - 1);

                var dayOfWeek = endDate.getDay();
                var daysToSaturday = 6 - dayOfWeek;
                endDate.setDate(endDate.getDate() + daysToSaturday);

                $('#end_date').val(endDate.toISOString().split('T')[0]);
                $('#end_date').prop('disabled', false);
            }

            $('#start_date, #scheduled').on('change', function() {
                calculateEndDate();
            });
        });
    </script>
@endpush
