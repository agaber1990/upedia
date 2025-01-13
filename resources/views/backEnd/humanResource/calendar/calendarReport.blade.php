@extends('backEnd.master')
@section('title')
    @lang('hr.calendar_report')
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
                <h1>@lang('hr.calendar_report')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('hr.human_resource')</a>
                    <a href="#">@lang('hr.calendar_report')</a>
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
                            <div class="col-lg-6 col-xl-3 ">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="">@lang('common.categories')
                                    </label>
                                    <select
                                        class="primary_select  form-control {{ $errors->has('cat_id') ? ' is-invalid' : '' }}"
                                        name="cat_id" id="cat_id">
                                        <option data-display="@lang('common.categories') *" value="">@lang('common.categories')
                                            *</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">
                                                {{ app()->getLocale() == 'en' ? $item->name_en : $item->name_ar }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('cat_id'))
                                        <span class="text-danger invalid-select" role="alert">
                                            {{ $errors->first('cat_id') }}
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
                                    <select
                                        class="primary_select form-control {{ $errors->has('track_id') ? 'is-invalid' : '' }}"
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
                                    <label class="primary_input_label" for="staff_id">@lang('hr.staff')</label>
                                    <select class="form-control staff_id" name="staff_id" id="staff_id">

                                    </select>
                                </div>
                            </div>

                        </div>
                        <!-- Filter Section -->





                        <hr>

                        <div id="calendar"></div>



                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
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
</style>


@push('scripts')
    <!-- Include jQuery -->
    <!-- Include jQuery -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

