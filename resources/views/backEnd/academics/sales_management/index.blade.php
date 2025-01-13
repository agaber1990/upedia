@extends('backEnd.master')
@section('title')
    @lang('academics.sales_management')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('academics.sales_management')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('academics.academics')</a>
                    <a href="#">@lang('academics.sales_management')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="main-title">
                            <h3 class="mb-15">@lang('academics.staff_schedule')</h3>
                        </div>
                        <div class="table-responsive">
                            <x-table>
                                <table id="schedule_table" class="table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('academics.staff_name')</th>
                                            <th>@lang('academics.cat_id')</th>
                                            <th>@lang('academics.slot_id')</th>
                                            <th>@lang('academics.status')</th>
                                            <th>@lang('academics.session')</th>
                                            <th>@lang('academics.schedule')</th>
                                            <th>@lang('academics.start_date')</th>
                                            <th>@lang('academics.end_date')</th>
                                            <th>@lang('academics.track_type_id')</th>
                                            <th>@lang('academics.track_id')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($staffScheduleds as $scheduled)
                                            <tr>
                                                <td>{{ $staff->firstWhere('id', $scheduled->staff_id)->full_name }}</td>
                                                <td>{{ $scheduled->cat_id }}</td>
                                                <td>{{ $scheduled->slot_id }}</td>
                                                <td>{{ $scheduled->status }}</td>
                                                <td>{{ $scheduled->session }}</td>
                                                <td>{{ $scheduled->schedule }}</td>
                                                <td>{{ $scheduled->start_date }}</td>
                                                <td>{{ $scheduled->end_date }}</td>
                                                <td>{{ $scheduled->track_type_id }}</td>
                                                <td>{{ $scheduled->track_id }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </x-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@include('backEnd.partials.data_table_js')
