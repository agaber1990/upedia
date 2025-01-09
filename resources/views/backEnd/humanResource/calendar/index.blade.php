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
</style>
@push('scripts')
    <!-- Include jQuery -->
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />

    <!-- Include FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>

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
        function handleEventClick(info) {
            const event = info.event;

            // Extract event details
            const eventTitle = event.title; // Available time title


            const eventDescription = event.extendedProps.description; // Description (staff details, time)
            const staffSlotsId = event.extendedProps.staff_id;
            console.log(staffSlotsId);

            // Get today's date in YYYY-MM-DD format
            const currentDate = new Date();
            const formattedDate = currentDate.toISOString().split('T')[0]; // "YYYY-MM-DD"

            // Prompt user with a dialog or form to confirm the scheduling
            const confirmation = confirm(
                `Do you want to schedule: ${eventTitle} on ${formattedDate}? \nDescription: ${eventDescription}`
            );

            if (confirmation) {
                // Call the save function
                saveScheduledEvent(staffSlotsId, formattedDate);
            }
        }

        // Save the scheduled event to the database
        function saveScheduledEvent(staffSlotsId, date) {
            const status = 'scheduled'; // Default status can be 'scheduled', you can add more if needed.

            const eventData = {
                staff_slots_id: staffSlotsId,
                date: date,
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

                        // Add the fetched events (slots) to the calendar
                        response.slots.forEach(function(slot) {
                            let dow = getDayOfWeek(slot.slot_day); // Convert day name to number

                            // Get the start and end time in the correct format for FullCalendar
                            let startTime = formatTimeForCalendar(slot.slot_start, slot.slot_day);
                            let endTime = formatTimeForCalendar(slot.slot_end, slot.slot_day);

                            // Format start and end time to 12-hour format with AM/PM
                            let formattedStart = formatTo12HourTime(slot.slot_start);
                            let formattedEnd = formatTo12HourTime(slot.slot_end);

                            // Add event to the calendar
                            calendar.addEvent({
                                staff_id: `${slot.staff_id}`,
                                title: `Available ${formattedStart} - ${formattedEnd}`,
                                start: startTime, // Slot start time in 24-hour format for calendar
                                end: endTime, // Slot end time in 24-hour format for calendar
                                daysOfWeek: [dow],
                                description: `${slot.slot_day} ${formattedStart} - ${formattedEnd}`,
                                overlap: true,
                                // editable: true,
                                display: true,
                                extendedProps: {
                                    staff_id: slot.staff_id // Add staff_id here
                                }
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