@push('scripts')
    <script>
        var $locale = '{{ app()->getLocale() }}';
        $(document).ready(function() {

            // Listen for changes on the category dropdown
            $('#cat_id').on('change', function() {
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
                            // Clear the tracks dropdown
                            trackSelect.empty();
                            trackTypeSelect.empty();
                            trackSelect.append("<option>Select Track</option>")

                            // Populate the dropdown with the fetched tracks
                            data.tracks.forEach(function(track) {
                                var optionText = ($locale === 'en') ?
                                    track.track_name_en :
                                    track.track_name_ar;

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
                            '<option value="">@lang('academics.select_session') *</option>'
                        );

                        // Loop from 1 to 30 and create options for the session dropdown
                        for (var i = 1; i <= 30; i++) {
                            var selected = (i === response.track.session) ? 'selected' :
                                ''; // Check if this session matches the response
                            $('#session').append('<option value="' + i + '" ' + selected + '>' +
                                i + '</option>');
                        }

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
                    url: '{{ route('getSlotsByStaffReport') }}', // The route for fetching slots
                    method: 'GET',
                    data: {
                        staff_id: $(this).val(),
                    },
                    success: function(response) {
                        console.log(response); // Log the response for debugging

                        // Ensure the calendar object is initialized
                        if (!calendar) {
                            console.error("Calendar object is not initialized.");
                            return;
                        }

                        // Clear existing events in the calendar
                        calendar.removeAllEvents();

                        // Check if slots exist in the response
                        if (response.slots && response.slots.length > 0) {
                            response.slots.forEach(function(slot) {
                                let dow = getDayOfWeek(slot
                                    .slot_day); // Convert day name to number

                                // Format start and end times for the calendar (in 24-hour format)
                                let startTime = formatTimeForCalendar(slot.slot_start,
                                    slot.slot_day);
                                let endTime = formatTimeForCalendar(slot.slot_end, slot
                                    .slot_day);

                                // Format start and end times to 12-hour format for display
                                let formattedStart = formatTo12HourTime(slot
                                    .slot_start);
                                let formattedEnd = formatTo12HourTime(slot.slot_end);

                                // Determine event color based on slot status
                                let eventColor = getStatusColor(slot.status);

                                if (slot.status === 'scheduled' && slot.start_date &&
                                    slot.end_date) {
                                    // Generate events for all dates between start_date and end_date
                                    let currentDate = new Date(slot.start_date);
                                    const endDate = new Date(slot.end_date);

                                    while (currentDate <= endDate) {
                                        // Add the slot as an event for each date
                                        if (currentDate.getDay() === dow) {
                                            calendar.addEvent({
                                                slot_id: `${slot.id}`, // Unique identifier for the slot
                                                title: `${slot.status}: ${formattedStart} - ${formattedEnd}`,
                                                start: `${formatDate(currentDate)}`, // Start datetime
                                                end: `${formatDate(currentDate)}`, // End datetime
                                                description: `${slot.slot_day} ${formattedStart} - ${formattedEnd}`,
                                                overlap: true, // Allow overlap with other events
                                                display: true,
                                                backgroundColor: eventColor, // Background color based on status
                                                borderColor: eventColor, // Border color based on status
                                                textColor: '#fff', // Ensure good contrast for text
                                            });
                                        }
                                        currentDate.setDate(currentDate.getDate() +
                                            1); // Move to the next day
                                    }
                                } else if (slot.status === 'available') {
                                    // Add the slot as a recurring weekly event
                                    calendar.addEvent({
                                        slot_id: `${slot.id}`, // Unique identifier for the slot
                                        title: `${slot.status}: ${formattedStart} - ${formattedEnd}`,
                                        start: startTime, // Slot start time in 24-hour format
                                        end: endTime, // Slot end time in 24-hour format
                                        daysOfWeek: [
                                            dow
                                        ], // Day of the week the slot applies to
                                        description: `${slot.slot_day} ${formattedStart} - ${formattedEnd}`,
                                        overlap: true, // Allow overlap with other events
                                        display: true,
                                        backgroundColor: eventColor, // Background color based on status
                                        borderColor: eventColor, // Border color based on status
                                        textColor: '#fff', // Ensure good contrast for text
                                    });
                                }
                            });
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
    </script>

    <script>
        // Helper function to convert time to AM/PM format
        function convertToAmPm(time) {
            const [hour, minute, second] = time.split(":").map(Number);
            const ampm = hour >= 12 ? "PM" : "AM";
            const formattedHour = hour % 12 || 12; // Convert 0 to 12 for 12-hour format
            return `${formattedHour}:${minute.toString().padStart(2, "0")} ${ampm}`;
        }
// Format date to YYYY-MM-DD
function formatDate(date) {
    return date.toISOString().split('T')[0];
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
        // Listen for changes on the category dropdown


        // Declare calendar globally
        let calendar = null;

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            // Ensure the calendar element exists before initializing
            if (calendarEl) {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridWeek',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'timeGridWeek,timeGridDay'
                    },
                    // Option to customize event time format
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        meridiem: 'short' // Optional: 'AM/PM' format
                    },
                    events: [], // Start with an empty set of events, will be populated dynamically
                    eventClick: function(info) {
                        // When an event is clicked, open the scheduling dialog
                        handleEventClick(info);
                    }
                });

                calendar.render();
            } else {
                console.error("Calendar element not found.");
            }
        });

        // Handle the event click for scheduling
        // Handle the event click for scheduling
        function handleEventClick(info) {
            const event = info.event;
            console.log(info.event);

            const from_date = info.event.start;
            const formattedDate = new Intl.DateTimeFormat('en-CA', {
                timeZone: 'Africa/Cairo', // Set the timezone to Egypt
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).format(from_date);


            // Extract event details
            const eventTitle = event.title; // Available time title
            const slot_id = event.extendedProps.slot_id; // Slot ID
            const staff_id = $('#staff_id').val(); // Staff ID (from the input field)
            console.log(slot_id, staff_id);

            // Use SweetAlert2 to prompt user for confirmation and date selection
            Swal.fire({
                title: 'Staff Slot Make It Scheduled',
                html: `
                    <p style="margin-bottom: 14px;">Do you want to schedule: <strong>${eventTitle}</strong></p>
                    `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Got it!',
                cancelButtonText: 'No, cancel',
                reverseButtons: true,
                didOpen: () => {
                    // Assign the event's start date to the "From" date input field using jQuery


                }
            }).then((result) => {
                // Check if both dates and status are selected
                if (result.isConfirmed && status) {
                    // If confirmed and all required fields are selected, call the save function
                    Swal.fire({
                        title: "Good job!",
                        text: "You clicked the button!",
                        icon: "success"
                    });

                } else if (!status) {
                    // If any field is not selected, show an error message
                    Swal.fire(
                        'Error',
                        'Please select both From and To dates, and a status to schedule the event.',
                        'error'
                    );
                } else {
                    // If canceled, show a message or take another action
                    Swal.fire(
                        'Cancelled',
                        'The event was not scheduled.',
                        'error'
                    );
                }
            });
        }






        // Helper function to convert day name to its corresponding day of the week (0-6)
        function getDayOfWeek(dayName) {
            const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            return days.indexOf(dayName.toLowerCase());
        }

        // Helper function to format the time for FullCalendar (24-hour to FullCalendar format)
        function formatTimeForCalendar(time, day) {
            let currentYear = new Date().getFullYear();
            let currentMonth = ('0' + (new Date().getMonth() + 1)).slice(-2); // Month is 0-based
            let currentDay = new Date().getDate();

            // Assuming the slot day is always a valid day name and the time is in HH:mm format
            return `${currentYear}-${currentMonth}-${currentDay}T${time}:00`;
        }

        function formatTo12HourTime(timeString) {
            // Split the time string into hours, minutes, and seconds
            let [hours, minutes, seconds] = timeString.split(':');

            // Convert to 12-hour format
            hours = parseInt(hours);
            let period = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // Handle 0 as 12

            // Return formatted time string
            return `${hours}:${minutes} ${period}`;
        }


        // Function to get color based on event status
        function getStatusColor(status) {
            switch (status) {
                case 'available':
                    return '#fff3cb'; // Blue
                case 'scheduled':
                    return '#cfe2f3'; // Green
                case 'started':
                    return '#FF9800'; // Orange
                case 'ended':
                    return '#F44336'; // Red
                case 'reserved':
                    return '#00BCD4'; // Cyan
                default:
                    return '#9E9E9E'; // Grey for unknown statuses
            }
        }

        // Example of formatTimeForCalendar function to convert time to FullCalendar format
        function formatTimeForCalendar(time, dayOfWeek) {
            // Implement your logic to convert the time to FullCalendar's format (e.g., HH:mm)
            return `${dayOfWeek}T${time}`;
        }
        // Function to calculate the end date based on the selected session and schedule
        function calculateEndDate() {
            // Get the selected start date, session, and schedule
            var startDate = $('#start_date').val();
            var sessionCount = parseInt($('#session').val());
            var schedule = $('#scheduled').val();

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
                // If "twice" (sessions are twice a week), add (sessionCount / 2) weeks
                endDate.setDate(start.getDate() + (sessionCount / 2 - 1) * 7); // 7 days per week
            }

            // Set the calculated end date and enable the input field
            $('#end_date').val(endDate.toISOString().split('T')[0]); // Format the date as YYYY-MM-DD
        }
        // Event listeners for changes to the start date, session, and schedule
        $('#start_date, #session, #scheduled').on('change', function() {
            calculateEndDate(); // Call the function to calculate the end date
        });
    </script>
@endpush
