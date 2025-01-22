@extends('backEnd.master')
@section('title')
    @lang('common.finance')
@endsection

{{-- {{ dd($finance_invoice) }} --}}

@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('common.finance')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('common.finance')</a>
                    <a href="#">@lang('common.finance')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid Billig-container shadow-sm">
            <div class="water-mark">
                <img src="{{ asset('/uploads/settings/logo.png') }}" alt="logo">

            </div>
            <!-- Header -->
            <header>
                <div class="row align-items-center">
                    <div class="col-7 text-start mb-3 mb-sm-0">
                        <img src="{{ asset('/uploads/settings/logo.png') }}" width="150" alt="logo">

                    </div>
                    <div class="col-5 text-end">
                        <h4 class="mb-0 text-uppercase">Invoice NO.</h4>
                        <p class="mb-0">{{ $finance_invoice->invoice_number }}</p>
                    </div>
                </div>
                <hr>
            </header>
            <!-- Main Content -->
            <main>

                <div class="row">
                    <div class="col-6"><strong class="main-title">Date:</strong>
                        {{ $finance_invoice->created_at->format('Y-m-d') }}
                    </div>
                    <div class="col-6 text-end"> <strong class="main-title">Invoice No:</strong>
                        {{ $finance_invoice->invoice_number }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6 text-end order-sm-1">
                        <strong class="main-title">Pay To:</strong>
                        <address>
                            Easy Teach It Solution<br>
                            1348 Columbia Road, Denver<br>
                            Pin : 80265
                        </address>
                    </div>
                    <div class="col-6 order-sm-0">
                        <strong class="main-title">Invoiced To:</strong>
                        <address>
                            Full Name: {{ $finance_invoice->student->full_name }}<br>
                            Email: {{ $finance_invoice->student->email }}<br>
                            Phone: {{ $finance_invoice->student->mobile }}<br>
                            Address: {{ $finance_invoice->student->current_address }}<br>
                        </address>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td class="col-3"><strong class="main-title">Service</strong></td>
                                <td class="col-4"><strong class="main-title">Description</strong></td>
                                <td class="col-2"><strong class="main-title">Rate</strong></td>
                                <td class="col-1 text-end"><strong class="main-title">QTY</strong></td>
                                <td class="col-2 text-end"><strong class="main-title">Amount</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="col-3">SEO</td>
                                <td class="col-4 text-1">Optimize for search engines</td>
                                <td class="col-2">$520.00</td>
                                <td class="col-1 text-end">1</td>
                                <td class="col-2 text-end">$450.00</td>
                            </tr>
                            <tr>
                                <td class="col-3">Development</td>
                                <td class="col-4 text-1">Website Development</td>
                                <td class="col-2">$100.00</td>
                                <td class="col-1 text-end">10</td>
                                <td class="col-2 text-end">$1250.00</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="bg-light-2 text-end border-0"><strong class="main-title">Sub
                                        Total:</strong></td>
                                <td class="bg-light-2 text-end border-0">$1500.00</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="bg-light-2 text-end border-0"><strong
                                        class="main-title">Tax:</strong></td>
                                <td class="bg-light-2 text-end border-0">$325.00</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="bg-light-2 text-end border-0"><strong
                                        class="main-title">Total:</strong></td>
                                <td class="bg-light-2 text-end border-0">$1825.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>


            <!-- Footer -->
            <footer class="text-center mt-4">
                <p class="text-1"><strong class="main-title">NOTE :</strong> This is computer generated receipt and does not
                    require physical
                    signature.</p>
                <div class="btn-group btn-group-sm d-print-none">
                    <a href="#" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i>
                        Print</a>
                    <a href="" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-download"></i>
                        Download</a>
                </div>
            </footer>
        </div>
    </section>
@endsection


<style>
    th {
        font-size: 14px !important;

    }

    td {
        padding: 10px !important;
        font-size: 12px !important;
        color: #333 !important;

    }

    .Billig-container {

        background: #ffff;
        padding: 30px;
    }

    .main-title {
        font-size: 14px !important;
        color: #3c4e7a;
    }

    address,
    p,
    h4 {

        color: #333 !important;
    }

    .water-mark {
        position: absolute;
        bottom: 50px;
    }

    .water-mark img {
        width: 100%;
        opacity: 0.1;
        transform: rotate(15deg);
    }
</style>
