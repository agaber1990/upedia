@extends('backEnd.master')
@section('title')
    @lang('front_settings.add_news')
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('Modules/AiContent/Resources/assets/css/ai_content.css') }}">
    <link rel="stylesheet" href="{{ asset('/backEnd/vendors/editor/summernote-bs4.css') }}">
@endpush
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('front_settings.news_list')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#"> @lang('front_settings.frontend_cms')</a>
                    <a href="#">@lang('front_settings.news_list')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            @if (isset($add_news))
                @if (userPermission('store_news'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ route('news_index') }}" class="primary-btn small fix-gr-bg">
                                <span class="ti-plus pr-2"></span>
                                @lang('common.add')
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        @if (isset($add_news))
                            {{ Form::open([
                                'class' => 'form-horizontal',
                                'files' => true,
                                'route' => 'update_news',
                                'method' => 'POST',
                                'enctype' => 'multipart/form-data',
                                'id' => 'add-income-update',
                            ]) }}
                        @else
                            @if (userPermission('store_news'))
                                {{ Form::open([
                                    'class' => 'form-horizontal',
                                    'files' => true,
                                    'route' => 'store_news',
                                    'method' => 'POST',
                                    'enctype' => 'multipart/form-data',
                                    'id' => 'add-income',
                                ]) }}
                            @endif
                        @endif
                        <div class="white-box">
                            <div class="main-title">
                                <h3 class="mb-15">
                                    @if (isset($add_news))
                                        @lang('front_settings.update_news')
                                    @else
                                        @lang('common.add_news')
                                    @endif
                                </h3>
                            </div>
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="primary_input">
                                                    <label class="primary_input_label" for="">@lang('front_settings.title')
                                                        <span class="text-danger"> *</span></label>
                                                    <input class="primary_input_field form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" type="text" name="title"
                                                        autocomplete="off"
                                                        value="{{ isset($add_news) ? $add_news->news_title : old('title') }}">
                                                    <input type="hidden" name="id"
                                                        value="{{ isset($add_news) ? $add_news->id : '' }}">


                                                    @if ($errors->has('title'))
                                                        <span class="text-danger" >
                                                            {{ $errors->first('title') }}
                                                        </span>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row mt-15">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="primary_input">
                                                            <label class="primary_field_label" for="">@lang('common.image')<span class="text-danger"> *</span></label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                class="primary_input_field form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" type="text" id="placeholderFileOneName" placeholder="{{ isset($add_news) ? ($add_news->image != '' ? getFilePath3($add_news->image) : trans('front_settings.image') . ' *') : trans('front_settings.image') . ' *' }}" readonly>

                                                                <button class="" type="button">
                                                                    <label class="primary-btn small fix-gr-bg" for="addNewsImage">{{ __('common.browse') }}</label>
                                                                    <input type="file" class="d-none" name="image" id="addNewsImage">
                                                                </button>
                                                                
                                                                @if ($errors->has('image'))
                                                                    <span class="text-danger" >
                                                                        {{ $errors->first('image') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label class="primary_input_label" for="">@lang('common.category')
                                                    <span class="text-danger"> *</span></label>
                                                <select class="primary_select form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" name="category_id">
                                                    <option data-display="@lang('common.select') *" value="">
                                                        @lang('common.select') *
                                                    </option>
                                                    @foreach ($news_category as $value)
                                                        <option data-display="{{ $value->category_name }}"
                                                            value="{{ $value->id }}"
                                                            @if (isset($add_news)) @if ($add_news->category_id == $value->id)
                                                                selected @endif
                                                            @endif>
                                                            {{ $value->category_name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('category_id'))
                                                    <span class="text-danger invalid-select" role="alert">
                                                        {{ $errors->first('category_id') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row  mt-15">
                                            <div class="col-lg-12">
                                                <div class="primary_input">
                                                    <label class="primary_input_label"
                                                        for="date_of_birth">{{ __('common.publish_date') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="primary_datepicker_input">
                                                        <div class="no-gutters input-right-icon">
                                                            <div class="col">
                                                                <div class="">
                                                                    <input
                                                                        class="primary_input_field date form-control{{ $errors->has('date') ? ' is-invalid' : '' }}"
                                                                        id="startDate" type="text"
                                                                        placeholder="@lang('common.date') *" name="date"
                                                                        value="{{ isset($add_news) ? date('m/d/Y', strtotime($add_news->publish_date)) : date('m/d/Y') }}">
                                                                        <button class="btn-date" data-id="#startDate" type="button">
                                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                                        </button>
                                                                        @if ($errors->has('date'))
                                                                            <span class="text-danger invalid-select" role="alert">
                                                                                {{ $errors->first('date') }}
                                                                            </span>
                                                                        @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-15">
                                        <img class="previewImageSize {{ @$add_news->image ? '' : 'd-none' }}" src="{{ @$add_news->image ? asset($add_news->image) : '' }}" alt="" id="newsImageShow" height="100%" width="100%">
                                    </div>
                                    <div class="col-md-12 mt-15">
                                        <div class="primary_input">
                                            <label class="primary_input_label d-flex" for="">@lang('common.description')
                                                <span
                                                    class="text-danger">*</span>
                                                @if (moduleStatusCheck('AiContent'))
                                                    @include('aicontent::inc.button')
                                                @endif
                                            </label>
                                            <textarea class="generated-text primary_input_field form-control{{ $errors->has('description') ? ' is-invalid' : '' }} newsSummerNote"
                                                name="description">{!! isset($add_news) ? $add_news->news_body : old('description') !!}</textarea>
                                            @if ($errors->has('description'))
                                                <span class="text-danger" >
                                                    {{ $errors->first('description') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-15">
                                        <label class="primary_input_label" for="">@lang('common.news_status')</label>
                                        <div class="">
                                            <input type="checkbox" id="newsStatus" class="common-checkbox form-control" name="status" value=1 {{ isset($add_news) ? ($add_news->status == 1 ? 'checked' : '') : 'checked' }}>
                                            <label for="newsStatus">{{__('common.show')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-15">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="primary_input_label" for="">@lang('common.use_global_settings_for_can_comment_and_comment_auto_approval')</label>
                                                <div class="">
                                                    <input type="checkbox" id="newsSettings" class="common-checkbox form-control" name="is_global" value="1" {{ isset($add_news) ? ($add_news->is_global == 1 ? 'checked' : '') : 'checked' }}>
                                                    <label for="newsSettings">{{__('common.yes')}}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3 newsSettingsDiv d-none">
                                                <label class="primary_input_label" for="">@lang('common.can_comment_only_for_this_news')</label>
                                                <div class="">
                                                    <input type="checkbox" id="isComment" class="common-checkbox form-control" name="is_comment" value="1" {{ isset($add_news) ? ($add_news->is_comment == 1 ? 'checked' : '') : '' }}>
                                                    <label for="isComment">{{__('common.yes')}}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3 newsSettingsDiv d-none">
                                                <label class="primary_input_label" for="">@lang('common.auto_approval_comment_only_for_this_news')</label>
                                                <div class="">
                                                    <input type="checkbox" id="autoApproval" class="common-checkbox form-control" name="auto_approve" value="1" {{ isset($add_news) ? ($add_news->auto_approve == 1 ? 'checked' : '') : '' }}>
                                                    <label for="autoApproval">{{__('common.yes')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $tooltip = '';
                                    if (userPermission('store_news')) {
                                        $tooltip = '';
                                    }elseif(userPermission('edit-news') && isset($add_news)){
                                        $tooltip = '';
                                    } else {
                                        $tooltip = 'You have no permission to add';
                                    }
                                @endphp
                                <div class="row mt-15">
                                    <div class="col-lg-12 text-center">
                                        @if (Illuminate\Support\Facades\Config::get('app.app_sync'))
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                title="Disabled For Demo "> <button
                                                    class="primary-btn fix-gr-bg  demo_view" style="pointer-events: none;"
                                                    type="button">@lang('front_settings.update')</button></span>
                                        @else
                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                                title="{{ @$tooltip }}">
                                                <span class="ti-check"></span>
                                                @if (isset($add_news))
                                                    @lang('front_settings.update_news')
                                                @else
                                                    @lang('common.add_news')
                                                @endif

                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-40">
                <div class="white-box">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-15">@lang('front_settings.news_list')</h3>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-lg-12">
                            <x-table>
                                <table id="table_id" class="table" cellspacing="0" width="100%">
    
                                    <thead>
    
                                        <tr>
                                            <th>@lang('front_settings.title')</th>
                                            <th>@lang('front_settings.publication_date')</th>
                                            <th>@lang('student.category')</th>
                                            <th>@lang('front_settings.image')</th>
                                            <th>@lang('common.action')</th>
                                        </tr>
                                    </thead>
    
                                    <tbody>
                                        @foreach ($news as $value)
                                            <tr>
                                                <td>{{ $value->news_title }}</td>
                                                <td data-sort="{{ strtotime($value->publish_date) }}">
                                                    {{ $value->publish_date != '' ? dateConvert($value->publish_date) : '' }}
                                                </td>
                                                <td>{{ $value->category != '' ? $value->category->category_name : '' }}</td>
                                                <td><img src="{{ asset($value->image) }}" width="60px" height="50px"></td>
                                                <td>
                                                    <x-drop-down>
                                                        @if (userPermission('newsDetails'))
                                                            <a href="{{ route('newsDetails', $value->id) }}"
                                                                class="dropdown-item small fix-gr-bg modalLink"
                                                                title="@lang('front_settings.news_details')" data-modal-size="modal-lg">
                                                                @lang('common.view')
                                                            </a>
                                                        @endif
                                                        @if (userPermission('edit-news'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('edit-news', $value->id) }}">@lang('common.edit')</a>
                                                        @endif
                                                        @if (userPermission('delete-news'))
                                                            @if (Illuminate\Support\Facades\Config::get('app.app_sync'))
                                                                <span tabindex="0" data-toggle="tooltip"
                                                                    title="Disabled For Demo">
                                                                    <a href="#"
                                                                        class="dropdown-item small fix-gr-bg  demo_view"
                                                                        style="pointer-events: none;">@lang('common.delete')</a></span>
                                                            @else
                                                                <a href="{{ route('for-delete-news', $value->id) }}"
                                                                    class="dropdown-item small fix-gr-bg modalLink"
                                                                    title="@lang('front_settings.delete_news')" data-modal-size="modal-md">
                                                                    @lang('common.delete')
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </x-drop-down>
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
@include('backEnd.partials.date_picker_css_js')
@push('script')
    <script src="{{ asset('/backEnd/') }}/vendors/editor/summernote-bs4.js"></script>
    <script>
        $(document).ready(function(){
            var checkData = $('#newsSettings').is(":checked");
            checkDataFun(checkData);

            $(document).on('click', '#newsSettings', function(){
                if($(this).is(":checked")) {
                    if(!$('.newsSettingsDiv').hasClass('d-none')){
                        $('.newsSettingsDiv').addClass('d-none');
                    }
                }else{
                    if($('.newsSettingsDiv').hasClass('d-none')){
                        $('.newsSettingsDiv').removeClass('d-none');
                    }
                }
            });

            function checkDataFun(checkData){
                if(checkData){
                    if(!$('.newsSettingsDiv').hasClass('d-none')){
                        $('.newsSettingsDiv').addClass('d-none');
                    }
                }else{
                    if($('.newsSettingsDiv').hasClass('d-none')){
                        $('.newsSettingsDiv').removeClass('d-none');
                    }
                }
            }
        });

        
    </script>
    <script>
        $('.newsSummerNote').summernote({
            placeholder: 'Write here',
            tabsize: 2,
            height: 300
        });
    </script>
    
    <script>
        $(document).on('change', '#addNewsImage', function(event) {
            $('#newsImageShow').removeClass('d-none');
            getFileName($(this).val(), '#placeholderFileOneName');
            imageChangeWithFile($(this)[0], '#newsImageShow');
        });
    </script>
@endpush
