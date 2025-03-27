@extends('backEnd.master')
@section('title')
    @lang('hr.calendar')
@endsection
<style>
    .table tbody td {
        padding: 10px !important
    }
</style>
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('hr.calendar')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a>@lang('hr.human_resource')</a>
                    <a>@lang('hr.calendar')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-md-6 mb-20">
                                <div class="primary_input mb-2">
                                    <label class="primary_input_label" for="">@lang('common.course_name_en') <span class="text-danger"> *</span></label>
                                    <input class="primary_input_field form-control" name="course_name_en" id="course_name_en" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-20">
                                <div class="primary_input mb-2">
                                    <label class="primary_input_label" for="">@lang('common.course_name_ar') <span class="text-danger"> *</span></label>
                                    <input dir="rtl" class="primary_input_field form-control" name="course_name_ar" id="course_name_ar" />
                                </div>
                            </div>
                            <div class="col-md-3 mb-20">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="">@lang('common.categories')</label>
                                    <select class="primary_select form-control {{ $errors->has('cat_id') ? ' is-invalid' : '' }}" name="cat_id" id="cat_id">
                                        <option data-display="@lang('common.categories') *" value="">@lang('common.categories') *</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ app()->getLocale() == 'en' ? $item->name_en : $item->name_ar }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('cat_id'))
                                        <span class="text-danger invalid-select" role="alert">{{ $errors->first('cat_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 mb-20">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="">@lang('academics.track_types')</label>
                                    <select class="primary_select form-control{{ $errors->has('track_type_id') ? ' is-invalid' : '' }}" name="track_type_id" id="track_type_id"></select>
                                    @if ($errors->has('track_type_id'))
                                        <span class="text-danger invalid-select" role="alert">{{ $errors->first('track_type_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 mb-20">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="">@lang('academics.tracks')</label>
                                    <select class="primary_select form-control {{ $errors->has('track_id') ? 'is-invalid' : '' }}" name="track_id" id="track_id"></select>
                                    @if ($errors->has('track_id'))
                                        <span class="text-danger invalid-select" role="alert">{{ $errors->first('track_id') }}</span>
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
                                    <input type="date" min="{{ date('Y-m-d') }}" class="form-control" name="start_date" id="start_date">
                                </div>
                            </div>
                            <div class="col-md-4 mb-20">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="end_date">@lang('academics.end_date')</label>
                                    <input type="date" min="{{ date('Y-m-d') }}" class="form-control" id="end_date" disabled>
                                </div>
                            </div>
                            <div class="col-md-4 mb-20">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="scheduled">@lang('academics.schedule')</label>
                                    <select class="form-control" name="scheduled" id="scheduled"></select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-20">
                                <div id="slotContainer"></div>
                            </div>
                            <div class="col-md-12 mb-20">
                                <div id="submitAssignStaff"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            trackTypeSelect.empty().append("<option>Select Track Type</option>");

                            data.tracks.forEach(function(track) {
                                var optionText = ($locale === 'en') ? track.track_name_en : track.track_name_ar;
                                trackSelect.append('<option value="' + track.id + '" data-level="' + track.level_number + '">' + optionText + '</option>');
                            });

                            data.valid_for.forEach(function(validFor) {
                                trackTypeSelect.append(`<option value="${validFor.id}">${validFor.name}</option>`);
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
                    data: { track_id: $(this).val() },
                    success: function(response) {
                        $('#session').empty().append(`<option value="${response.track.session}">${response.track.session}</option>`);
                        $('#scheduled').empty().append('<option value="">@lang('academics.select_schedule') *</option>');
                        var schedules = ["once", "twice"];
                        $.each(schedules, function(index, schedule) {
                            $('#scheduled').append('<option value="' + schedule + '">' + schedule + '</option>');
                        });
                    },
                    error: function() {
                        alert('Failed to fetch track data.');
                    }
                });
            });

            // Show day field based on schedule selection
            $('#scheduled').on('change', function() {
                var schedule = $(this).val();
                var slotContainer = $('#slotContainer');
                slotContainer.empty();

                if (schedule === 'once') {
                    slotContainer.html(`
                        <div class="row" id="once_schedule">
                            <div class="col-md-4">
                                <label class="primary_input_label">@lang('common.select_day')</label>
                                <select class="form-control" name="day_1" id="day_1">
                                    <option value="">@lang('common.select_day')</option>
                                    <option value="Sunday">@lang('common.sunday')</option>
                                    <option value="Monday">@lang('common.monday')</option>
                                    <option value="Tuesday">@lang('common.tuesday')</option>
                                    <option value="Wednesday">@lang('common.wednesday')</option>
                                    <option value="Thursday">@lang('common.thursday')</option>
                                    <option value="Friday">@lang('common.friday')</option>
                                    <option value="Saturday">@lang('common.saturday')</option>
                                </select>
                            </div>
                            <div class="col-md-4" id="start_time_container_1"></div>
                            <div class="col-md-4" id="end_time_container_1"></div>
                        </div>
                        <div id="teachers_table_1" class="mt-3"></div>
                    `);
                } else if (schedule === 'twice') {
                    slotContainer.html(`
                        <div class="row mb-3" id="twice_schedule_1">
                            <div class="col-md-4">
                                <label class="primary_input_label">@lang('common.select_day')</label>
                                <select class="form-control" name="day_1" id="day_1">
                                    <option value="">@lang('common.select_day')</option>
                                    <option value="Sunday">@lang('common.sunday')</option>
                                    <option value="Monday">@lang('common.monday')</option>
                                    <option value="Tuesday">@lang('common.tuesday')</option>
                                    <option value="Wednesday">@lang('common.wednesday')</option>
                                    <option value="Thursday">@lang('common.thursday')</option>
                                    <option value="Friday">@lang('common.friday')</option>
                                    <option value="Saturday">@lang('common.saturday')</option>
                                </select>
                            </div>
                            <div class="col-md-4" id="start_time_container_1"></div>
                            <div class="col-md-4" id="end_time_container_1"></div>
                        </div>
                        <div id="teachers_table_1" class="mt-3"></div>
                        <div class="row" id="twice_schedule_2">
                            <div class="col-md-4">
                                <label class="primary_input_label">@lang('common.select_day')</label>
                                <select class="form-control" name="day_2" id="day_2">
                                    <option value="">@lang('common.select_day')</option>
                                    <option value="Sunday">@lang('common.sunday')</option>
                                    <option value="Monday">@lang('common.monday')</option>
                                    <option value="Tuesday">@lang('common.tuesday')</option>
                                    <option value="Wednesday">@lang('common.wednesday')</option>
                                    <option value="Thursday">@lang('common.thursday')</option>
                                    <option value="Friday">@lang('common.friday')</option>
                                    <option value="Saturday">@lang('common.saturday')</option>
                                </select>
                            </div>
                            <div class="col-md-4" id="start_time_container_2"></div>
                            <div class="col-md-4" id="end_time_container_2"></div>
                        </div>
                        <div id="teachers_table_2" class="mt-3"></div>
                    `);
                }
                calculateEndDate();
            });

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
                    $('#teachers_table_1').empty();
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
                    $('#teachers_table_2').empty();
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
                    $('#teachers_table_1').empty();
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
                    $('#teachers_table_2').empty();
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

            // Fetch available teachers and generate table
            function fetchAvailableTeachers(day, startTime, endTime, tableId, slotNum) {
                if (!day || !startTime || !endTime || !$('#start_date').val() || !$('#session').val()) return;

                $.ajax({
                    url: '{{ route('getTeachersByTime') }}',
                    method: 'GET',
                    data: {
                        day: day,
                        start_time: startTime,
                        end_time: endTime,
                        track_id: $('#track_id').val()
                    },
                    success: function(response) {
                        let sessionCount = parseInt($('#session').val());
                        let startDate = new Date($('#start_date').val());
                        let daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                        let dayIndex = daysOfWeek.indexOf(day);
                        let tableHtml = `
                            <h5>@lang('hr.available_teachers')</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>@lang('hr.teacher_name')</th>
                                        <th>@lang('common.day') / @lang('common.date')</th>
                                        <th>@lang('common.available_times')</th>
                                        <th>@lang('common.select')</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        if (response.teachers && response.teachers.length > 0) {
                            response.teachers.forEach(function(teacher) {
                                let dates = [];
                                let currentDate = new Date(startDate);
                                let weeks = $('#scheduled').val() === 'once' ? sessionCount : Math.ceil(sessionCount / 2);

                                for (let i = 0; i < weeks; i++) {
                                    while (currentDate.getDay() !== dayIndex) {
                                        currentDate.setDate(currentDate.getDate() + 1);
                                    }
                                    dates.push(currentDate.toISOString().split('T')[0]);
                                    currentDate.setDate(currentDate.getDate() + 7);
                                }

                                tableHtml += `
                                    <tr>
                                        <td rowspan="${dates.length}">${teacher.staff_name}</td>
                                        <td>${day} (${dates[0]})</td>
                                        <td>${teacher.available_times.map(time => `${time.start} - ${time.end}`).join(', ')}</td>
                                        <td rowspan="${dates.length}"><input type="radio" name="selected_teacher_${slotNum}" value="${teacher.staff_id}"></td>
                                    </tr>
                                `;
                                for (let i = 1; i < dates.length; i++) {
                                    tableHtml += `
                                        <tr>
                                            <td>${day} (${dates[i]})</td>
                                            <td>${teacher.available_times.map(time => `${time.start} - ${time.end}`).join(', ')}</td>
                                        </tr>
                                    `;
                                }
                            });
                        } else {
                            tableHtml += `
                                <tr>
                                    <td colspan="4">@lang('academics.no_teachers_available')</td>
                                </tr>
                            `;
                        }

                        tableHtml += `
                                </tbody>
                            </table>
                        `;
                        $(`#${tableId}`).html(tableHtml);
                    },
                    error: function() {
                        alert('Failed to fetch available teachers.');
                    }
                });
            }

            // Event listener for end time selection
            $(document).on('change', '#end_time_1', function() {
                var day = $('#day_1').val();
                var startTime = $('#start_time_1').val();
                var endTime = $(this).val();
                fetchAvailableTeachers(day, startTime, endTime, 'teachers_table_1', 1);
            });

            $(document).on('change', '#end_time_2', function() {
                var day = $('#day_2').val();
                var startTime = $('#start_time_2').val();
                var endTime = $(this).val();
                fetchAvailableTeachers(day, startTime, endTime, 'teachers_table_2', 2);
            });

            // Calculate end date
            function calculateEndDate() {
                var startDate = $('#start_date').val();
                var sessionCount = $('#session').val();
                var schedule = $('#scheduled').val();

                if (!startDate || !sessionCount || !schedule) {
                    $('#end_date').prop('disabled', true);
                    return;
                }

                var start = new Date(startDate);
                var endDate = new Date(start);

                if (schedule === "once") {
                    endDate.setDate(start.getDate() + (sessionCount - 1) * 7);
                } else if (schedule === "twice") {
                    var weeksRequired = Math.ceil(sessionCount / 2);
                    endDate.setDate(start.getDate() + (weeksRequired - 1) * 7);
                }

                $('#end_date').val(endDate.toISOString().split('T')[0]);
                $('#end_date').prop('disabled', false);
            }

            $('#start_date, #scheduled').on('change', function() {
                calculateEndDate();
            });

            // Submit form with selected teachers
            function submitAssignedForm() {
                let formData = {
                    course_name_en: $('#course_name_en').val(),
                    course_name_ar: $('#course_name_ar').val(),
                    cat_id: $('#cat_id').val(),
                    track_type_id: $('#track_type_id').val(),
                    track_id: $('#track_id').val(),
                    session: $('#session').val(),
                    schedule: $('#scheduled').val(),
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    _token: '{{ csrf_token() }}'
                };

                if ($('#scheduled').val() === 'once') {
                    formData.day_1 = $('#day_1').val();
                    formData.start_time_1 = $('#start_time_1').val();
                    formData.end_time_1 = $('#end_time_1').val();
                    formData.staff_id_1 = $('input[name="selected_teacher_1"]:checked').val();
                } else if ($('#scheduled').val() === 'twice') {
                    formData.day_1 = $('#day_1').val();
                    formData.start_time_1 = $('#start_time_1').val();
                    formData.end_time_1 = $('#end_time_1').val();
                    formData.staff_id_1 = $('input[name="selected_teacher_1"]:checked').val();
                    formData.day_2 = $('#day_2').val();
                    formData.start_time_2 = $('#start_time_2').val();
                    formData.end_time_2 = $('#end_time_2').val();
                    formData.staff_id_2 = $('input[name="selected_teacher_2"]:checked').val();
                }

                $.ajax({
                    url: '{{ route('scheduleStaffEvent') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            title: "Good job!",
                            text: "Schedule saved successfully!",
                            icon: "success"
                        });
                        $('#course_name_en').val('');
                        $('#course_name_ar').val('');
                        $('#slotContainer').empty();
                        $('#session').empty();
                        $('#scheduled').empty();
                        $('#start_date').val('');
                        $('#end_date').val('');
                        $("#submitAssignStaff").empty();
                    },
                    error: function(error) {
                        alert('Error saving event: ' + error.responseText);
                    }
                });
            }

            // Add submit button after schedule selection
            $('#scheduled').on('change', function() {
                if ($(this).val()) {
                    $("#submitAssignStaff").html(`<button class="btn btn-primary" onclick="submitAssignedForm()">Submit</button>`);
                }
            });
        });
    </script>
@endpush