@extends('backEnd.master')
@section('title')
@lang('student.lets_assigned')

@endsection
@push('css')
    <style>
        .badge {
            background: var(--primary-color);
            color: #fff;
            padding: 5px 10px;
            border-radius: 30px;
            display: inline-block;
            font-size: 8px;
        }
        .icon-only [class*="ti-"]{
            color: #fff;
            font-size: 14px;
        }
        .icon-only:hover [class*="ti-"]{
            color: #fff!important;
        }

        .table thead td{
            text-align: left;
        }

        .table tbody td {
            padding: 10px 12px 10px 12px;
        }
    </style>
@endpush
@section('mainContent')


    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>
                    @lang('common.lets_assigned')

                </h1>
              
            </div>
        </div>
    </section>

    <section class="student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3">
                    @includeIf('backEnd.studentInformation.inc.student_profile')
                </div>

                <!-- Start Student Details -->
                <div class="col-lg-9 student-details up_admin_visitor">
                    <div class="white-box mt-40">
                        <div class="text-right mb-20">
                            <button class="primary-btn-small-input primary-btn small fix-gr-bg" type="button"
                                data-toggle="modal" data-target="#assignStudent"> <span class="ti-plus pr-2"></span>
                                @lang('common.create_invoice')</button>
                        </div>
                        <div class="table-responsive">
                        <table id="" class="table simple-table school-table"
                            cellspacing="0">
                            <thead>
                                <tr >
                                    <th>@lang('common.invoice_number')</th>
                                    <th>@lang('common.bill_status')</th>
                                    <th>@lang('student.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- Loop --}}
                               
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <!-- End Student Details -->
            </div>


        </div>
    </section>

    <!-- assign class form modal start-->
    <div class="modal fade admin-query" id="assignStudent">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        @lang('common.create_invoice')

                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student.record.store', 'method' => 'POST']) }}

                <div class="modal-body pt-3">
                    <div class="container-fluid">

                        <input type="hidden" name="student_id" value="{{ $student_detail->id }}">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="primary_input ">
                                    <label for="">@lang('academics.level_number')</label>
                                    <select multiple
                                        class="primary_select  form-control{{ $errors->has('session') ? ' is-invalid' : '' }}"
                                        name="session" id="academic_year">
                                        <option data-display="@lang('academics.level_number') *" value="">@lang('academics.level_number')
                                            *</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>

                                    @if ($errors->has('session'))
                                        <span class="text-danger invalid-select" role="alert">
                                            {{ $errors->first('session') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                     
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit"
                    class="primary-btn fix-gr-bg">@lang('common.submit')</button>                           
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
    <!-- assign class form modal end-->


@endsection
@push('script')
   
@endpush
