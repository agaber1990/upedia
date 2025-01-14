@extends('backEnd.master')
@section('title')
    @lang('academics.discount_plan')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('academics.discount_plan')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('academics.academics')</a>
                    <a href="#">@lang('academics.discount_plan')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid p-0">
            @if (isset($discountPlan))
                @if (userPermission('discount_plans-store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ route('discount_plans') }}" class="primary-btn small fix-gr-bg">
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
                            @if (isset($discountPlan))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['discount_plans-update', $discountPlan->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                            @else
                                @if (userPermission('discount_plans-store'))
                                    {{ Form::open([
                                        'class' => 'form-horizontal',
                                        'files' => true,
                                        'route' => 'discount_plans-store',
                                        'method' => 'POST',
                                        'enctype' => 'multipart/form-data',
                                    ]) }}
                                @endif
                            @endif
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        @if (isset($discountPlan))
                                            @lang('academics.edit_discount_plan')
                                        @else
                                            @lang('academics.add_discount_plan')
                                        @endif
                                    </h3>
                                </div>
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="name_en">@lang('academics.name_en')
                                                    <span class="text-danger"> *</span>
                                                </label>
                                                <input
                                                    class="primary_input_field form-control{{ $errors->has('name_en') ? ' is-invalid' : '' }}"
                                                    type="text" name="name_en" id="name_en" autocomplete="off"
                                                    value="{{ old('name_en', isset($discountPlan) ? $discountPlan->name_en : '') }}">

                                                @if ($errors->has('name_en'))
                                                    <span class="text-danger">{{ $errors->first('name_en') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="name_ar">@lang('academics.name_ar')
                                                    <span class="text-danger"> *</span>
                                                </label>
                                                <input
                                                    class="primary_input_field form-control{{ $errors->has('name_ar') ? ' is-invalid' : '' }}"
                                                    type="text" name="name_ar" id="name_ar" autocomplete="off"
                                                    value="{{ old('name_ar', isset($discountPlan) ? $discountPlan->name_ar : '') }}">

                                                @if ($errors->has('name_ar'))
                                                    <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- Repeated sections --}}

                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <button class="btn btn-info" id="addMore">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div id="repeatedSection">
                                        @if (isset($discountPlan->levels_prices) && is_array($discountPlan->levels_prices))
                                            @foreach ($discountPlan->levels_prices as $index => $levelPrice)
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="primary_input">
                                                            <label class="primary_input_label"
                                                                for="level_id">@lang('academics.level_number')
                                                                <span class="text-danger"> *</span>
                                                            </label>
                                                            <select class="primary_select form-control" name="level_id[]"
                                                                id="level_id{{ $index }}">
                                                                <option value="" disabled>@lang('academics.select_level')</option>
                                                                @foreach ($levels as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ $item->id == $levelPrice['level_id'] ? 'selected' : '' }}>
                                                                        {{ $item->level_number }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="primary_input">
                                                            <label class="primary_input_label"
                                                                for="price">@lang('academics.price')
                                                                <span class="text-danger"> *</span>
                                                            </label>
                                                            <input class="primary_input_field form-control" type="text"
                                                                name="price[]" id="price{{ $index }}"
                                                                value="{{ $levelPrice['price'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <button class="btn btn-danger removeSection">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div id="repeatedSection">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="primary_input">
                                                            <label class="primary_input_label"
                                                                for="level_id">@lang('academics.level_number')
                                                                <span class="text-danger"> *</span>
                                                            </label>

                                                            <select
                                                                class="primary_select form-control{{ $errors->has('level_id') ? ' is-invalid' : '' }}"
                                                                name="level_id[]" id="level_id">
                                                                <option value="" disabled selected>@lang('academics.select_level')
                                                                </option>
                                                                @foreach ($levels as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ old('level_id', isset($discountPlan) ? $discountPlan->level_id : '') == $item->id ? 'selected' : '' }}>
                                                                        {{ $item->level_number }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('level_id'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('level_id') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="primary_input">

                                                            <label class="primary_input_label"
                                                                for="price">@lang('academics.price')
                                                                <span class="text-danger"> *</span>
                                                            </label>
                                                            <input
                                                                class="primary_input_field form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                                                                type="text" name="price[]" id="price"
                                                                autocomplete="off"
                                                                value="{{ old('price', isset($discountPlan) ? $discountPlan->price : '') }}">

                                                            @if ($errors->has('price'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('price') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    @php
                                        $tooltip = '';
                                        if (userPermission('discount_plans-store')) {
                                            $tooltip = '';
                                        } elseif (isset($discountPlan) && userPermission('discount_plans-edit')) {
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
                                                @isset($discountPlan)
                                                    @lang('academics.update_discount_plan')
                                                @else
                                                    @lang('academics.save_discount_plan')
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
                                    <h3 class="mb-15">@lang('academics.discount_plan_list')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table" cellspacing="0" width="100%">

                                        <thead>

                                            <tr>
                                                {{-- <th>@lang('academics.level_number')</th> --}}
                                                <th>@lang('academics.levels_prices')</th>
                                                <th>@lang('academics.name_en')</th>
                                                <th>@lang('academics.name_ar')</th>
                                                <th>@lang('common.action')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($discountPlans as $discountPlan)
                                                <tr>

                                                    <td>
                                                        @php
                                                            $levelsPrices = array_map(function ($levelPrice) use (
                                                                $levels,
                                                            ) {
                                                                $levelNumber =
                                                                    $levels
                                                                        ->where('id', $levelPrice['level_id'])
                                                                        // ->pluck('level_number');
                                                                        ->first()->level_number ?? 'N/A';
                                                                return 'Level ID: ' .
                                                                    $levelNumber .
                                                                    ', Price: ' .
                                                                    $levelPrice['price'];
                                                            }, $discountPlan->levels_prices);
                                                            echo implode('<br> ', $levelsPrices);
                                                        @endphp
                                                    </td>

                                                    <td>{{ $discountPlan->name_en }}</td>
                                                    <td>{{ $discountPlan->name_ar }}</td>
                                                    <td>
                                                        <x-drop-down>
                                                            @if (userPermission('discount_plans-edit'))
                                                                <a class="dropdown-item"
                                                                    href="{{ route('discount_plans-edit', [$discountPlan->id]) }}">@lang('common.edit')</a>
                                                            @endif
                                                            @if (userPermission('discount_plans-delete'))
                                                                <a class="dropdown-item" data-toggle="modal"
                                                                    data-target="#deletediscount_planModal{{ $discountPlan->id }}"
                                                                    href="#">@lang('common.delete')</a>
                                                            @endif
                                                        </x-drop-down>
                                                    </td>
                                                </tr>
                                                <div class="modal fade admin-query"
                                                    id="deletediscount_planModal{{ $discountPlan->id }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">@lang('academics.delete_discount_plan')</h4>
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
                                                                    {{ Form::open(['route' => ['discount_plans-delete', $discountPlan->id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
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
@push('scripts')
    <script>
        $(document).ready(function() {
            var counter = 1;

            // Add more sections
            $('#addMore').click(function(event) {
                event.preventDefault();
                var newSection = `
            <div class="row">
                <div class="col-md-12">
                    <div class="primary_input">
                        <label class="primary_input_label" for="level_id">@lang('academics.level_number')
                            <span class="text-danger"> *</span>
                        </label>
                        <select
                            class="primary_select form-control"
                            name="level_id[]" id="level_id${counter}">
                            <option value="" disabled selected>@lang('academics.select_level')</option>
                            @foreach ($levels as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->level_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="primary_input">
                        <label class="primary_input_label" for="price">@lang('academics.price')
                            <span class="text-danger"> *</span>
                        </label>
                        <input
                            class="primary_input_field form-control"
                            type="text" name="price[]" id="price${counter}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <button class="btn btn-danger removeSection">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>`;
                $('#repeatedSection').append(newSection);
                counter++;
            });
            // Remove section
            $('#repeatedSection').on('click', '.removeSection', function(event) {
                event.preventDefault();
                $(this).closest('.row').remove();
                toggleRemoveButtons();
            });

            function toggleRemoveButtons() {
                if ($('#repeatedSection .row').length > 1) {
                    $('.removeSection').show();
                } else {
                    $('.removeSection').hide();
                }
            }
            toggleRemoveButtons();
        });
    </script>
@endpush
@include('backEnd.partials.data_table_js')
