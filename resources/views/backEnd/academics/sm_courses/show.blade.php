@extends('backEnd.master')
@section('title')
    @lang('academics.courses')
@endsection

{{-- {{dd($students)}} --}}
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('academics.academics')</a>
                    <a href="#">@lang('academics.courses')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
       

        <!-- Modal -->
        <div class="modal fade" id="assing_modal" tabindex="-1" aria-labelledby="assing_modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="assing_modalLabel">@lang('academics.add_new')</h1>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form action="{{ route('sm_courses_storeCourseToStudent') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $course->id }}" name="course_id">
                        <div class="modal-body">
                            <div class="primary_input">
                                <label class="primary_input_label" for="student_id">
                                    @lang('common.select_student') <span class="text-danger"> *</span>
                                </label>
                                <select class="primary_select form-control" name="student_id" id="student_id">
                                    @foreach ($students as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="mt-3 primary-btn fix-gr-bg text-nowrap">
                                @lang('common.submit')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-fluid p-0">
            <div class="">
                <h3 class="mb-3">
                    @lang('common.course_info')</h3>
            </div>
            <div class="white-box">
                <div class="row loaderw">
                    <div class="loadrer" id="loadrer">
                        <img src="/loader.gif" alt="" width="80">
                    </div>
                    <div class="col-md-6 ">
                        <div class="primary_input mb-2">
                            <label class="primary_input_label" for="">@lang('common.course_name_en')
                                <span class="text-danger"> *</span></label>
                            <input class="primary_input_field form-control " value="{{ $course->course_name_en ?? '' }}"
                                name="course_name_en" id="course_name_en" />
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="primary_input mb-2">
                            <label class="primary_input_label" for="">@lang('common.course_name_ar')
                                <span class="text-danger"> *</span></label>
                            <input dir="rtl" class="primary_input_field form-control "
                                value="{{ $course->course_name_ar ?? '' }}" name="course_name_ar" id="course_name_ar" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 ">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">@lang('common.categories')
                            </label>
                            <select class="primary_select  form-control {{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                name="category_id" id="category_id">
                                <option data-display="@lang('common.categories') *" value="">@lang('common.categories')
                                    *</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $course->category_id ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'en' ? $item->name_en : $item->name_ar }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->has('category_id'))
                                <span class="text-danger invalid-select" role="alert">
                                    {{ $errors->first('category_id') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 ">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">@lang('academics.track_types')
                            </label>
                            <select
                                class="primary_select  form-control{{ $errors->has('track_type_id') ? ' is-invalid' : '' }}"
                                name="track_type_id[]" id="track_type_id">


                            </select>

                            @if ($errors->has('track_type_id'))
                                <span class="text-danger invalid-select" role="alert">
                                    {{ $errors->first('track_type_id') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-3">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">
                                @lang('academics.tracks')
                            </label>
                            <select class="primary_select form-control {{ $errors->has('track_id') ? 'is-invalid' : '' }}"
                                name="track_id[]" id="track_id">

                            </select>

                            @if ($errors->has('track_id'))
                                <span class="text-danger invalid-select" role="alert">
                                    {{ $errors->first('track_id') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-3 mb-20">
                        <div class="primary_input">
                            <label class="primary_input_label" for="session">@lang('academics.session')</label>
                            <select class="form-control session staff_id" name="session" id="session">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 mb-20">
                        <div class="primary_input">
                            <label class="primary_input_label" for="scheduled">@lang('academics.schedule')</label>
                            <select class="form-control scheduled staff_id" name="scheduled" id="scheduled">

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 mb-20">
                        <div class="primary_input">
                            <label class="primary_input_label" for="start_date">@lang('academics.start_date')</label>
                            <input type="date" min="{{ date('Y-m-d') }}" class="form-control staff_id"
                                name="start_date" id="start_date">
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-3 mb-20">
                        <div class="primary_input">
                            <label class="primary_input_label" for="end_date">@lang('academics.end_date')</label>
                            <input type="date" min="{{ date('Y-m-d') }}" class="form-control staff_id"
                                id="end_date" disabled>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 mb-20">
                        <div class="primary_input">
                            <label class="primary_input_label" for="staff_id">@lang('hr.staff')</label>
                            <select class="form-control staff_id" name="staff_id" id="staff_id">

                            </select>
                        </div>
                    </div>

                  
                </div>
                <div class="row">
                    <div class="col-md-12 mb-20">
                        <div id="slotContainer">

                        </div>

                    </div>
                    <div class="col-md-12 mb-20">
                        <div id="submitAssignStaff">

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3 mt-3 d-flex justify-content-between align-items-center">
            <div class="">
                <h3 class="mb-0">
                    @lang('common.assigned_students')</h3>
            </div>
            <div class="">
                <button class="primary-btn small fix-gr-bg"id="assign_student">
                    <span class="ti-plus pr-2"></span>
                    @lang('common.add')
                </button>
            </div>

        </div>
        <div class="container-fluid p-0 ">



            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">

                        <div class="table-responsive">
                            <x-table>
                                <table id="table_id" class="table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('academics.student_name')</th>
                                            <th>@lang('common.action')</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($course_students as $course_student)
                                            <tr>
                                                <td>{{ $course_student->student->full_name }}</td>
                                                <td>
                                                    <x-drop-down>
                                                        {{-- 

                                                        @if (userPermission(''))
                                                            <a class="dropdown-item" href="">
                                                                @lang('common.edit')
                                                            </a>
                                                        @endif --}}
                                                        @if (userPermission('course_students_delete'))
                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#deletecourse_studentsModal{{ $course_student->id }}"
                                                                href="#">@lang('common.delete')</a>
                                                        @endif
                                                    </x-drop-down>
                                                </td>
                                            </tr>
                                            <div class="modal fade admin-query"
                                                id="deletecourse_studentsModal{{ $course_student->id }}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">@lang('common.course_students_delete')</h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="text-center">
                                                                <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                            </div>

                                                            <div class="mt-40 d-flex justify-content-between">
                                                                <button type="button" class="primary-btn tr-bg"
                                                                    data-dismiss="modal">@lang('common.cancel')</button>
                                                                {{ Form::open(['route' => ['course_students_delete', $course_student->id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                                <button class="primary-btn fix-gr-bg"
                                                                    type="submit">@lang('common.delete')</button>
                                                                {{ Form::close() }}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </x-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container-fluid p-0 mt-5">
         
            <div class="white-box">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="">

                            <h3 class="mb-15">    @lang('hr.slots')</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Schedule Table -->
                        <x-table>
                            <table id="table_id" class="table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>@lang('hr.slot_day')</th>
                                        <th>@lang('hr.slot_start')</th>
                                        <th>@lang('hr.slot_end')</th>
                                        <th>@lang('hr.date')</th>
                                        <th>@lang('hr.staff_name')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tableData as $row)
                                        <tr>
                                            <td>{{ $row['slot_day'] }}</td>
                                            <td>{{ formatTime($row['slot_start']) }}</td>
                                            <td>{{ formatTime($row['slot_end']) }}</td>
                                            <td>{{ $row['date'] }}</td>
                                            <td>
                                                <select class="primary_select">
                                                    <option value="{{ $row['staff_id'] }}">{{ $row['staff_name'] }}
                                                    </option>
                                                    <!-- Add more options dynamically if needed -->
                                                </select>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">@lang('common.no_data_available')</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </x-table>

                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
@include('backEnd.partials.data_table_js')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var $locale = '{{ app()->getLocale() }}';
        var course_details = @json($course);
        var courseSlotIds = JSON.parse(course_details.slot_id); // Parse JSON string into an array
        console.log("Course Slot IDs:", courseSlotIds);

        function fetchTracksAndTrackType() {
            const catId = $('#category_id').val();
            const trackSelect = $('#track_id');
            const trackTypeSelect = $('#track_type_id');

            $.ajax({
                url: '/tracks-by-category/' + catId,
                type: 'GET',
                success: function(data) {
                    let trackOptions = '';
                    let trackTypeOptions = '';

                    data.tracks.forEach(function(track) {
                        const optionText = ($locale === 'en') ? track.name_en : track
                            .name_ar;
                        const selected = (course_details.track_id === track.id) ? 'selected' : '';
                        trackOptions +=
                            `<option value="${track.id}" data-level="${track.level_number}" ${selected}>${optionText}</option>`;
                    });

                    data.valid_for.forEach(function(validFor) {
                        trackTypeOptions +=
                            `<option value="${validFor.id}" ${validFor.id == course_details.track_type_id ? 'selected' : ''}>${validFor.name}</option>`;
                    });

                    trackSelect.html(trackOptions);
                    trackTypeSelect.html(trackTypeOptions);

                    trackSelect.niceSelect('update');
                    trackTypeSelect.niceSelect('update');

                    fetchStaffData(data.tracks.find(track => track.id === course_details.track_id));
                },
                error: function() {
                    alert('Failed to fetch tracks. Please try again.');
                }
            });
        }

        function fetchStaffData(selectedTrack) {
            if (!selectedTrack) return;

            $.ajax({
                url: '{{ route('getStaffByTrack') }}',
                method: 'GET',
                data: {
                    track_id: selectedTrack.id
                },
                success: function(response) {
                    $('#session').empty().append(
                        `<option value="${response.track.session}">${response.track.session}</option>`);

                    $('#scheduled').empty().append('<option value="">@lang('academics.select_schedule') *</option>');

                    const schedules = ["once", "twice"];
                    let scheduleOptions = '';
                    schedules.forEach(function(schedule) {
                        const selected = (schedule === response.track.schedule) ? 'selected' : '';
                    console.log('selected',selected);

                        scheduleOptions +=
                            `<option value="${schedule}" ${selected}>${schedule}</option>`;
                    });

                    $('#scheduled').append(scheduleOptions);

                    $('#start_date').val(course_details.start_date);
                    $('#end_date').val(course_details.end_date);

                    $('#staff_id').empty();

                    // Check if the response contains staff data
                    if (response && response.staff && response.staff.length > 0) {

                        // Loop through the staff data and append each staff as an option
                        $.each(response.staff, function(index, staff) {
                            console.log(
                                staff.id); // Log each staff to check its properties
                            var staffName = staff
                                .staff_name; // Access 'staff_name' from the staff object
                            var staffId = staff
                                .staff_id; // Access 'staff_id' from the staff object
                            var selected_item = staff.id == course_details.staff_id ? 'selected' :
                                ''; // Access 'staff_id' from the staff object
                            $('#staff_id').append('<option ' + selected_item + 'value="' + staffId +
                                '">' + staffName + '</option>');
                        });
                    } else {    
                        // If no staff found, add a default option
                        $('#staff_id').append(
                            '<option value="">@lang('academics.no_staff_found')</option>'
                        );
                    }

                    getSlotsTime();

                },
                error: function() {
                    alert('Failed to fetch staff data.');
                }
            });
        }

        function getSlotsTime() {
            let staff_id = course_details.staff_id;

            $.ajax({
                url: '{{ route('getSlotsByStaff') }}', // The route you created in your routes/web.php
                method: 'GET',
                data: {
                    staff_id: staff_id,
                },
                success: function(response) {


                    // Check if slots exist in the response
                    if (response.slots && response.slots.length > 0) {
                        // Group slots by day
                        const days = [...new Set(response.slots.map(slot => slot
                            .slot_day))]; // Get unique days
                        const slotsByDay = {};
                        days.forEach(day => {
                            slotsByDay[day] = response.slots.filter(slot => slot
                                .slot_day === day);
                        });

                        // Get unique time slots and convert to AM/PM
                        const timeSlots = [...new Set(response.slots.map(slot =>
                                `${slot.slot_start} - ${slot.slot_end}`))]
                            .map(time => {
                                const [start, end] = time.split(" - ");
                                return `${convertToAmPm(start)} - ${convertToAmPm(end)}`;
                            });
                        // Create the Bootstrap layout dynamically
                        let scheduleHTML =
                            '<hr><div class="container-fluid"><div class="row">';

                        days.forEach((day, index) => {
                            // Add a column for each day
                            scheduleHTML += `
                                            <div class="col-md-2 mb-4">
                                                <h5 class="mb-3">${day}</h5>
                                                <div class="time-slots">
                                        `;

                            // Loop through time slots
                            timeSlots.forEach(time => {
                                const originalTime = time
                                    .split(" - ")
                                    .map(t => convertTo24Hour(t))
                                    .join(" - ");

                                const slot = slotsByDay[day]?.find(
                                    s =>
                                    `${s.slot_start} - ${s.slot_end}` === originalTime
                                );

                                const isChecked = slot && courseSlotIds.includes(slot.id
                                    .toString()); // Check if slot.id exists in courseSlotIds
                                const isDisabled = slot ? (slot.status === "scheduled" ?
                                    "disabled" : "") : "disabled";

                                scheduleHTML += `
                                    <div class="form-check mb-2" style="
                                    background-color: ${isChecked  ? "#fff4cb" : ""};
                                    background-color: ${slot && slot.status !== "scheduled" ? "#fff4cb" : ""};
                                    color: ${slot && slot.status !== "scheduled" ? "#000" : "#444"};"
                                    >
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            name="slot[${day}][]" 
                                            data-slot-id="${slot ? slot.id : ''}" 
                                            ${isChecked ? "checked" : ""} 
                                            ${isChecked ? '' :isDisabled}
                                        >
                                        <label class="form-check-label">${time}</label>
                                    </div>
                                `;
                            });

                            // Close time-slots and column
                            scheduleHTML += `
                                                </div> <!-- End of time-slots -->
                                            </div> <!-- End of col-md-3 -->
                                        `;

                            // Close and start a new row after every 4 columns
                            if ((index + 1) % 6 === 0 && index !== days.length -
                                1) {
                                scheduleHTML += '</div><div class="row">';
                            }
                        });

                        // Close the last row and container
                        scheduleHTML += '</div></div><hr>';

                        // Append the schedule to the DOM
                        $("#slotContainer").html(scheduleHTML);
                        $("#submitAssignStaff").html(
                            `<button class="primary-btn fix-gr-bg" onclick="submitAssignedForm()">{{ __('common.update_information') }}</button>`
                        );
                        $('#loadrer').fadeOut(300)

                    } else {
                        console.warn("No slots found for the selected staff.");
                    }
                },
                error: function() {
                    alert('Failed to fetch staff data.');
                }
            });
        }

        $(document).ready(function() {

            // Listen for changes on the category dropdown
            $('#category_id').on('change', function() {
                $('#checkbox-container').addClass('d-none');

                var catId = $(this).val(); // Get selected category ID
                const trackSelect = $('#track_id');
                const trackTypeSelect = $('#track_type_id');

                if (catId) {
                    // Make AJAX request to fetch tracks
                    $.ajax({
                        url: '/tracks-by-category/' + catId,
                        type: 'GET',
                        success: function(data) {
                            console.log(data);

                            // Clear the tracks dropdown
                            trackSelect.empty();
                            trackTypeSelect.empty();
                            trackSelect.append("<option>Select Track</option>")

                            // Populate the dropdown with the fetched tracks
                            data.tracks.forEach(function(track) {
                                var optionText = ($locale === 'en') ?
                                    track.name_en :
                                    track.name_ar;

                                trackSelect.append(
                                    '<option value="' + track.id +
                                    '" data-level="' + track.level_number + '">' +
                                    optionText + '</option>'
                                );
                            });
                            trackTypeSelect.append("<option>Select Track Type</option>")

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
                    // Clear the tracks dropdown if no category is selected
                    $('#track_id').empty();
                }
            });

            $('#track_id').on('change', function() {


                // Make an AJAX request to fetch the filtered staff data
                $.ajax({
                    url: '{{ route('getStaffByTrack') }}', // The route you will create in your routes/web.php
                    method: 'GET',
                    data: {
                        track_id: $(this).val(),
                    },
                    success: function(response) {
                        console.log(response); // Log the response to check its structure

                        // Populate session options
                        $('#session').empty(); // Clear any previous session options
                        $('#session').append(
                            `<option value="${response.track.session}">${response.track.session}</option>`
                        );



                        // Populate schedule options (once or twice)
                        $('#scheduled').empty(); // Clear previous schedule options
                        $('#scheduled').append(
                            '<option value="">@lang('academics.select_schedule') *</option>'
                        );

                        // Add the available schedules based on the response
                        var schedules = ["once", "twice"];
                        $.each(schedules, function(index, schedule) {
                            var selected = (schedule === response.track.schedule) ?
                                'selected' :
                                ''; // Check if this schedule matches the response
                            $('#scheduled').append('<option value="' + schedule + '" ' +
                                selected + '>' + schedule + '</option>');
                        });

                        // Clear the previous staff options
                        $('#staff_id').empty();

                        // Check if the response contains staff data
                        if (response && response.staff && response.staff.length > 0) {
                            console.log(response.track); // Log the track details

                            // Add an empty option for staff selection
                            $('#staff_id').append(
                                '<option data-display="@lang('hr.select_staff') *" value="">@lang('hr.select_staff') *</option>'
                            );

                            // Loop through the staff data and append each staff as an option
                            $.each(response.staff, function(index, staff) {
                                console.log(
                                    staff); // Log each staff to check its properties
                                var staffName = staff
                                    .staff_name; // Access 'staff_name' from the staff object
                                var staffId = staff
                                    .staff_id; // Access 'staff_id' from the staff object
                                $('#staff_id').append('<option value="' + staffId +
                                    '">' + staffName + '</option>');
                            });
                        } else {
                            // If no staff found, add a default option
                            $('#staff_id').append(
                                '<option value="">@lang('academics.no_staff_found')</option>'
                            );
                        }
                    },


                    error: function() {
                        // Handle error
                        alert('Failed to fetch staff data.');
                    }
                });
            });

            $('#staff_id').on('change', function() {
                $.ajax({
                    url: '{{ route('getSlotsByStaff') }}', // The route you created in your routes/web.php
                    method: 'GET',
                    data: {
                        staff_id: $(this).val(),
                    },
                    success: function(response) {


                        // Check if slots exist in the response
                        if (response.slots && response.slots.length > 0) {
                            // Group slots by day
                            const days = [...new Set(response.slots.map(slot => slot
                                .slot_day))]; // Get unique days
                            const slotsByDay = {};
                            days.forEach(day => {
                                slotsByDay[day] = response.slots.filter(slot => slot
                                    .slot_day === day);
                            });

                            // Get unique time slots and convert to AM/PM
                            const timeSlots = [...new Set(response.slots.map(slot =>
                                    `${slot.slot_start} - ${slot.slot_end}`))]
                                .map(time => {
                                    const [start, end] = time.split(" - ");
                                    return `${convertToAmPm(start)} - ${convertToAmPm(end)}`;
                                });
                            // Create the Bootstrap layout dynamically
                            let scheduleHTML =
                                '<hr><div class="container-fluid"><div class="row">';

                            days.forEach((day, index) => {
                                // Add a column for each day
                                scheduleHTML += `
                                            <div class="col-md-2 mb-4">
                                                <h5 class="mb-3">${day}</h5>
                                                <div class="time-slots">
                                        `;

                                // Loop through time slots
                                timeSlots.forEach(time => {
                                    const originalTime = time
                                        .split(" - ")
                                        .map(t => convertTo24Hour(t))
                                        .join(" - ");

                                    const slot = slotsByDay[day]?.find(
                                        s =>
                                        `${s.slot_start} - ${s.slot_end}` ===
                                        originalTime
                                    );
                                    scheduleHTML += `
                                            <div class="form-check mb-2" style="background-color: ${slot && slot.status !== "scheduled" ? "#fff4cb" : "transparent"};
                                            color: ${slot && slot.status !== "scheduled" ? "#000" : "#444"};">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    name="slot[${day}][]" 
                                                    data-slot-id="${slot ? slot.id : ''}" 
                                                    ${slot ? (slot.status === "scheduled" ? "disabled" : "") : "disabled"}
                                                >
                                                <label class="form-check-label">${time}</label>
                                            </div>
                                        `;

                                });

                                // Close time-slots and column
                                scheduleHTML += `
                                                </div> <!-- End of time-slots -->
                                            </div> <!-- End of col-md-3 -->
                                        `;

                                // Close and start a new row after every 4 columns
                                if ((index + 1) % 6 === 0 && index !== days.length -
                                    1) {
                                    scheduleHTML += '</div><div class="row">';
                                }
                            });

                            // Close the last row and container
                            scheduleHTML += '</div></div><hr>';

                            // Append the schedule to the DOM
                            $("#slotContainer").html(scheduleHTML);
                            $("#submitAssignStaff").html(
                                `<button class="primary-btn fix-gr-bg" onclick="submitAssignedForm()">{{ __('common.update_information') }}</button>`
                                );

                        } else {
                            console.warn("No slots found for the selected staff.");
                        }
                    },
                    error: function() {
                        alert('Failed to fetch staff data.');
                    }
                });
            });

        });
        $(document).ready(function() {
            fetchTracksAndTrackType();
            $('#assign_student').click(function(event) {
                event.preventDefault();
                $('#assing_modal').modal('show');
            });
        });
    </script>



    <script>
        // Helper function to convert time to AM/PM format
        function convertToAmPm(time) {
            const [hour, minute, second] = time.split(":").map(Number);
            const ampm = hour >= 12 ? "PM" : "AM";
            const formattedHour = hour % 12 || 12; // Convert 0 to 12 for 12-hour format
            return `${formattedHour}:${minute.toString().padStart(2, "0")} ${ampm}`;
        }

        // Helper function to convert time from AM/PM to 24-hour format
        function convertTo24Hour(time) {
            const [hourPart, minutePart] = time.split(":");
            const [minute, ampm] = minutePart.split(" ");
            let hour = parseInt(hourPart, 10);
            if (ampm === "PM" && hour !== 12) hour += 12;
            if (ampm === "AM" && hour === 12) hour = 0;
            return `${hour.toString().padStart(2, "0")}:${minute}:00`;
        }

        // Function to calculate the end date based on the selected session and schedule
        function calculateEndDate() {
            // Get the selected start date, session, and schedule
            var startDate = $('#start_date').val();
            var sessionCount = $('#session').val();
            var schedule = $('#scheduled').val();
            console.log(sessionCount, schedule, startDate);

            // If any required field is missing, disable the end date field and return
            if (!startDate || !sessionCount || !schedule) {
                $('#end_date').prop('disabled', true);
                return;
            }

            // Convert the start date to a JavaScript Date object
            var start = new Date(startDate);

            // Calculate the end date based on the schedule
            var endDate = new Date(start);

            if (schedule === "once") {
                // If "once" (sessions are once a week), add (sessionCount - 1) weeks
                endDate.setDate(start.getDate() + (sessionCount - 1) * 7); // 7 days per week
            } else if (schedule === "twice") {
                // If "twice" (sessions are twice a week), calculate based on 2 sessions per week
                var weeksRequired = Math.ceil(sessionCount / 2); // Calculate the number of weeks needed
                console.log(weeksRequired);

                endDate.setDate(start.getDate() + (weeksRequired - 1) * 7); // Add weeks to the start date
            }

            // Set the calculated end date and enable the input field
            $('#end_date').val(endDate.toISOString().split('T')[0]); // Format the date as YYYY-MM-DD
        }
        // Event listeners for changes to the start date, session, and schedule
        $('#start_date, #scheduled').on('change', function() {
            calculateEndDate(); // Call the function to calculate the end date
        });

        function submitAssignedForm() {
            let course_name_en = $('#course_name_en').val();
            let course_name_ar = $('#course_name_ar').val();
            let category_id = $('#category_id').val();
            let track_type_id = $('#track_type_id').val();
            let track_id = $('#track_id').val();
            let session = $('#session').val();
            let schedule = $('#scheduled').val();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            let staff_id = $('#staff_id').val();
            
            // Fetch the selected slots (checkboxes with name like 'slot[day][]')
            let selectedSlots = [];
            $('input[name^="slot"]').each(function() {
                if ($(this).is(':checked')) {
                    selectedSlots.push($(this).data('slot-id'));
                }
            });

            // Log or use the selectedSlots array (this will contain all checked slot IDs)
            console.log('Selected Slots:', selectedSlots);

            // Prepare form data
            let formData = {
                staff_scheduled_id: course_details.id,
                course_name_en: course_name_en,
                course_name_ar: course_name_ar,
                category_id: category_id,
                track_type_id: track_type_id,
                track_id: track_id,
                session: session,
                schedule: schedule,
                start_date: start_date,
                end_date: end_date,
                staff_id: staff_id,
                selected_slots: selectedSlots, // Include the selected slots
                _token: '{{ csrf_token() }}' // CSRF token from meta tag
            };

            // AJAX request to save event to the database
            $.ajax({
                url: '{{ route('scheduleStaffEvent') }}', // Your backend route for saving the event
                method: 'POST', // Use POST method to submit form data
                data: formData, // Send form data including the CSRF token
                success: function(response) {
                    Swal.fire({
                        title: "Good job!",
                        text: "You clicked the button!",
                        icon: "success"
                    });

                },
                error: function(error) {
                    alert('Error saving event: ' + error.message);
                }
            });
        }
    </script>
@endpush
@include('backEnd.partials.data_table_js')

<style>
    .list-inline .badge {
        font-size: 14px;
        font-weight: 500;
    }

    /* Scheduled events */
    .fc-daygrid-event.event-scheduled {
        background-color: #4CAF50;
        /* Green */
        border-color: #4CAF50;
    }

    /* Started events */
    .fc-daygrid-event.event-started {
        background-color: #FF9800;
        /* Orange */
        border-color: #FF9800;
    }

    /* Ended events */
    .fc-daygrid-event.event-ended {
        background-color: #F44336;
        /* Red */
        border-color: #F44336;
    }

    /* Available events */
    .fc-daygrid-event.event-available {
        background-color: #2196F3;
        /* Blue */
        border-color: #2196F3;
    }

    /* For events when hovering over */
    .fc-daygrid-event.event-scheduled:hover,
    .fc-daygrid-event.event-started:hover,
    .fc-daygrid-event.event-ended:hover,
    .fc-daygrid-event.event-available:hover {
        opacity: 0.8;
        /* Slightly transparent when hovered */
    }

    .staff_id {
        font-size: 12px !important;
        min-height: 45px;
        color: #415094 !important;
        border: 1px solid #d4d4d4 !important;
    }

    .fc-event-title-container {
        color: #000 !important
    }

.loaderw {
    position: relative;
}
    .loadrer {
        position: absolute;
        background: #ffffffad;
    width: 100%;
    height: 100%;
    z-index: 1;
    top: 0;
    left: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    }
</style>
