@extends('backEnd.master')
@section('title')
    @lang('student.lets_assigned')
@endsection
{{-- {{ dd($invoices) }} --}}
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

    <section class="sms-breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('common.invoices')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('academics.academics')</a>
                    <a href="#">@lang('common.invoices')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <!-- Start Student Details -->
                <div class="col-lg-12 student-details up_admin_visitor">
                    <div class="white-box mt-40">
                        <div class="d-flex justify-content-between mb-20">
                            <h3>
                                @lang('common.invoices')

                            </h3>
                            <a class="primary-btn-small-input primary-btn small fix-gr-bg" 
                            href="{{route('create_invoice')}}"> <span class="ti-plus pr-2"></span>
                                @lang('common.create_invoice')</a>
                        </div>
                        <div class="table-responsive">
                            <table id="" class="table simple-table school-table" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>@lang('common.student_name')</th>
                                        <th>@lang('common.invoice_number')</th>
                                        <th>@lang('common.bill_status')</th>
                                        <th>@lang('common.payment_status')</th>

                                        <th>@lang('common.delivery_note')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($invoices as $item)
                                        {{-- {{ dd($invoices) }} --}}
                                        <tr>
                                            <td>{{ $item->student->full_name }}</td>
                                            <td>{{ $item->invoice_number }}</td>
                                            <td>
                                                <span
                                                    class="badge @if ($item->bill_status === 'pending') badge-warning @elseif ($item->bill_status === 'billed')badge-success @elseif ($item->bill_status === 'cancelled')badge-danger @endif">
                                                    {{ __('common.' . $item->bill_status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge @if ($item->payment_status === 'refunded') badge-refunded @elseif ($item->payment_status === 'paid')badge-success @elseif ($item->payment_status === 'not_paid')badge-danger  @elseif ($item->payment_status === 'paid_purchased')badge-purchased @endif ">
                                                    {{ __('common.' . $item->payment_status) }}

                                                </span>
                                            </td>
                                            <td>{{ $item->delivery_note }}</td>
                                            <td>

                                                <x-drop-down>

                                                    <a class="dropdown-item text-left"
                                                        href="{{ route('finance_invoice', ['id' => $item->id]) }}"> <i
                                                            class="fas fa-print"></i> @lang('common.print') </a>



                                                    <a class="dropdown-item text-left" data-toggle="modal"
                                                        data-target="#changePaymentStatus{{ $item->id }}"
                                                        href="#"><i class="fas fa-wallet"></i> @lang('common.payment_status') </a>
                                                    <a class="dropdown-item text-left" data-toggle="modal"
                                                        data-target="#bill_status{{ $item->id }}" href="#">
                                                        <i class="fas fa-wifi"></i> @lang('common.bill_status') </a>

                                                </x-drop-down>


                                                <div class="modal fade admin-query"
                                                    id="changePaymentStatus{{ @$item->id }}">
                                                    <form action="{{ route('change_payment_status', [@$item->id]) }}"
                                                        method="POST">
                                                        {{ csrf_field() }}
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">@lang('common.payment_status')</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="">@lang('common.payment_status')</label>
                                                                        <select name="payment_status" id="payment_status"
                                                                            class="primary_select">
                                                                            <option value="paid"
                                                                                @if ($item->payment_status == 'paid') selected @endif>
                                                                                {{ __('common.paid') }}</option>
                                                                            <option value="not_paid"
                                                                                @if ($item->payment_status == 'not_paid') selected @endif>
                                                                                {{ __('common.not_paid') }}</option>
                                                                            <option value="refunded"
                                                                                @if ($item->payment_status == 'refunded') selected @endif>
                                                                                {{ __('common.refunded') }}</option>
                                                                            <option value="paid_purchased"
                                                                                @if ($item->payment_status == 'paid_purchased') selected @endif>
                                                                                {{ __('common.paid_purchased') }}</option>
                                                                        </select>
                                                                    </div>


                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div class="mt-40 d-flex justify-content-between">
                                                                        <button type="button" class="primary-btn tr-bg"
                                                                            data-dismiss="modal">@lang('common.cancel')</button>
                                                                        <button class="primary-btn fix-gr-bg mx-1"
                                                                            type="submit">@lang('common.submit')</button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal fade admin-query" id="bill_status{{ @$item->id }}">
                                                    <form action="{{ route('change_bill_status', [@$item->id]) }}"
                                                        method="POST">
                                                        {{ csrf_field() }}
                                                        <div class="modal-dialog modal-dialog-centered">

                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">@lang('common.bill_status')</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="">@lang('common.bill_status')</label>
                                                                        <select name="bill_status" id="bill_status"
                                                                            class="primary_select">
                                                                            <option value="pending"
                                                                                @if ($item->bill_status == 'pending') selected @endif>
                                                                                {{ __('common.pending') }}</option>
                                                                            <option value="billed"
                                                                                @if ($item->bill_status == 'billed') selected @endif>
                                                                                {{ __('common.billed') }}</option>
                                                                            <option value="cancelled"
                                                                                @if ($item->bill_status == 'cancelled') selected @endif>
                                                                                {{ __('common.cancelled') }}</option>

                                                                        </select>
                                                                    </div>


                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div class="mt-40 d-flex justify-content-between">
                                                                        <button type="button" class="primary-btn tr-bg"
                                                                            data-dismiss="modal">@lang('common.cancel')</button>
                                                                        <button class="primary-btn fix-gr-bg mx-1"
                                                                            type="submit">@lang('common.submit')</button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
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

    .badge-refunded {
        background: rgb(134, 7, 207) !important;

    }

    .badge-purchased {
        background: rgb(42, 146, 0) !important;
    }




    .print_now {
        font-size: 16px
    }
</style>
@push('script')
@endpush

@push('script')
    <script>
        $(document).ready(function() {
        

                $('[id^=changePaymentStatus]').on('click', function() {
                    let id = $(this).data('id');
                    let payment_status = $('#payment_status' + id)
                        .val();

                    let formData = {
                        '_token': '{{ csrf_token() }}',
                        payment_status: payment_status
                    };

                    $.ajax({
                        url: '{{ url('change_payment_status') }}/' +
                            id,
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            $('#changePaymentStatus' + id).modal('hide');

                            window.location.reload();
                            toastr.success('Payment status updated successfully.',
                                'Success', {
                                    timeOut: 5000,
                                });
                        },
                        error: function(response) {
                            toastr.error('Operation failed. Please try again.',
                                'Error', {
                                    timeOut: 5000,
                                });
                        },
                    });
                });
         

                $('[id^=changeBillStatus]').on('click', function() {
                    let id = $(this).data('id');
                    let payment_status = $('#bill_status' + id)
                        .val();

                    let formData = {
                        '_token': '{{ csrf_token() }}',
                        bill_status: bill_status
                    };

                    $.ajax({
                        url: '{{ url('change_bill_status') }}/' +
                            id,
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            $('#changeBillStatus' + id).modal('hide');

                            window.location.reload();
                            toastr.success('Bill status updated successfully.',
                                'Success', {
                                    timeOut: 5000,
                                });
                        },
                        error: function(response) {
                            toastr.error('Operation failed. Please try again.',
                                'Error', {
                                    timeOut: 5000,
                                });
                        },
                    });
                });
         

        });
    </script>
@endpush
