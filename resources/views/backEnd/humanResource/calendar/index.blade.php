@extends('backEnd.master')

@section('title')
    @lang('hr.calendar')
@endsection

@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('hr.calendar')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a>@lang('hr.human_resource')</a>
                    <a>@lang('hr.calendar')</a>
                </div>
            </div>
        </div>
    </section>

    @include('backEnd.humanResource.calendar.calendar_form')
    @include('backEnd.humanResource.calendar.calendar_slots.index')
    @include('backEnd.humanResource.calendar.calendar_submit')
@endsection
