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
                            <h3 class="mb-15">@lang('academics.sales_management')</h3>
                        </div>
                        <div class="table-responsive">
                            <x-table>
                                <table id="table_id" class="table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('academics.staff_name')</th>
                                            <th>@lang('academics.tracks')</th>
                                            <th>@lang('academics.slot_times')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($staff as $person)
                                            <tr>
                                                <td>{{ $person->full_name }}</td>
                                                <td>
                                                    @php
                                                        $personTracks = $trackAssignedStaff->where(
                                                            'staff_id',
                                                            $person->id,
                                                        );
                                                    @endphp
                                                    <ul>
                                                        @foreach ($personTracks as $track)
                                                            <li>{{ $tracks->firstWhere('id', $track->track_id)->track_name_en ?? __('common.not_available') }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    @php
                                                        $slotsForStaff = $slots->where('staff_id', $person->id);
                                                    @endphp
                                                    <ul>
                                                        @foreach ($slotsForStaff as $slot)
                                                            <li>
                                                                {{ $slot->slotEmp->slot_day ?? __('common.not_available') }}:
                                                                {{ $slot->slotEmp->slot_start ?? '' }} -
                                                                {{ $slot->slotEmp->slot_end ?? '' }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
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
