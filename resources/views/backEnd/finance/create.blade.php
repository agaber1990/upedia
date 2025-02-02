@extends('backEnd.master')
@section('slot_name')
    @lang('hr.create_invoice')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('hr.create_invoice')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('hr.human_resource')</a>
                    <a href="#">@lang('hr.create_invoice')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid p-0">
           
            <div class="row">
               
                <div class="primary_input col-md-4">
                    <label class="primary_input_label" for="track">
                        @lang('common.pricing_plan_type') <span class="text-danger">*</span>
                    </label>
                    <select class="primary_select form-control" name="pricing_plan_type" id="pricing_plan_type">
                        <option value="">@lang('common.select')</option>
                        @foreach ($pricing_types as $type)
                            <option value="{{ $type->id }}" >
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="primary_input col-md-4">
                    <label class="primary_input_label" for="track">
                        @lang('common.select_track') <span class="text-danger">*</span>
                    </label>
                    <select class="primary_select form-control" name="track_id" id="track">
                        <option value="">@lang('common.select_track')</option>
                        @foreach ($tracks as $track)
                            <option value="{{ $track->id }}" data-level="{{ $track->level_number }}">
                                {{ $track->track_name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="primary_input col-md-4" id="track_staff_scheduled">

                </div>
                <div class="primary_input col-md-4">
                    <label class="primary_input_label" for="student_id">
                        @lang('common.select_student') <span class="text-danger">*</span>
                    </label>
                    <select class="primary_select form-control" name="student_id" id="student_id">
                        <option value="">@lang('common.select_student')</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" id="levels_id" name="levels_id" value="">
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        const staffScheduledData = {!! json_encode($tracks->pluck('staff_scheduled', 'id')) !!};

        $('#track').change(function() {
            const selectedTrackId = $(this).val();
            const selectedTrack = $(this).find('option:selected');
            const levelNumber = selectedTrack.data('level');
            $('#levels_id').val(levelNumber);

            $('#track_staff_scheduled').html(`
                <label class="primary_input_label" for="staff_scheduled">
                    @lang('common.select_course') <span class="text-danger">*</span>
                </label>
                <select class="primary_select form-control" name="staff_scheduleds_id" id="staff_scheduleds_id">
                    <option value="">@lang('common.select_course')</option>
                </select>
                `);

            const staffScheduledSelect = $('#staff_scheduleds_id');
            if (staffScheduledData[selectedTrackId]) {
                staffScheduledData[selectedTrackId].forEach(function(scheduled) {
                    staffScheduledSelect.append(
                        `<option value="${scheduled.id}">${scheduled.course_name_en}</option>`
                    );
                });
            } else {
                staffScheduledSelect.append('<option value="">@lang('common.no_courses_available')</option>');
            }
        });

        $('#track').trigger('change');

        $('#createInvoiceForm').on('click', function() {
            let staff_scheduleds_id = $('#staff_scheduleds_id').val();
            let student_id = $('#student_id').val();
            let levels_id = $('#levels_id').val();

            console.log("Staff Scheduled ID:", staff_scheduleds_id);
            console.log("Student ID:", student_id);
            console.log("Levels ID:", levels_id);

            let formData = {
                '_token': '{{ csrf_token() }}',
                staff_scheduleds_id: staff_scheduleds_id,
                student_id: student_id,
                levels_id: levels_id,
            };

            $.ajax({
                url: '{{ route('finance_store') }}',
                method: 'POST',
                data: formData,
                success: function(response) {

                    $('#createInvoice').modal('hide');


                    window.location.reload();
                    toastr.success('Operation successfully.', 'Success', {
                        timeOut: 5000,
                    });
                },
                error: function(response) {
                    if (response.responseJSON.errors['levels_id']) {
                        toastr.error(response.responseJSON.errors['levels_id'][0],
                            "Error", {
                                timeOut: 5000,
                            });
                    }
                    if (response.responseJSON.errors['staff_scheduleds_id']) {
                        toastr.error(response.responseJSON.errors['staff_scheduleds_id'][0],
                            "Error", {
                                timeOut: 5000,
                            });
                    }
                    if (response.responseJSON.errors['student_id']) {
                        toastr.error(response.responseJSON.errors['student_id'][0],
                            "Error", {
                                timeOut: 5000,
                            });
                    }



                },
            });
            // toastr.error("Select All Required Data", "Error", {
            //     timeOut: 5000,
            // });


        });
    </script>
@endpush
