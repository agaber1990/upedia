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
                    <a>@lang('hr.human_resource')</a>
                    <a href="{{ route('finance') }}">@lang('common.invoices')</a>
                    <a>@lang('hr.create_invoice')</a>
                </div>
            </div>
        </div>
    </section>

    {{-- {{dd($track_pricing_plan)}} --}}
    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid p-0">

            <div id="accordion">
                <div class="card">
                    <div class="card-header pt-0 pb-0" id="headingOne">
                        <h5 class="mb-0 create-title" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="false" aria-controls="collapseOne">
                            <button class="btn btn-link add_btn_link">
                                info
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="primary_input col-md-4">
                                    <label class="primary_input_label" for="series">
                                        @lang('common.series') <span class="text-danger">*</span>
                                    </label>
                                    <select class="primary_select form-control" name="series" id="series">
                                        <option value="">@lang('common.select')</option>
                                        <option value="">@lang('common.select')</option>
                                        <option value="">@lang('common.select')</option>
                                        <option value="">@lang('common.select')</option>

                                    </select>
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
                                <div class="primary_input col-md-4">
                                    <label class="primary_input_label" for="track">
                                        @lang('common.pricing_plan_type') <span class="text-danger">*</span>
                                    </label>
                                    <select class="primary_select form-control" name="pricing_plan_type"
                                        id="pricing_plan_type">
                                        <option value="">@lang('common.select')</option>
                                        @foreach ($pricing_types as $type)
                                            <option value="{{ $type->id }}">
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="primary_input col-md-4">
                                    <label class="primary_input_label" for="">@lang('common.date')
                                        <span class="text-danger"> *</span></label>
                                    <input class="primary_input_field  inputs" type="date" value="{{ date('Y-m-d') }}"
                                        min="{{ date('Y-m-d') }}" name="date" id="date" readonly />
                                </div>
                                <div class="primary_input col-md-4 mt-2">
                                    <label class="primary_input_label" for="">@lang('common.posting_date')
                                        <span class="text-danger"> *</span></label>
                                    <input class="primary_input_field  inputs" type="datetime-local" disabled
                                        name="posting_date" id="posting_date" />
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkPostingDate"
                                            name="">
                                        <label class="primary_input_label" for="checkPostingDate">@lang('common.posting_date')
                                            <span class="text-danger"> *</span></label>

                                    </div>
                                </div>
                                <div class="primary_input col-md-4 mt-2">
                                    <label class="primary_input_label" for="payment_due_date">@lang('common.payment_due_date')
                                        <span class="text-danger"> *</span></label>
                                    <input class="primary_input_field inputs" type="date" name="payment_due_date"
                                        id="payment_due_date" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card mt-2">
                    <div class="card-header pt-0 pb-0" id="headingTwo">
                        <h5 class="mb-0 create-title" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="false" aria-controls="collapseTwo">
                            <button class="btn btn-link add_btn_link">
                                Tracks and levels
                            </button>
                        </h5>
                    </div>


                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">

                                <div class="primary_input col-md-4">
                                    <label class="primary_input_label" for="track">
                                        @lang('common.select_track') <span class="text-danger">*</span>
                                    </label>
                                    <select class="primary_select form-control" name="track_id" id="track">
                                        <option value="">@lang('common.select_track')</option>
                                        @foreach ($tracks as $track)
                                            <option value="{{ $track->id }}"
                                                data-level-number="{{ $track->level_number }}">
                                                {{ $track->track_name_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="primary_input col-md-4" id="levels_track">
                                    <label class="primary_input_label d-none" for="levels" id="levels_track_label">
                                        @lang('common.select_levels') <span class="text-danger">*</span>
                                    </label>
                                </div>

                                <div class="primary_input col-md-4 d-none" id="price">
                                    <div class="primary_input_label" for="levels">
                                        @lang('common.price') <span class="text-danger">*</span>
                                    </div>
                                    <div class="mt-3" id="badge_price">

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection

<style>
    .table thead th,
    .table tbody td {
        padding: 10px !important
    }

    .inputs {
        font-size: 12px !important;
        min-height: 45px;
        color: #415094 !important;
        border: 1px solid #d4d4d4 !important;
    }

    .card-header {
        background: #f9f9f9;
    }

    .card-header h5 {
        font-size: 14px !important
    }

    .card-header button {
        color: #415094 !important;
        text-decoration: none !important;
    }

    .add_btn_link {
        font-size: 14px !important
    }
</style>
@push('scripts')
    <script>
        $(document).ready(function() {
            let selected_pricing_plan_type = null;
            let selectedTrack = null;
            let levels = @json($levels);

            $('#pricing_plan_type').on('change', function() {
                selected_pricing_plan_type = $(this).val();
                $('#track').val('').trigger('change');
            });

            $('#track').on('change', function() {
                selectedTrack = $(this).find(':selected');
                let trackLevelNumber = selectedTrack.data('level-number');


                $('#levels_track_label').removeClass('d-none');
                $('#levels_track select').remove();

                const selectElement = $('<select>', {
                    class: 'primary_select form-control',
                    name: 'levels_id',
                    id: 'levels_track_select'
                });

                selectElement.append($('<option>', {
                    value: '',
                    text: '@lang('common.select_levels')'
                }));

                if (trackLevelNumber && levels.length > 0) {
                    const filteredLevels = levels.filter(level => level.id <= trackLevelNumber);


                    if (filteredLevels.length > 0) {
                        filteredLevels.forEach(level => {
                            selectElement.append($('<option>', {
                                value: level.id,
                                text: `Level ${level.level_number}`
                            }));
                        });
                    } else {
                        selectElement.append($('<option>', {
                            value: '',
                            text: '@lang('common.no_levels')'
                        }));
                    }
                }

                $('#levels_track').append(selectElement);
            });

            $(document).on('change', '#levels_track_select', function() {
                const selectedLevel = $(this).val();

                if (!selectedTrack || !selectedTrack.val() || !selected_pricing_plan_type) {
                    $('#badge_price').html(
                        `<h1><span class="badge badge-warning">Please select a track and pricing plan type first.</span></h1>`
                    );
                    return;
                }

                let trackPricingPlans = @json($track_pricing_plan);

                let foundPlan = trackPricingPlans.find(plan =>
                    plan.track_id == selectedTrack.val() &&
                    plan.pricing_plan_type_id == selected_pricing_plan_type
                );

                if (foundPlan) {
                    if (selectedLevel) {
                        let result = selectedLevel * parseFloat(foundPlan.price).toFixed(3);

                        $('#price').removeClass('d-none');
                        $('#badge_price').html(
                            `<h1><span class="badge badge-success">${result}</span></h1>`
                        );
                    } else {
                        $('#price').removeClass('d-none');
                        $('#badge_price').html(
                            `<h1><span class="badge badge-warning">No Level Selected</span></h1>`
                        );
                    }
                } else {
                    $('#price').removeClass('d-none');
                    $('#badge_price').html(
                        `<h1><span class="badge badge-warning">No Matching Price Found</span></h1>`
                    );
                }
            });
        });





        $(document).ready(function() {
            $('#checkPostingDate').on('change', function() {
                if ($(this).prop('checked')) {
                    $('#posting_date').prop('disabled', false);
                } else {
                    $('#posting_date').prop('disabled', true);
                }
            });
        });

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
