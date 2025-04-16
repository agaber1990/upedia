<div class="col-md-12 mb-20">
    <div id="submitAssignStaff"></div>
</div>

@push('styles')
    <style>
        /* Styles for the submit button */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Add submit button after schedule selection
            $('#scheduled').on('change', function() {
                if ($(this).val()) {
                    $("#submitAssignStaff").html(
                        `<button class="btn btn-primary" id="submitButton">Submit</button>`);
                }
            });

            // Submit form with selected teachers
            function submitAssignedForm() {
                let formData = {
                    course_name_en: $('#course_name_en').val(),
                    course_name_ar: $('#course_name_ar').val(),
                    category_id: $('#category_id').val(),
                    track_type_id: $('#track_type_id').val(),
                    track_id: $('#track_id').val(),
                    session: $('#session').val(),
                    schedule: $('#scheduled').val(),
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    _token: '{{ csrf_token() }}'
                };

                let selectedTeacher = $('input[name="selected_teacher"]:checked').val();
                if (!selectedTeacher) {
                    Swal.fire({
                        title: "Error!",
                        text: "Please select a teacher!",
                        icon: "error"
                    });
                    return;
                }
                formData.staff_id = selectedTeacher;

                let selectedSlots = [];
                let selectedDates = [];
                $(`input[name="selected_teacher"]:checked`).closest('tr').find('td div[data-slot-id]').each(
                    function() {
                        let slotId = $(this).data('slot-id');
                        let slotDate = $(this).data('date');
                        let slotStatus = $(this).css('background-color');
                        let status = '';
                        if (slotStatus === 'rgb(238, 226, 31)') { // Available (yellow)
                            status = 'available';
                        } else if (slotStatus === 'rgb(252, 59, 60)') { // Scheduled (red)
                            status = 'scheduled';
                        } else if (slotStatus === 'rgb(253, 197, 154)') { // Unpaid (orange)
                            status = 'unpaid';
                        }
                        if (slotId && status === 'available') {
                            selectedSlots.push(slotId);
                            selectedDates.push(slotDate);
                        }
                    });

                selectedSlots = [...new Set(selectedSlots)];

                if (selectedSlots.length === 0) {
                    Swal.fire({
                        title: "Error!",
                        text: "No available slots found for the selected teacher! Please choose a different time slot.",
                        icon: "error"
                    });
                    return;
                }

                formData.selected_slots = selectedSlots;
                formData.selected_dates = selectedDates;

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
                        if (error.responseJSON && error.responseJSON.error) {
                            let errorMessage = error.responseJSON.error;
                            if (errorMessage.includes('dates overlap')) {
                                errorMessage +=
                                    `\nExisting schedule: ${error.responseJSON.existing_start_date} to ${error.responseJSON.existing_end_date}. Please choose different dates.`;
                            } else if (errorMessage.includes('time slot')) {
                                errorMessage += " Please choose a different time slot.";
                            }
                            Swal.fire({
                                title: "Error!",
                                text: errorMessage,
                                icon: "error"
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: "Error saving event: " + (error.responseJSON?.message ||
                                    "Unknown error"),
                                icon: "error"
                            });
                        }
                    }
                });
            }

            $(document).on('click', '#submitButton', function() {
                submitAssignedForm();
            });
        });
    </script>
@endpush
