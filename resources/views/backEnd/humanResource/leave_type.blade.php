@extends('backEnd.master')
@section('title')
    @lang('leave.leave_type')
@endsection
@section('mainContent')


    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('leave.leave_type')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a>@lang('leave.leave')</a>
                    <a>@lang('leave.leave_type')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if (isset($leave_type))
                @if (userPermission('leave-type-store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ route('leave-type') }}" class="primary-btn small fix-gr-bg">
                                <span class="ti-plus pr-2"></span>
                                @lang('common.add')
                            </a>
                        </div>
                    </div>
                @endif
            @endif
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (isset($leave_type))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['leave-type-update', $leave_type->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                            @else
                                @if (userPermission('leave-type-store'))
                                    {{ Form::open([
                                        'class' => 'form-horizontal',
                                        'files' => true,
                                        'route' => 'leave-type-store',
                                        'method' => 'POST',
                                        'enctype' => 'multipart/form-data',
                                    ]) }}
                                @endif
                            @endif
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        @if (isset($leave_type))
                                            @lang('leave.edit_leave_type')
                                        @else
                                            @lang('leave.add_leave_type')
                                        @endif
                                    </h3>
                                </div>
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="type_name">@lang('leave.type_name') <span
                                                        class="text-danger"> *</span> </label>
                                                <input id="type_name" required
                                                    class="primary_input_field form-control{{ $errors->has('type') ? ' is-invalid' : '' }}"
                                                    type="text" name="type" autocomplete="off"
                                                    value="{{ isset($leave_type) ? $leave_type->type : Request::old('type') }}">

                                                <input type="hidden" name="id"
                                                    value="{{ isset($leave_type) ? $leave_type->id : '' }}">


                                                @if ($errors->has('type'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('type') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="primary_input">
                                                <label class="primary_input_label"
                                                    for="max_leaves_allowed">@lang('leave.max_leaves_allowed') <span class="text-danger">
                                                        *</span> </label>
                                                <input id="max_leaves_allowed" required
                                                    class="primary_input_field form-control{{ $errors->has('max_leaves_allowed') ? ' is-invalid' : '' }}"
                                                    type="number" name="max_leaves_allowed" autocomplete="off"
                                                    value="{{ isset($leave_type) ? $leave_type->max_leaves_allowed : Request::old('max_leaves_allowed') }}">
                                                @if ($errors->has('max_leaves_allowed'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('max_leaves_allowed') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="primary_input">
                                                <label class="primary_input_label"
                                                    for="applicable_after_work_days">@lang('leave.applicable_after_work_days') <span
                                                        class="text-danger"> *</span> </label>
                                                <input id="applicable_after_work_days" required
                                                    class="primary_input_field form-control{{ $errors->has('applicable_after_work_days') ? ' is-invalid' : '' }}"
                                                    type="number" name="applicable_after_work_days" autocomplete="off"
                                                    value="{{ isset($leave_type) ? $leave_type->applicable_after_work_days : Request::old('applicable_after_work_days') }}">
                                                @if ($errors->has('applicable_after_work_days'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('applicable_after_work_days') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="primary_input mt-3">

                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input{{ $errors->has('is_leave_without_pay') ? ' is-invalid' : '' }}"
                                                        type="checkbox" name="is_leave_without_pay"
                                                        id="is_leave_without_pay" value="1"
                                                        {{ isset($leave_type) && $leave_type->is_leave_without_pay ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="is_leave_without_pay">
                                                        @lang('leave.is_leave_without_pay')
                                                    </label>
                                                </div>

                                                @if ($errors->has('is_leave_without_pay'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('is_leave_without_pay') }}
                                                    </span>
                                                @endif
                                            </div>


                                        </div>
                                    </div>
                                    @php
                                        $tooltip = '';
                                        if (userPermission('leave-type-store')) {
                                            $tooltip = '';
                                        } else {
                                            $tooltip = 'You have no permission to add';
                                        }
                                    @endphp
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip"
                                                title="{{ $tooltip }}">
                                                <span class="ti-check"></span>

                                                @if (isset($leave_type))
                                                    @lang('leave.update_type')
                                                @else
                                                    @lang('leave.save_type')
                                                @endif

                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15">@lang('leave.leave_type_list')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table" cellspacing="0" width="100%">

                                        <thead>

                                            <tr>
                                                <th>@lang('common.type')</th>
                                                <th>@lang('leave.max_leaves_allowed')</th>
                                                <th>@lang('leave.applicable_after_work_days')</th>
                                                <th>@lang('leave.is_leave_without_pay')</th>

                                                <th>@lang('common.action')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($leave_types as $leave_type)
                                                <tr>
                                                    <td>{{ $leave_type->type }}</td>
                                                    <td>{{ $leave_type->max_leaves_allowed }}</td>
                                                    <td>{{ $leave_type->applicable_after_work_days }}</td>
                                                    <td>{{ $leave_type->is_leave_without_pay ? 'Yes' : 'No' }}</td>

                                                    <td>
                                                        <x-drop-down>
                                                            @if (userPermission('leave-type-edit'))
                                                                <a class="dropdown-item"
                                                                    href="{{ route('leave-type-edit', [$leave_type->id]) }}">@lang('common.edit')</a>
                                                            @endif
                                                            @if (userPermission('leave-type-delete'))
                                                                <a class="dropdown-item" data-toggle="modal"
                                                                    data-target="#deleteLeaveTypeModal{{ $leave_type->id }}"
                                                                    href="#">@lang('common.delete')</a>
                                                            @endif
                                                        </x-drop-down>
                                                    </td>
                                                </tr>
                                                <div class="modal fade admin-query"
                                                    id="deleteLeaveTypeModal{{ $leave_type->id }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">@lang('leave.delete_leave_type')</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="text-center">
                                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                                </div>

                                                                <div class="mt-40 d-flex justify-content-between">
                                                                    <button type="button" class="primary-btn tr-bg"
                                                                        data-dismiss="modal">@lang('common.cancel')</button>
                                                                    {{ Form::open(['route' => ['leave-type-delete', $leave_type->id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                                    <button class="primary-btn fix-gr-bg"
                                                                        type="submit">@lang('common.delete')</button>
                                                                    {{ Form::close() }}
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </x-table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@include('backEnd.partials.data_table_js')
