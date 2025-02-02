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
                    <label class="primary_input_label" for="">@lang('common.due_date')
                        <span class="text-danger"> *</span></label>

                        
                    <input class="primary_input_field  inputs" type="date" value="{{ date('Y-m-d')}}" min="{{ date('Y-m-d')}}"
                        name="due_date" id="due_date" />
                </div>
                <div class="primary_input col-md-4 mt-2">
                    <div class="d-flex">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="track" name="">
                            <label class="form-check-label text-dark fw-bold" for="track">
                                <i class="bi bi-check-circle-fill text-success me-1"></i> 
                            </label>
                        </div>
                        <label class="primary_input_label" for="">@lang('common.posting_date')
                            <span class="text-danger"> *</span></label>
                    </div>
                    <input class="primary_input_field  inputs" type="date" disabled
                        name="posting_date" id="posting_date" />
                </div>
          
                <div class="primary_input col-md-12 mt-2" >
                    <hr>
                    {{-- <div style="text-align: end">
                        <button type="button" class="primary-btn fix-gr-bg  mb-2 p-3">
                        <i class="fas fa-plus mx-0"></i>   
                         </button>
                    </div> --}}
                    <table class="table table-bordered bg-white">
                        <thead>
                            <tr>
                                <th style="    width: 110px;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="track" name="">
                                        <label class="form-check-label text-dark fw-bold" for="track">
                                            <i class="bi bi-check-circle-fill text-success me-1"></i> 
                                        </label>
                                        {{__('common.check_all')}}
                                    </div>
                                </th>
                                <th>{{__('common.select_tack_name')}}</th>
                                <th>{{__('common.levels_qty')}}</th>
                                <th>{{__('common.price')}}</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="track" name="">
                                        <label class="form-check-label text-dark fw-bold" for="track">
                                            <i class="bi bi-check-circle-fill text-success me-1"></i> 
                                        </label>
                                    </div>
                                </td>
                                <td >
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
                                </td>
                                <td>
                                    <div class="primary_input mb-2">
                                        <label class="primary_input_label" for="">@lang('common.levels')
                                            <span class="text-danger"> *</span></label>
                                        <input class="primary_input_field form-control "
                                            name="levels" id="levels" />
                                    </div>
                                </td>
                                <td>
                                    350 EGP
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <input type="hidden" id="levels_id" name="levels_id" value="">
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
</style>
@push('scripts')
    <script>

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
