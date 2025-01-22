@extends('backEnd.master')
@section('title')
    @lang('student.lets_assigned')
@endsection
{{-- {{ dd($staff_scheduleds) }} --}}
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

        .icon-only [class*="ti-"] {
            color: #fff;
            font-size: 14px;
        }

        .icon-only:hover [class*="ti-"] {
            color: #fff !important;
        }

        .table thead td {
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
                        <div class="d-flex justify-content-between mb-20">
                            <h3>
                                @lang('common.invoices')
            
                            </h3>
                            <button class="primary-btn-small-input primary-btn small fix-gr-bg" type="button"
                                data-toggle="modal" data-target="#assignStudent"> <span class="ti-plus pr-2"></span>
                                @lang('common.create_invoice')</button>
                        </div>
                        <div class="table-responsive">
                            <table id="" class="table simple-table school-table" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>@lang('common.invoice_number')</th>
                                        <th>@lang('common.bill_status')</th>
                                        <th>@lang('common.delivery_note')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($student_invoices as $item)
                                    <tr>
                                        <td>{{ $item->invoice_number }}</td>
                                        <td>
                                            <span class="badge @if($item->bill_status === 'pending')badge-warning @elseif ($item->bill_status === 'billed')badge-success @elseif ($item->bill_status === 'cancelled')badge-danger @endif">
                                                {{ ucfirst($item->bill_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $item->delivery_note }}</td>
                                        <td>
                                           <a href="" class="print_now">
                                            <i class="fas fa-print"></i>
                                           </a>
                                        </td>
                                    </tr>
                                @endforeach
                                

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
                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'sales_management_store', 'method' => 'POST']) }}


                <div class="modal-body pt-3">
                    <div class="container-fluid">
                        <!-- Hidden Input for Student ID -->
                        <input type="hidden" name="student_id" value="{{ $student_detail->id }}">
                        <input type="hidden" name="staff_scheduleds_id" value="{{ $staff_scheduleds->id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3">Details</h5>
                                <ul>
                                    <li><strong>Category:</strong> {{ $staff_scheduleds->category->name_en }}</li>
                                    <li><strong>Staff Name:</strong> {{ $staff_scheduleds->staff->full_name }}</li>
                                    <li><strong>Track Name:</strong> {{ $staff_scheduleds->track->track_name_en }}</li>
                                    <li><strong>Track Type Name:</strong> {{ $staff_scheduleds->trackType->name }}</li>
                                    <li><strong>Status:</strong> {{ $staff_scheduleds->status }}</li>
                                    <li><strong>Session:</strong> {{ $staff_scheduleds->session }}</li>
                                    <li><strong>Schedule:</strong> {{ $staff_scheduleds->schedule }}</li>
                                    <li><strong>Start Date:</strong> {{ $staff_scheduleds->start_date }}</li>
                                    <li><strong>End Date:</strong> {{ $staff_scheduleds->end_date }}</li>
                                </ul>
                            </div>

                            <!-- Slots Section -->
                            <div class="col-md-6 mt-4">
                                <h5 class="mb-3">Available Slots</h5>
                                <ul>
                                    @foreach ($slots as $slot)
                                        <li>
                                            <strong>{{ $slot->slot_day }}:</strong> {{ formatTime($slot->slot_start) }} -
                                            {{ formatTime($slot->slot_end) }}
                                        </li>
                                    @endforeach
                                </ul>
                                <hr>
                                <div class="form-group">
                                    
                                    <h5 for="levels_id">@lang('academics.level_number')</h5>
                                    <select name="levels_id" id="levels_id"
                                        class="form-control primary_select {{ $errors->has('levels_id') ? 'is-invalid' : '' }}">
                                        <option data-display="@lang('academics.level_number') *" value="">@lang('academics.level_number') *
                                        </option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}">
                                                {{ $level->level_number }}
                                            </option>
                                        @endforeach
                                    </select>
    
                                    @if ($errors->has('levels_id'))
                                        <span class="text-danger" role="alert">
                                            {{ $errors->first('levels_id') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- Level Selection Section -->
                            
                        </div>
                    </div>
                </div>


                <div class="modal-footer" id="add_btn">
                    <button type="submit" class="primary-btn fix-gr-bg">@lang('common.submit')</button>
                </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>
    <!-- assign class form modal end-->
@endsection


<style>
    .badge {
        font-size: 12px !important;
    }
    .badge-success {
        background: #080 !important;

    }
    .badge-success {
        background: #080 !important;

    }
    .badge-warning {
        background: rgb(81, 81, 81) !important;

    }
    .badge-danger {
        background: rgb(255, 10, 10) !important;
    }

    .print_now {
        font-size: 16px
    }
</style>
@push('script')
@endpush
