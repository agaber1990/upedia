@extends('backEnd.master')
@section('title')
    @lang('academics.pricing_plan')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('academics.pricing_plan')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('academics.dashboard')</a>
                    <a href="#">@lang('academics.academics')</a>
                    <a href="#">@lang('academics.pricing_plan')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">


            <div class="row">
                <!-- Form Section -->

                <!-- Track List Section -->
                <div class="col-md-6">
                    <div class="white-box">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 150px">{{__('common.pricing_plan_type')}}</th>
                                    @foreach ($tracktypes as $item)
                                        <th><span class="title-td">{{ $item->name }}</span></th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pricing_plan_types as $plan) 
                                    <tr>
                                        <td><span class="title-td">{{ $plan->name }}</span></td>
                                        @foreach ($tracktypes as $track)
                                            <td>
                                                <input type="text" class="form-control">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="white-box">
                        sdsfdsd
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<style>
    .table tbody td {
    padding: 10px !important;
}
.title-td {
    font-size: 12px !important;
    color: #53639b !important;
}
</style>