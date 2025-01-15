@extends('backEnd.master')
@section('title')
    @lang('academics.track')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('academics.track')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('academics.dashboard')</a>
                    <a href="#">@lang('academics.academics')</a>
                    <a href="#">@lang('academics.track')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">


            <div class="row">
                <!-- Form Section -->
                <div class="col-lg-4 col-xl-3">
                    <div class="white-box">
                        <div class="main-title">
                            <h3 class="mb-15">
                                @if (isset($track))
                                    @lang('academics.edit_track')
                                @else
                                    @lang('academics.add_track')
                                @endif
                            </h3>
                        </div>

                        @if (isset($track))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['tracks_update', $track->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @else
                            @if (userPermission('tracks_store'))
                                {{ Form::open([
                                    'class' => 'form-horizontal',
                                    'files' => true,
                                    'route' => 'tracks_store',
                                    'method' => 'POST',
                                    'enctype' => 'multipart/form-data',
                                ]) }}
                            @endif
                        @endif
                        <div class="add-visitor">
                            <!-- Track Name EN -->

                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">@lang('common.categories')
                                        </label>
                                        <select
                                            class="primary_select  form-control {{ $errors->has('cat_id') ? ' is-invalid' : '' }}"
                                            name="cat_id" id="cat_id">
                                            <option data-display="@lang('common.categories') *" value="">@lang('common.categories')
                                                *</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('cat_id', isset($track) ? $track->id : '') == $item->id ? 'selected' : '' }}>
                                                    {{ app()->getLocale() == 'en' ? $item->name_en : $item->name_ar }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('cat_id'))
                                            <span class="text-danger invalid-select" role="alert">
                                                {{ $errors->first('cat_id') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="primary_input">
                                        <label for="track_name_en">@lang('academics.track_name_en') <span class="text-danger">
                                                *</span></label>
                                        <input
                                            class="primary_input_field form-control {{ $errors->has('track_name_en') ? 'is-invalid' : '' }}"
                                            type="text" id="track_name_en" name="track_name_en"
                                            value="{{ old('track_name_en', isset($track) ? $track->track_name_en : '') }}">
                                        @error('track_name_en')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Track Name AR -->
                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="primary_input">
                                        <label for="track_name_ar">@lang('academics.track_name_ar') <span class="text-danger">
                                                *</span></label>
                                        <input
                                            class="primary_input_field form-control {{ $errors->has('track_name_ar') ? 'is-invalid' : '' }}"
                                            type="text" id="track_name_ar" name="track_name_ar"
                                            value="{{ old('track_name_ar', isset($track) ? $track->track_name_ar : '') }}">
                                        @error('track_name_ar')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Level Number -->
                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <label class="primary_input_label" for="level_number">
                                        @lang('academics.level_number') <span class="text-danger"> *</span>
                                    </label>
                                    <select
                                        class="primary_select form-control {{ $errors->has('level_number') ? 'is-invalid' : '' }}"
                                        id="level_number" name="level_number">
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}"
                                                {{ old('level_number', isset($track) ? $track->level_number : '') == $level->id ? 'selected' : '' }}>
                                                {{ $level->level_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('level_number')
                                        <span class="text-danger invalid-select" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- session -->
                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <label class="primary_input_label" for="session">
                                        @lang('academics.session') <span class="text-danger"> *</span>
                                    </label>
                                    <select
                                        class="primary_select form-control {{ $errors->has('session') ? 'is-invalid' : '' }}"
                                        id="session" name="session">
                                        @for ($i = 1; $i <= 20; $i++)
                                            <option value="{{ $i }}"
                                                {{ old('session', isset($track) ? $track->session : '') == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('session')
                                        <span class="text-danger invalid-select" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Length -->
                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <label class="primary_input_label" for="length">
                                        @lang('academics.length') <span class="text-danger"> *</span>
                                    </label>
                                    <select
                                        class="primary_select form-control {{ $errors->has('length') ? 'is-invalid' : '' }}"
                                        id="length" name="length">
                                        @for ($i = 1; $i <= 20; $i++)
                                            <option value="{{ $i }}"
                                                {{ old('length', isset($track) ? $track->length : '') == $i ? 'selected' : '' }}>
                                                {{ $i }} @lang('academics.weeks')
                                            </option>
                                        @endfor
                                    </select>
                                    @error('length')
                                        <span class="text-danger invalid-select" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Schedule -->
                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <label class="primary_input_label" for="schedule">
                                        @lang('academics.schedule') <span class="text-danger"> *</span>
                                    </label>
                                    <select
                                        class="primary_select form-control {{ $errors->has('schedule') ? 'is-invalid' : '' }}"
                                        id="schedule" name="schedule">
                                        <option value="once"
                                            {{ old('schedule', isset($track) ? $track->schedule : '') == 'once' ? 'selected' : '' }}>
                                            @lang('academics.once')
                                        </option>
                                        <option value="twice"
                                            {{ old('schedule', isset($track) ? $track->schedule : '') == 'twice' ? 'selected' : '' }}>
                                            @lang('academics.twice')
                                        </option>
                                    </select>
                                    @error('schedule')
                                        <span class="text-danger invalid-select" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Valid For -->
                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <label class="primary_input_label" for="valid_for">
                                        @lang('academics.valid_for') <span class="text-danger"> *</span>
                                    </label>
                                    <select
                                        class="primary_select form-control {{ $errors->has('valid_for') ? 'is-invalid' : '' }}"
                                        id="valid_for" name="valid_for[]" multiple>
                                        @foreach ($valid_for as $type)
                                            <option value="{{ $type->id }}"
                                                {{ in_array($type->id, old('valid_for', isset($track) ? json_decode($track->valid_for, true) : [])) ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('valid_for')
                                        <span class="text-danger invalid-select" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-40">
                                <div class="col-lg-12 text-center">
                                    <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="">
                                        <span class="ti-check"></span>
                                        @if (isset($track))
                                            @lang('academics.update_track')
                                        @else
                                            @lang('academics.save_track')
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>

                <!-- Track List Section -->
                <div class="col-lg-8 col-xl-9">
                    <div class="white-box">
                        <div class="main-title">
                            <h3 class="mb-15">@lang('academics.track_list')</h3>
                        </div>
                        <x-table>
                            <table id="table_id" class="table Crm_table_active3">
                                <thead>
                                    <tr>
                                        <th>@lang('academics.track_name_en')</th>
                                        <th>@lang('academics.level_number')</th>
                                        <th>@lang('academics.schedule')</th>
                                        <th>@lang('academics.length')</th>
                                        <th>@lang('academics.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tracks as $track)
                                        <tr>
                                            <td>{{ $track->track_name_en }}</td>
                                            <td>{{ $track->level_number }}</td>
                                            <td>{{ $track->schedule }}</td>
                                            <td>{{ $track->length }} @lang('academics.weeks')</td>
                                            <td>
                                                <x-drop-down>
                                                    @if (userPermission('track_sessions'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('track_sessions', [$track->id]) }}">
                                                            @lang('common.track_sessions')</a>
                                                    @endif
                                                    @if (userPermission('assigned_pricing_plan'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('tracksPricingPlan', [$track->id]) }}">
                                                            @lang('common.pricing_plan')</a>
                                                    @endif
                                                    @if (userPermission('tracks_edit'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('tracks_edit', [$track->id]) }}">@lang('common.edit')</a>
                                                    @endif
                                                    @if (userPermission('track_delete'))
                                                        <a class="dropdown-item" data-toggle="modal"
                                                            data-target="#deletetrackModal{{ $track->id }}"
                                                            href="#">@lang('common.delete')</a>
                                                    @endif
                                                </x-drop-down>
                                            </td>
                                        </tr>
                                        <div class="modal fade admin-query" id="deletetrackModal{{ $track->id }}">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('academics.delete_track')</h4>
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
                                                            {{ Form::open(['route' => ['tracks_delete', $track->id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
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
    </section>
@endsection
