@extends('backEnd.master')

@section('title') 
@lang('academics.assign_subject_create')
@endsection

@section('mainContent')
<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('academics.assign_subject_create')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('academics.academics')</a>
                <a href="{{route('assign_subject')}}">@lang('academics.assign_subject')</a>
                <a href="{{route('assign_subject_create')}}">@lang('academics.assign_subject_create')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="main-title">
                    <h3 class="mb-30">@lang('common.select_criteria')</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
              
                <div class="white-box">
                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'assign_subject_search', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_student']) }}
                        <div class="row">
                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                            <div class="col-lg-6 mb-3 mb-lg-0">
                                <select class="primary_select form-control {{ @$errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                    <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class') *</option>
                                    @foreach($classes as $class)
                                    <option value="{{@$class->id}}" {{isset($class_id)? ($class_id == $class->id? 'selected':''):''}}>{{@$class->class_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('class'))
                                <span class="text-danger invalid-select" role="alert">
                                    {{ @$errors->first('class') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6 mb-3 mb-lg-0" id="select_section_div">
                                <select class="primary_select form-control {{ @$errors->has('section') ? ' is-invalid' : '' }}" id="select_section" name="section">
                                    <option data-display="@lang('common.select_section') *" value="">@lang('common.select_section')</option>
                                </select>
                                <div class="pull-right loader loader_style" id="select_section_loader">
                                    <img class="loader_img_style" src="{{asset('/backEnd/img/demo_wait.gif')}}" alt="loader">
                                </div>
                                @if ($errors->has('section'))
                                <span class="text-danger invalid-select" role="alert">
                                    {{ @$errors->first('section') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg">
                                    <span class="ti-search pr-2"></span>
                                    @lang('common.search')
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>

@if(isset($assign_subjects) && $assign_subjects->count() > 0)
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
        <div class="row mt-40">
            <div class="col-lg-6 col-md-6 col-9">
                <div class="main-title">
                    <h3 class="mb-30">@lang('academics.assign_subject_create') </h3>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 text-right col-3">
                <button class="primary-btn icon-only fix-gr-bg" id="addNewSubject" type="button">
                    <span class="ti-plus" ></span>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'assign-subject-store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'assign_subject']) }}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="assign-subject" id="assign-subject">
                                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                    <input type="hidden" name="class_id" id="class_id" value="{{@$class_id}}">
                                    <input type="hidden" name="section_id" id="class_id" value="{{@$section_id}}">
                                    <input type="hidden" name="update" value="1">
                                    @php $i = 4; @endphp
                                    @foreach($assign_subjects as $assign_subject)
                                    <div class="col-lg-12 mb-30" id="assign-subject-{{$i}}">
                                        <div class="row align-items-center">
                                            <div class="col-lg-5 mb-3 mb-lg-0">
                                                <select class="primary_select form-control subject" name="subjects[]">
                                                    <option data-display="@lang('common.select_subjects')" value="">@lang('common.select_subjects')</option>
                                                    @foreach($subjects as $subject)
                                                    <option value="{{$subject->id}}" {{@$assign_subject->subject_id == $subject->id? 'selected': ''}}>{{@$subject->subject_name}}({{@$subject->subject_code}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-5 mb-3 mb-lg-0">
                                                <select class="primary_select form-control" name="teachers[]">
                                                    <option data-display="@lang('common.select_teacher')" value="">@lang('common.select_teacher')</option>
                                                    @foreach($teachers as $teacher)
                                                    <option value="{{@$teacher->id}}" {{@$assign_subject->teacher_id == @$teacher->id? 'selected': ''}}>{{@$teacher->full_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-2 col-12 text-center text-lg-left">
                                                <button class="primary-btn icon-only fix-gr-bg" id="removeSubject" onclick="deleteSubject({{$i}})" type="button">
                                                    <span class="ti-trash" ></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @php $i++; @endphp
                                    @endforeach

                                </div>
                            </div>
                             @if(userPermission('assign-subject-store'))
                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg submit">
                                    <span class="ti-save pr-2"></span>
                                    @lang('academics.save')
                                </button>
                            </div>
                            @endif
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>

@elseif(isset($assign_subjects) && $assign_subjects->count() == 0)
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
        <div class="row mt-40">
            <div class="col-lg-6 col-md-6 col-9">
                <div class="main-title">
                    <h3 class="mb-30">@lang('academics.assign_subject')</h3>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 text-right col-3">
                <button class="primary-btn icon-only fix-gr-bg" id="addNewSubject" type="button">
                    <span class="ti-plus" ></span>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'assign-subject-store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'assign_subject']) }}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="assign-subject" id="assign-subject">
                                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                    <input type="hidden" name="class_id" id="class_id" value="{{@$class_id}}">
                                    <input type="hidden" name="section_id" id="class_id" value="{{@$section_id}}">
                                    <input type="hidden" name="update" value="0">
                                    <div class="col-lg-12 mb-30" id="assign-subject-4">
                                        <div class="row align-items-center">
                                            <div class="col-lg-5 mb-3 mb-lg-0">
                                                <select class="primary_select form-control" name="subjects[]" id="subjects">
                                                    <option data-display="@lang('common.select_subjects')" value="">@lang('common.select_subjects')</option>
                                                    @foreach($subjects as $subject)
                                                    <option value="{{@$subject->id}}">{{@$subject->subject_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-5 mb-3 mb-lg-0">
                                                <select class="primary_select form-control" name="teachers[]">
                                                    <option data-display="@lang('common.select_teacher')" value="">@lang('common.select_teacher')</option>
                                                    @foreach($teachers as $teacher)
                                                    <option value="{{@$teacher->id}}">{{@$teacher->full_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-2 col-12 text-center text-lg-left">
                                                <button class="primary-btn icon-only fix-gr-bg" type="button">
                                                    <span class="ti-trash" id="removeSubject" onclick="deleteSubject(4)"></span>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg submit">
                                    <span class="ti-save pr-2"></span>
                                    @lang('academics.save')
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>


@endif

@endsection
