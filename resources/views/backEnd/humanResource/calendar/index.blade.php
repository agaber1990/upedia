@extends('backEnd.master')
@section('title')
    @lang('hr.calendar')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('hr.calendar')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('hr.human_resource')</a>
                    <a href="#">@lang('hr.calendar')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid p-0">

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">

                        <!-- Filter Section -->
                        <div class="row">
                            <div class="col-lg-6 col-xl-3 mb-20">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="">@lang('common.categories')</label>
                                    <select class="primary_select form-control" name="cat_id" id="cat_id">
                                        <option data-display="@lang('common.categories') *" value="">@lang('common.categories') *
                                        </option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">
                                                {{ app()->getLocale() == 'en' ? $item->name_en : $item->name_ar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xl-3 mb-20">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="">@lang('academics.track_types')</label>
                                    <select class="primary_select form-control" name="track_type_id" id="track_type_id">
                                        <option data-display="@lang('academics.track_types') *" value="">@lang('academics.track_types') *
                                        </option>
                                        @foreach ($track_types as $track)
                                            <option value="{{ $track->id }}">{{ $track->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="col-lg-6 col-xl-3 mb-20">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="">@lang('academics.tracks')</label>
                                    <select class="primary_select form-control" name="track_id" id="track_id"
                                        onchange="getTrackId(this.value)">
                                        <option data-display="@lang('academics.tracks') *" value="">@lang('academics.tracks') *
                                        </option>
                                        @foreach ($tracks as $track)
                                            <option value="{{ $track->id }}">
                                                {{ app()->getLocale() == 'en' ? $track->track_name_en : $track->track_name_ar }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xl-3 mb-20">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="staff_id">@lang('hr.staff')</label>
                                    <select class="form-control" name="staff_id" id="staff_id"
                                        onchange="getStaffId(this.value)">
                                        <option data-display="@lang('hr.staff') *" value="">@lang('hr.staff') *
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <!-- Legend -->
                        <div class="mt-4 mb-3">
                            <ul class="list-inline">
                                <li class="list-inline-item"><button
                                        class="btn btn-success btn-sm">@lang('hr.available')</button>
                                </li>
                                <li class="list-inline-item"><button
                                        class="btn btn-primary btn-sm">@lang('hr.scheduled')</button>
                                </li>
                                <li class="list-inline-item"><button class="btn btn-info btn-sm">@lang('hr.reserved')</button>
                                </li>
                                <li class="list-inline-item"><button
                                        class="btn btn-warning btn-sm">@lang('hr.started')</button>
                                </li>
                                <li class="list-inline-item"><button
                                        class="btn btn-danger btn-sm">@lang('hr.ended')</button></li>
                            </ul>
                        </div>
                        <hr>
                        <!-- Calendar Section -->
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
</style>
@push('scripts')
    <!-- Include jQuery -->
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
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

            // Extract event details
            const eventTitle = event.title; // Available time title
            const slot_id = event.extendedProps.slot_id; // Slot ID
            const staff_id = $('#staff_id').val(); // Staff ID (from the input field)
            console.log(slot_id, staff_id);

            // Use SweetAlert2 to prompt user for confirmation and date selection
            Swal.fire({
                title: 'Are you sure?',
                html: `
            <p style="margin-bottom: 14px;">Do you want to schedule: <strong>${eventTitle}</strong></p>
            <div class="row">
                <div class="form-group col-md-6">
                    <label style="font-size:14px">Select a From date</label>
                    <input type="text" id="fromDate" class="form-control" placeholder="From date" />
                </div>
                <div class="form-group col-md-6">
                    <label style="font-size:14px">Select a To date</label>
                    <input type="text" id="toDate" class="form-control" placeholder="To date" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label style="font-size:14px">Select status</label>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <input type="radio" name="status" value="available" id="statusAvailable" checked>
                            <label for="statusAvailable" class="btn btn-success btn-sm">Available</label>
                        </li>
                        <li class="list-inline-item">
                            <input type="radio" name="status" value="scheduled" id="statusScheduled">
                            <label for="statusScheduled" class="btn btn-primary btn-sm">Scheduled</label>
                        </li>
                        <li class="list-inline-item">
                            <input type="radio" name="status" value="reserved" id="statusReserved">
                            <label for="statusReserved" class="btn btn-info btn-sm">Reserved</label>
                        </li>
                        <li class="list-inline-item">
                            <input type="radio" name="status" value="started" id="statusStarted">
                            <label for="statusStarted" class="btn btn-warning btn-sm">Started</label>
                        </li>
                        <li class="list-inline-item">
                            <input type="radio" name="status" value="ended" id="statusEnded">
                            <label for="statusEnded" class="btn btn-danger btn-sm">Ended</label>
                        </li>
                    </ul>
                </div>
            </div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, schedule it!',
                cancelButtonText: 'No, cancel',
                reverseButtons: true,
                didOpen: () => {
                    // Initialize the date pickers for both "From" and "To" dates
                    flatpickr('#fromDate', {
                        dateFormat: 'Y-m-d', // Set the format (YYYY-MM-DD)
                        minDate: 'today', // Disable past dates
                        defaultDate: new Date().toISOString().split('T')[0], // Default to today's date
                    });
                    flatpickr('#toDate', {
                        dateFormat: 'Y-m-d', // Set the format (YYYY-MM-DD)
                        minDate: 'today', // Disable past dates
                        defaultDate: new Date().toISOString().split('T')[0], // Default to today's date
                    });
                }
            }).then((result) => {
                const fromDate = document.getElementById('fromDate').value; // Get "From" date
                const toDate = document.getElementById('toDate').value; // Get "To" date
                const status = document.querySelector('input[name="status"]:checked')?.value; // Get selected status

                // Check if both dates and status are selected
                if (result.isConfirmed && fromDate && toDate && status) {
                    // If confirmed and all required fields are selected, call the save function
                    saveScheduledEvent(fromDate, toDate, status, slot_id, staff_id);
                    Swal.fire({
                        title: "Good job!",
                        text: "You clicked the button!",
                        icon: "success"
                    });
                } else if (!fromDate || !toDate || !status) {
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



        // Save the scheduled event to the database
        function saveScheduledEvent(fromDate, toDate, status, slot_id, staff_id) {

            const eventData = {
                slot_id: slot_id,
                staff_id: staff_id,
                fromDate: fromDate,
                toDate: toDate,
                status: status,
            };
            console.log(eventData);

            // AJAX request to save event to the database
            $.ajax({
                url: '{{ route('scheduleStaffEvent') }}', // Your backend route for saving the event
                method: 'GET',
                data: eventData,
                success: function(response) {
                    console.log(response);

                },
                error: function(error) {
                    alert('Error saving event: ' + error.message);
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

        // Helper function to convert 24-hour time (HH:mm) to 12-hour time (HH:mm AM/PM)
        function formatTo12HourTime(time) {
            let [hour, minute] = time.split(':'); // Split the time into hour and minute
            let ampm = hour >= 12 ? 'PM' : 'AM'; // Determine AM or PM
            hour = (hour > 12) ? hour - 12 : hour; // Convert 24-hour to 12-hour format
            if (hour == 0) {
                hour = 12; // 12 AM for midnight
            }
            return `${hour}:${minute} ${ampm}`;
        }


        // This function is used to fetch staff slot data
        function getStaffId(staffID) {
            // Make an AJAX request to fetch the filtered staff data
            $.ajax({
                url: '{{ route('getSlotsByStaff') }}', // The route you created in your routes/web.php
                method: 'GET',
                data: {
                    staff_id: staffID,
                },
                success: function(response) {
                    console.log(response); // Log the response to check its structure

                    // Ensure calendar is available before calling any methods on it
                    if (calendar) {
                        // Clear existing events in the calendar
                        calendar.removeAllEvents();
                        console.log(response.staff.id);

                        // Add the fetched events (slots) to the calendar
                        response.slots.forEach(function(slot) {
                            let dow = getDayOfWeek(slot.slot_day); // Convert day name to number

                            // Get the start and end time in the correct format for FullCalendar
                            let startTime = formatTimeForCalendar(slot.slot_start, slot.slot_day);
                            let endTime = formatTimeForCalendar(slot.slot_end, slot.slot_day);

                            // Format start and end time to 12-hour format with AM/PM
                            let formattedStart = formatTo12HourTime(slot.slot_start);
                            let formattedEnd = formatTo12HourTime(slot.slot_end);

                            // Determine event color based on slot status
                            let eventColor = getStatusColor(slot.status);

                            // Add event to the calendar
                            calendar.addEvent({
                                slot_id: `${slot.id}`,
                                title: `${slot.status} Slot in ${formattedStart} - ${formattedEnd}`,
                                start: startTime, // Slot start time in 24-hour format for calendar
                                end: endTime, // Slot end time in 24-hour format for calendar
                                daysOfWeek: [dow],
                                description: `${slot.slot_day} ${formattedStart} - ${formattedEnd}`,
                                overlap: true,
                                display: true,
                                extendedProps: {
                                    staff_id: response.staff.id // Add staff_id here
                                },
                                backgroundColor: eventColor, // Set background color based on status
                                borderColor: eventColor, // Set border color based on status
                                textColor: '#fff', // Text color for better contrast
                            });
                        });
                    } else {
                        console.error("Calendar object is not initialized.");
                    }
                },
                error: function() {
                    alert('Failed to fetch staff data.');
                }
            });
        }

        // Function to get color based on event status
        function getStatusColor(status) {
            switch (status) {
                case 'available':
                    return '#080'; // Blue
                case 'scheduled':
                    return '#4CAF50'; // Green
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

        // Example of function to format to 12-hour time with AM/PM
        function formatTo12HourTime(time) {
            let date = new Date(`1970-01-01T${time}:00`);
            let hours = date.getHours();
            let minutes = date.getMinutes();
            let suffix = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            return `${hours}:${minutes} ${suffix}`;
        }


        function getTrackId(trackID) {
            var track_type_id = $('#track_type_id').val(); // Get the selected track type ID

            // Make an AJAX request to fetch the filtered staff data
            $.ajax({
                url: '{{ route('getStaffByTrack') }}', // The route you will create in your routes/web.php
                method: 'GET',
                data: {
                    track_id: trackID,
                    track_type_id: track_type_id,
                },
                success: function(response) {
                    console.log(response); // Log the response to check its structure
                    // Clear the previous staff options
                    $('#staff_id').empty();

                    // Check if the response contains staff
                    if (response && response.length > 0) {
                        // Add an empty option
                        $('#staff_id').append(
                            '<option data-display="@lang('hr.staff') *" value="">@lang('hr.staff') *</option>'
                        );

                        // Loop through the staff data and append each staff as an option
                        $.each(response, function(index, staff) {
                            console.log(staff); // Log each staff to check its properties
                            var staffName = staff.staff_name; // Use 'staff_name' from the response
                            $('#staff_id').append('<option value="' + staff.staff_id + '">' +
                                staffName + '</option>');
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
        }
    </script>
@endpush
