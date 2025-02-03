@extends('backEnd.master')
@section('title')
    @lang('hr.emtype')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('hr.emtype')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a>@lang('hr.human_resource')</a>
                    <a>@lang('hr.emtype')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid p-0">
            @if (isset($emtype))
                @if (userPermission('emtype-store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ route('emtype') }}" class="primary-btn small fix-gr-bg">
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
                            @if (isset($emtype))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['emtype-update', $emtype->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                            @else
                                @if (userPermission('emtype-store'))
                                    {{ Form::open([
                                        'class' => 'form-horizontal',
                                        'files' => true,
                                        'route' => 'emtype-store',
                                        'method' => 'POST',
                                        'enctype' => 'multipart/form-data',
                                    ]) }}
                                @endif
                            @endif
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        @if (isset($emtype))
                                            @lang('hr.edit_emtype')
                                        @else
                                            @lang('hr.add_emtype')
                                        @endif
                                    </h3>
                                </div>
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('hr.emtype_title')
                                                    <span class="text-danger"> *</span></label>
                                                <input
                                                    class="primary_input_field form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                    type="text" name="title" autocomplete="off"
                                                    value="{{ isset($emtype) ? $emtype->title : Request::old('title') }}">
                                                <input type="hidden" name="id"
                                                    value="{{ isset($emtype) ? $emtype->id : '' }}">

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
                                        if (userPermission('emtype-store')) {
                                            $tooltip = '';
                                        } elseif (isset($emtype) && userPermission('emtype-edit')) {
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
                                                @isset($emtype)
                                                    @lang('hr.update_emtype')
                                                @else
                                                    @lang('hr.save_emtype')
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
                                    <h3 class="mb-15">@lang('hr.emtype_list')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table" cellspacing="0" width="100%">

                                        <thead>

                                            <tr>
                                                <th>@lang('hr.emtype')</th>
                                                <th>@lang('common.action')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($emtypes as $emtype)
                                                <tr>
                                                    <td>{{ $emtype->title }}</td>
                                                    <td>
                                                        <x-drop-down>
                                                            @if (userPermission('emtype-edit'))
                                                                <a class="dropdown-item"
                                                                    href="{{ route('emtype-edit', [$emtype->id]) }}">@lang('common.edit')</a>
                                                            @endif
                                                            @if (userPermission('emtype-delete'))
                                                                <a class="dropdown-item" data-toggle="modal"
                                                                    data-target="#deleteemtypeModal{{ $emtype->id }}"
                                                                    href="#">@lang('common.delete')</a>
                                                            @endif
                                                        </x-drop-down>
                                                    </td>
                                                </tr>
                                                <div class="modal fade admin-query"
                                                    id="deleteemtypeModal{{ $emtype->id }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">@lang('hr.delete_emtype')</h4>
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
                                                                    {{ Form::open(['route' => ['emtype-delete', $emtype->id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
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
