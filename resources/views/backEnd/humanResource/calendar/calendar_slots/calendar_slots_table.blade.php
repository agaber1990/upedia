@push('styles')
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
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
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
            var promises = days.map(function(slot, index) {
                console.log('Fetching teachers for:', slot);
                return $.ajax({
                    url: '{{ route('getTeachersByTime') }}',
                    method: 'GET',
                    data: {
                        day: slot.day,
                        start_time: slot.startTime,
                        end_time: slot.endTime,
                        track_id: $('#track_id').val(),
                        schedule: schedule
                    },
                    success: function(response) {
                        console.log('Response for', slot.day, ':', response);
                        if (response.teachers && response.teachers.length > 0) {
                            response.teachers.forEach(function(teacher) {
                                if (!allTeachers[teacher.id]) {
                                    allTeachers[teacher.id] = { full_name: teacher.full_name, slots: {} };
                                }
                                allTeachers[teacher.id].slots[slot.day] = teacher.slots || [];
                            });
                        } else {
                            allTeachers['no_teachers_' + index] = {
                                full_name: `No teachers available for ${slot.day} (${slot.startTime} - ${slot.endTime})`,
                                slots: { [slot.day]: [] }
                            };
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error fetching teachers for', slot.day, ':', error);
                    }
                });
            });

            $.when.apply($, promises).then(function() {
                console.log('All teachers data:', allTeachers);

                // Filter teachers to ensure they have slots for ALL selected days
                var filteredTeachers = {};
                if (schedule === 'twice') {
                    for (let teacherId in allTeachers) {
                        if (teacherId.startsWith('no_teachers_')) continue;

                        let teacher = allTeachers[teacherId];
                        let hasAllDays = days.every(function(slot) {
                            let teacherSlots = teacher.slots[slot.day] || [];
                            return teacherSlots.length > 0; // The Backend already ensures coverage
                        });

                        if (hasAllDays) {
                            filteredTeachers[teacherId] = teacher;
                        }
                    }
                } else {
                    for (let teacherId in allTeachers) {
                        if (teacherId.startsWith('no_teachers_')) continue;
                        filteredTeachers[teacherId] = allTeachers[teacherId];
                    }
                }

                console.log('Filtered teachers:', filteredTeachers);

                let hasNoTeachers = Object.keys(allTeachers).some(key => key.startsWith('no_teachers_'));

                // Calculate dates for the table
                var sessionsPerWeek = schedule === "once" ? 1 : 2;
                var weeksRequired = Math.ceil(sessionCount / sessionsPerWeek);

                var allDates = [];
                var currentDate = new Date(startDate);
                var end = new Date(endDate);
                var sessionCounter = 0;

                while (currentDate <= end && sessionCounter < sessionCount) {
                    var dayIndex = daysOfWeek.indexOf(days[0].day); // day_1
                    if (currentDate.getDay() === dayIndex) {
                        allDates.push({
                            date: new Date(currentDate).toISOString().split('T')[0],
                            day: days[0].day,
                            startTime: days[0].startTime,
                            endTime: days[0].endTime
                        });
                        sessionCounter++;
                    }

                    if (schedule === 'twice') {
                        dayIndex = daysOfWeek.indexOf(days[1].day); // day_2
                        if (currentDate.getDay() === dayIndex) {
                            allDates.push({
                                date: new Date(currentDate).toISOString().split('T')[0],
                                day: days[1].day,
                                startTime: days[1].startTime,
                                endTime: days[1].endTime
                            });
                            sessionCounter++;
                        }
                    }

                    currentDate.setDate(currentDate.getDate() + 1);
                }

                allDates.sort((a, b) => new Date(a.date) - new Date(b.date));
                console.log('Sorted dates:', allDates);

                let tableHtml = `
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th class="text-white">@lang('common.select')</th>
                                <th class="text-white">@lang('hr.teacher_name')</th>
                                ${allDates.map(item => `
                                    <th class="text-white">${item.day}, ${item.date}</th>
                                `).join('')}
                            </tr>
                        </thead>
                        <tbody>
                `;

                if (Object.keys(filteredTeachers).length > 0) {
                    for (let teacherId in filteredTeachers) {
                        let teacher = filteredTeachers[teacherId];
                        tableHtml += `
                            <tr>
                                <td>
                                    <input type="radio" name="selected_teacher" value="${teacherId}" class="select-teacher">
                                </td>
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
                                            } else if (availability.status === 'unpaid') {
                                                cellStyle = 'background-color: #fdc59a; color: white;';
                                            } else if (availability.status === 'available') {
                                                cellStyle = 'background-color: #eee21f;';
                                            }

                                            return `<div style="${cellStyle}" data-slot-id="${slotItem.slot_id}" data-date="${item.date}">${slotText}</div>`;
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
                            <td colspan="${allDates.length + 2}">
                                @lang('academics.no_teachers_available')
                                ${hasNoTeachers ? '<br><small>' + Object.values(allTeachers)
                                    .filter(teacher => teacher.full_name.includes('No teachers available'))
                                    .map(teacher => teacher.full_name)
                                    .join('<br>') + '</small>' : ''}
                            </td>
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

        // Function to check teacher availability based on backend data and date
        function checkTeacherAvailability(slot, date) {
            let slotStatus = slot.status || 'available';
            let scheduledPeriods = slot.scheduled_periods || [];

            // If the slot is not scheduled, it's available
            if (slotStatus !== 'scheduled') {
                return { status: 'available' };
            }

            // If there are no scheduled periods, assume it's available
            if (scheduledPeriods.length === 0) {
                return { status: 'available' };
            }

            // Compare the date with each scheduled period
            let currentDate = new Date(date);
            let isScheduled = scheduledPeriods.some(period => {
                let startDate = new Date(period.start_date);
                let endDate = new Date(period.end_date);
                return currentDate >= startDate && currentDate <= endDate;
            });

            return { status: isScheduled ? 'scheduled' : 'available' };
        }

        // Event listener for end time selection
        $(document).on('change', '#end_time_1, #end_time_2', function() {
            fetchAvailableTeachers();
        });
    });
</script>
@endpush