@extends('backEnd.master')
@section('title')
    @lang('hr.calendar')
@endsection

<style>
    /* Center the table container */
    .table-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        padding: 20px;
    }

    /* Style the table */
    .table {
        width: 90%;
        margin: 0 auto;
        border-collapse: collapse;
    }

    /* Center text in table header and body */
    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
        padding: 10px !important;
    }

    /* Style the table header */
    .table thead th {
        background-color: #333;
        color: white;
        font-weight: bold;
    }

    /* Style for time slots */
    .table tbody td div {
        border-radius: 11px;
        font-size: 12px;
        padding: 5px;
        margin: 4px 0;
        width: 150px;
    }

    /* Ensure the table body cells have proper alignment */
    .table tbody td {
        vertical-align: top;
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
                    <div id="teachers_table" class="mt-3"></div>
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
                    <div id="teachers_table" class="mt-3 table-container"></div>
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

        // Fetch available teachers and generate a unified table
    
        function fetchAvailableTeachers() {
    var schedule = $('#scheduled').val();
    var day1 = $('#day_1').val();
    var startTime1 = $('#start_time_1').val();
    var endTime1 = $('#end_time_1').val();
    var day2 = $('#day_2').val();
    var startTime2 = $('#start_time_2').val();
    var endTime2 = $('#end_time_2').val();
    var startDate = $('#start_date').val();
    var endDate = $('#end_date').val();
    var sessionCount = parseInt($('#session').val());

    console.log('Schedule:', schedule);
    console.log('Day 1:', day1, 'Start Time 1:', startTime1, 'End Time 1:', endTime1);
    console.log('Day 2:', day2, 'Start Time 2:', startTime2, 'End Time 2:', endTime2);
    console.log('Start Date:', startDate, 'End Date:', endDate, 'Session Count:', sessionCount);

    if (!startDate || !sessionCount || !schedule) {
        console.log('Missing required fields');
        return;
    }

    var days = [];
    if (schedule === 'once' && day1 && startTime1 && endTime1) {
        days.push({ day: day1, startTime: startTime1, endTime: endTime1 });
    } else if (schedule === 'twice' && day1 && startTime1 && endTime1 && day2 && startTime2 && endTime2) {
        days.push({ day: day1, startTime: startTime1, endTime: endTime1 });
        days.push({ day: day2, startTime: startTime2, endTime: endTime2 });
    } else {
        console.log('Incomplete schedule data');
        return;
    }

    console.log('Days to fetch:', days);

    var allTeachers = {};
    var daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var promises = days.map(function(slot) {
        console.log('Fetching teachers for:', slot);
        return $.ajax({
            url: '{{ route('getTeachersByTime') }}',
            method: 'GET',
            data: {
                day: slot.day,
                start_time: slot.startTime,
                end_time: slot.endTime,
                track_id: $('#track_id').val()
            },
            success: function(response) {
                console.log('Response for', slot.day, ':', response);
                if (response.teachers) {
                    response.teachers.forEach(function(teacher) {
                        if (!allTeachers[teacher.id]) {
                            allTeachers[teacher.id] = { full_name: teacher.full_name, slots: {} };
                        }
                        allTeachers[teacher.id].slots[slot.day] = teacher.slots || [];
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log('Error fetching teachers for', slot.day, ':', error);
            }
        });
    });

    $.when.apply($, promises).then(function() {
        console.log('All teachers data:', allTeachers);

        var allDates = [];
        days.forEach(function(slot) {
            let dayIndex = daysOfWeek.indexOf(slot.day);
            let currentDate = new Date(startDate);
            while (currentDate <= new Date(endDate)) {
                if (currentDate.getDay() === dayIndex) {
                    allDates.push({
                        date: new Date(currentDate).toISOString().split('T')[0],
                        day: slot.day,
                        startTime: slot.startTime,
                        endTime: slot.endTime
                    });
                }
                currentDate.setDate(currentDate.getDate() + 1);
            }
        });

        allDates.sort((a, b) => new Date(a.date) - new Date(b.date));
        console.log('Sorted dates:', allDates);

        let tableHtml = `
            <div class=row>

                <div class="col-2 h5">@lang('academics.available_teachers')</div>
                <div class="col-1"><i class="fa-solid fa-circle" style="color: #f6c49c;"></i> @lang('academics.paid')</div>
                <div class="col-1"><i class="fa-solid fa-circle" style="color: #ff3c3c;"></i> @lang('academics.has_conflict')</div>
                <div class="col-1"><i class="fa-solid fa-circle" style="color: #FFD43B;"></i> @lang('academics.reserved')</div>


            </div>
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-dark text-white">
                        <th class="text-white">@lang('hr.teacher_name')</th>
                        ${allDates.map(item => `
                            <th class="text-white">${item.day}, ${item.date}</th>
                        `).join('')}
                    </tr>
                </thead>
                <tbody>
        `;

        if (Object.keys(allTeachers).length > 0) {
            for (let teacherId in allTeachers) {
                let teacher = allTeachers[teacherId];
                tableHtml += `
                    <tr>
                        <td>${teacher.full_name}</td>
                        ${allDates.map(item => {
                            let teacherSlots = teacher.slots[item.day] || [];
                            function toMinutes(timeStr) {
                                let [h, m] = timeStr.split(':').map(Number);
                                return h * 60 + m;
                            }
                            let relevantSlots = teacherSlots.filter(slotItem => {
                                let slotStart = toMinutes(slotItem.slot_emp.slot_start);
                                let slotEnd = toMinutes(slotItem.slot_emp.slot_end);
                                let userStart = toMinutes(item.startTime);
                                let userEnd = toMinutes(item.endTime);
                                return slotItem.slot_emp.slot_day === item.day &&
                                    slotStart >= userStart && slotEnd <= userEnd;
                            });

                            let cellContent = relevantSlots.length > 0
                                ? relevantSlots.map(slotItem => {
                                    let availability = checkTeacherAvailability(slotItem, item.date);
                                    let cellStyle = '';
                                    let slotText = formatTimeSlot(slotItem.slot_emp.slot_start, slotItem.slot_emp.slot_end);

                                    if (availability.status === 'scheduled') {
                                        cellStyle = 'background-color: #fc3b3c; color: white;';
                                    } else if (availability.status === 'has_conflict') {
                                        cellStyle = 'background-color: #fdc59a; color: white;';
                                    } else if (availability.status === 'available') {
                                        cellStyle = 'background-color: #eee21f;';
                                    }

                                    return `<div style="${cellStyle}">${slotText}</div>`;
                                }).join('')
                                : '<div>No slots available</div>';

                            return `<td>${cellContent}</td>`;
                        }).join('')}
                    </tr>
                `;
            }
        } else {
            tableHtml += `
                <tr>
                    <td colspan="${allDates.length + 1}">@lang('academics.no_teachers_available')</td>
                </tr>
            `;
        }

        tableHtml += `
                </tbody>
            </table>
        `;
        $('#teachers_table').html(tableHtml);
    }).fail(function() {
        alert('Failed to fetch available teachers.');
    });
}
        // Function to format time slots (e.g., "16:00:00" to "4:00 PM")
        function formatTimeSlot(start, end) {
            let startHour = parseInt(start.split(':')[0]);
            let endHour = parseInt(end.split(':')[0]);
            let startPeriod = startHour < 12 ? 'AM' : 'PM';
            let endPeriod = endHour < 12 ? 'AM' : 'PM';
            let displayStartHour = (startHour % 12 === 0) ? 12 : startHour % 12;
            let displayEndHour = (endHour % 12 === 0) ? 12 : endHour % 12;
            return `${displayStartHour}:00 ${startPeriod} - ${displayEndHour}:00 ${endPeriod}`;
        }

        // Function to check teacher availability based on backend data
        function checkTeacherAvailability(slot, date) {
            return { status: slot.status || 'available' };
        }

        // Event listener for end time selection
        $(document).on('change', '#end_time_1, #end_time_2', function() {
            fetchAvailableTeachers();
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
