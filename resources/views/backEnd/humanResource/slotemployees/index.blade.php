@extends('backEnd.master')
@section('slot_name')
    @lang('hr.slotemployee')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('hr.slotemployee')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('hr.human_resource')</a>
                    <a href="#">@lang('hr.slotemployee')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid p-0">
            @if (isset($slotemployee))
                @if (userPermission('slotemployee-store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ route('slotemployee.index') }}" class="primary-btn small fix-gr-bg">
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
                            @if (isset($slotemployee))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['slotemployee-update', $slotemployee->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                            @else
                                @if (userPermission('slotemployee-store'))
                                    {{ Form::open([ 
                                        'class' => 'form-horizontal',
                                        'files' => true,
                                        'route' => 'slotemployee-store',
                                        'method' => 'POST',
                                        'enctype' => 'multipart/form-data',
                                    ]) }}
                                @endif
                            @endif
                            <div class="white-box">
                                <div class="main-slot_name">
                                    <h3 class="mb-15">
                                        @if (isset($slotemployee))
                                            @lang('hr.edit_slotemployee')
                                        @else
                                            @lang('hr.add_slotemployee')
                                        @endif
                                    </h3>
                                </div>
                                <div class="add-visitor">
                                    <div class="row mt-25">
                                        @php
                                            if (isset($slotemployee)) {
                                                $slotemployee->slot_day = explode(",",$slotemployee->slot_day);
                                            }
                                        @endphp
                                        <div class="col-lg-12">
                                            <label class="primary_input_label" for="">@lang('hr.select_slot_day')
                                                <span class="text-danger"> *</span></label>
                                            <!-- Slot Name Selection (Days of the Week) -->
                                            <select class="primary_select form-control {{ $errors->has('slot_day') ? ' is-invalid' : '' }}" 
                                                    id="select_slot_day" name="slot_day[]" multiple>
                                                <option value="monday" 
                                                    {{ isset($slotemployee) && in_array('monday', $slotemployee->slot_day) ? 'selected' : '' }}>
                                                    @lang('common.monday')
                                                </option>
                                                <option value="tuesday" 
                                                    {{ isset($slotemployee) && in_array('tuesday', $slotemployee->slot_day) ? 'selected' : '' }}>
                                                    @lang('common.tuesday')
                                                </option>
                                                <option value="wednesday" 
                                                    {{ isset($slotemployee) && in_array('wednesday', $slotemployee->slot_day) ? 'selected' : '' }}>
                                                    @lang('common.wednesday')
                                                </option>
                                                <option value="thursday" 
                                                    {{ isset($slotemployee) && in_array('thursday', $slotemployee->slot_day) ? 'selected' : '' }}>
                                                    @lang('common.thursday')
                                                </option>
                                                <option value="friday" 
                                                    {{ isset($slotemployee) && in_array('friday', $slotemployee->slot_day) ? 'selected' : '' }}>
                                                    @lang('common.friday')
                                                </option>
                                                <option value="saturday" 
                                                    {{ isset($slotemployee) && in_array('saturday', $slotemployee->slot_day) ? 'selected' : '' }}>
                                                    @lang('common.saturday')
                                                </option>
                                                <option value="sunday" 
                                                    {{ isset($slotemployee) && in_array('sunday', $slotemployee->slot_day) ? 'selected' : '' }}>
                                                    @lang('common.sunday')
                                                </option>
                                            </select>
                                            @if ($errors->has('slot_day'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('slot_day') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    

                                    <!-- Slot Start Date -->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('hr.slot_start')
                                                    <span class="text-danger"> *</span></label>
                                                <input
                                                    class="primary_input_field form-control{{ $errors->has('slot_start') ? ' is-invalid' : '' }}"
                                                    type="time" name="slot_start"
                                                    value="{{ isset($slotemployee) ? $slotemployee->slot_start : Request::old('slot_start') }}">

                                                @if ($errors->has('slot_start'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('slot_start') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Slot End Date -->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('hr.slot_end')
                                                    <span class="text-danger"> *</span></label>
                                                <input
                                                    class="primary_input_field form-control{{ $errors->has('slot_end') ? ' is-invalid' : '' }}"
                                                    type="time" name="slot_end"
                                                    value="{{ isset($slotemployee) ? $slotemployee->slot_end : Request::old('slot_end') }}">

                                                @if ($errors->has('slot_end'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('slot_end') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $tooltip = '';
                                        if (userPermission('slotemployee-store')) {
                                            $tooltip = '';
                                        } elseif (isset($slotemployee) && userPermission('slotemployee-edit')) {
                                            $tooltip = '';
                                        } else {
                                            $tooltip = 'You have no permission to add';
                                        }
                                    @endphp

                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                                slot_name="{{ $tooltip }}">
                                                <span class="ti-check"></span>
                                                @isset($slotemployee)
                                                    @lang('hr.update_slotemployee')
                                                @else
                                                    @lang('hr.save_slotemployee')
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
                                <div class="main-slot_name">
                                    <h3 class="mb-15">@lang('hr.slotemployee_list')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table" cellspacing="0" width="100%">

                                        <thead>

                                            <tr>
                                                <th>@lang('hr.slotemployee')</th>
                                                <th>@lang('hr.slot_start')</th>
                                                <th>@lang('hr.slot_end')</th>
                                                <th>@lang('common.action')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($slotemployees as $item)
                                                <tr>
                                                    <td>{{ $item->slot_day }}</td>
                                                    <td>{{ $item->slot_start }}</td>
                                                    <td>{{ $item->slot_end }}</td>
                                                    <td>
                                                        <x-drop-down>
                                                            @if (userPermission('slotemployee-edit'))
                                                                <a class="dropdown-item"
                                                                    href="{{ route('slotemployee-edit', [$item->id]) }}">@lang('common.edit')</a>
                                                            @endif
                                                            @if (userPermission('slotemployee-delete'))
                                                                <a class="dropdown-item" data-toggle="modal"
                                                                    data-target="#deleteslotemployeeModal{{ $item->id }}"
                                                                    href="#">@lang('common.delete')</a>
                                                            @endif
                                                        </x-drop-down>
                                                    </td>
                                                </tr>
                                                <div class="modal fade admin-query"
                                                    id="deleteslotemployeeModal{{ $item->id }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-slot_name">@lang('hr.delete_slotemployee')</h4>
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
                                                                    {{ Form::open(['route' => ['slotemployee-delete', $item->id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
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
