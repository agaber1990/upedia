@extends('backEnd.master')
@section('title')
    @lang('common.finance')
@endsection
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
            <!-- Header -->
            <header>
                <div class="row align-items-center">
                    <div class="col-7 text-start mb-3 mb-sm-0">
                        <img src="{{ asset('/uploads/settings/logo.png') }}" width="150" alt="logo">

                    </div>
                    <div class="col-5 text-end">
                        <h4 class="mb-0 text-uppercase">Invoice</h4>
                        <p class="mb-0">Invoice Number - 001313</p>
                    </div>
                </div>
                <hr>
            </header>
            <!-- Main Content -->
            <main>
                <div class="row">
                    <div class="col-6"><strong>Date:</strong> 05/12/2021</div>
                    <div class="col-6 text-end"> <strong>Invoice No:</strong> 12020</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6 text-end order-sm-1">
                        <strong>Pay To:</strong>
                        <address>
                            Easy Teach It Solution<br>
                            1348 Columbia Road, Denver<br>
                            Pin : 80265
                        </address>
                    </div>
                    <div class="col-6 order-sm-0">
                        <strong>Invoiced To:</strong>
                        <address>
                            Jon Doe<br>
                            Street: 370 Central Avenue<br>
                            Newark, United States
                        </address>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <td class="col-3 border-0"><strong>Service</strong></td>
                                        <td class="col-4 border-0"><strong>Description</strong></td>
                                        <td class="col-2 border-0"><strong>Rate</strong></td>
                                        <td class="col-1 border-0 text-end"><strong>QTY</strong></td>
                                        <td class="col-2 text-end border-0"><strong>Amount</strong></td>
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
                                        <td colspan="4" class="bg-light-2 text-end"><strong>Sub Total:</strong></td>
                                        <td class="bg-light-2 text-end">$1500.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="bg-light-2 text-end"><strong>Tax:</strong></td>
                                        <td class="bg-light-2 text-end">$325.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="bg-light-2 text-end border-0"><strong>Total:</strong></td>
                                        <td class="bg-light-2 text-end border-0">$1825.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <!-- Footer -->
            <footer class="text-center mt-4">
                <p class="text-1"><strong>NOTE :</strong> This is computer generated receipt and does not require physical
                    signature.</p>
                <div class="btn-group btn-group-sm d-print-none"> 
                    <a href="#"
                        class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a> 
                    <a
                        href="" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-download"></i>
                        Download</a> </div>
            </footer>
        </div>
    </section>
@endsection
