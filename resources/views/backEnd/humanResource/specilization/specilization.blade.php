@extends('backEnd.master')
@section('title')
    @lang('hr.specilization')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('hr.specilization')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a>@lang('hr.human_resource')</a>
                    <a>@lang('hr.specilization')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid p-0">
            @if (isset($specilization))
                @if (userPermission('specilization-store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ route('specilization') }}" class="primary-btn small fix-gr-bg">
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
                            @if (isset($specilization))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['specilization-update', $specilization->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                            @else
                                @if (userPermission('specilization-store'))
                                    {{ Form::open([
                                        'class' => 'form-horizontal',
                                        'files' => true,
                                        'route' => 'specilization-store',
                                        'method' => 'POST',
                                        'enctype' => 'multipart/form-data',
                                    ]) }}
                                @endif
                            @endif
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        @if (isset($specilization))
                                            @lang('hr.edit_specilization')
                                        @else
                                            @lang('hr.add_specilization')
                                        @endif
                                    </h3>
                                </div>
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('hr.specilization_title')
                                                    <span class="text-danger"> *</span></label>
                                                <input
                                                    class="primary_input_field form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                    type="text" name="title" autocomplete="off"
                                                    value="{{ isset($specilization) ? $specilization->title : Request::old('title') }}">
                                                <input type="hidden" name="id"
                                                    value="{{ isset($specilization) ? $specilization->id : '' }}">

                                                @if ($errors->has('title'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('title') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $tooltip = '';
                                        if (userPermission('specilization-store')) {
                                            $tooltip = '';
                                        } elseif (isset($specilization) && userPermission('specilization-edit')) {
                                            $tooltip = '';
                                        } else {
                                            $tooltip = 'You have no permission to add';
                                        }
                                    @endphp
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                                title="{{ $tooltip }}">
                                                <span class="ti-check"></span>
                                                @isset($specilization)
                                                    @lang('hr.update_specilization')
                                                @else
                                                    @lang('hr.save_specilization')
                                                @endisset
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
                                    <h3 class="mb-15">@lang('hr.specilization_list')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table" cellspacing="0" width="100%">

                                        <thead>

                                            <tr>
                                                <th>@lang('hr.specilization')</th>
                                                <th>@lang('common.action')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($specilizations as $specilization)
                                                <tr>
                                                    <td>{{ $specilization->title }}</td>
                                                    <td>
                                                        <x-drop-down>
                                                            @if (userPermission('specilization-edit'))
                                                                <a class="dropdown-item"
                                                                    href="{{ route('specilization-edit', [$specilization->id]) }}">@lang('common.edit')</a>
                                                            @endif
                                                            @if (userPermission('specilization-delete'))
                                                                <a class="dropdown-item" data-toggle="modal"
                                                                    data-target="#deletespecilizationModal{{ $specilization->id }}"
                                                                    href="#">@lang('common.delete')</a>
                                                            @endif
                                                        </x-drop-down>
                                                    </td>
                                                </tr>
                                                <div class="modal fade admin-query"
                                                    id="deletespecilizationModal{{ $specilization->id }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">@lang('hr.delete_specilization')</h4>
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
                                                                    {{ Form::open(['route' => ['specilization-delete', $specilization->id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
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
