@extends('backEnd.master')
@push('css')
    <style>
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            font-size: 1.5em;
            justify-content: space-around;
            text-align: center;
            width: 5em;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #ccc;
            cursor: pointer;
        }

        .star-rating :checked~label {
            color: #f90;
        }

        article {
            background-color: #ffe;
            box-shadow: 0 0 1em 1px rgba(0, 0, 0, .25);
            color: #006;
            font-family: cursive;
            font-style: italic;
            margin: 4em;
            max-width: 30em;
            padding: 2em;
        }
        .check_box_table .QA_table .table tbody th:nth-child(2){
            padding-left: 20px
        }
    </style>
@endpush
@section('title')
    @lang('hr.teachers_list')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('hr.teachers_list')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('hr.teachers')</a>
                    <a href="#">@lang('hr.teachers_list')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row">
                <div class="col-lg-12 student-details up_admin_visitor">
                    <div class="white-box">
                        <ul class="nav nav-tabs tabs_scroll_nav" role="tablist">

                            @foreach ($records as $key => $record)
                                <li class="nav-item">
                                    <a class="nav-link @if ($key == 0) active @endif "
                                        href="#tab{{ $key }}" role="tab"
                                        data-toggle="tab">{{ $record->class->class_name }}
                                        ({{ $record->section->section_name }})
                                    </a>
                                </li>
                            @endforeach
    
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            @foreach ($records as $key => $record)
                                <div role="tabpanel" class="tab-pane fade mt-60  @if ($key == 0) active show @endif"
                                    id="tab{{ $key }}">
                                    <x-table>
                                        <table id="table_id" class="table" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="15%">@lang('hr.teacher_name')</th>
                                                    <th width="10%">@lang('common.subject')</th>
                                                    @if (generalSetting()->teacher_email_view)
                                                        <th>@lang('common.email')</th>
                                                    @endif
                                                    @if (generalSetting()->teacher_phone_view)
                                                        <th>@lang('common.phone')</th>
                                                    @endif
                                                    @if ($teacherEvaluationSetting->is_enable == 0)
                                                        @if (in_array('2', $teacherEvaluationSetting->submitted_by))
                                                            @if ($teacherEvaluationSetting->rating_submission_time == 'any')
                                                                <th width="15%">@lang('teacherEvaluation.rate')</th>
                                                                <th width="50%">@lang('teacherEvaluation.comment')</th>
                                                                <th width="10%">@lang('common.action')</th>
                                                            @else
                                                                @if (date('m/d/Y') >= date('m/d/Y', strtotime($teacherEvaluationSetting->from_date)) &&
                                                                        date('m/d/Y') <= date('m/d/Y', strtotime($teacherEvaluationSetting->to_date)))
                                                                    <th width="15%">@lang('teacherEvaluation.rate')</th>
                                                                    <th width="50%">@lang('teacherEvaluation.comment')</th>
                                                                    <th width="10%">@lang('common.action')</th>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                </tr>
                                            </thead>
    
                                            <tbody>
                                                @foreach ($record->StudentTeacher as $value)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ file_exists(@$value->teacher->staff_photo) ? asset(@$value->teacher->staff_photo) : asset('/uploads/staff/demo/staff.jpg') }}"
                                                                class="img img-thumbnail" style="width: 60px; height: auto;">
                                                            {{ @$value->teacher != '' ? @$value->teacher->full_name : '' }}
                                                        </td>
                                                        <th>{{ $value->subject->subject_name }}</th>
                                                        @if (generalSetting()->teacher_email_view)
                                                            <td>{{ @$value->teacher != '' ? @$value->teacher->email : '' }}</td>
                                                        @endif
                                                        @if (generalSetting()->teacher_phone_view)
                                                            <td>{{ @$value->teacher != '' ? @$value->teacher->mobile : '' }}
                                                            </td>
                                                        @endif
                                                        @if ($teacherEvaluationSetting->is_enable == 0)
                                                            @if (in_array('2', $teacherEvaluationSetting->submitted_by))
                                                                @if ($teacherEvaluationSetting->rating_submission_time == 'any')
                                                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'teacher-evaluation-submit', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'infix_form']) }}
                                                                        <input type="hidden" name="teacher_id"
                                                                            value="{{ $value->teacher_id }}">
                                                                        <input type="hidden" name="record_id"
                                                                            value="{{ $record->id }}">
                                                                        <input type="hidden" name="student_id"
                                                                            value="{{ $record->studentDetail->id }}">
                                                                        <input type="hidden" name="parent_id"
                                                                            value="{{ $record->studentDetail->parents->id }}">
                                                                        <input type="hidden" name="subject_id"
                                                                            value="{{ $value->subject->id }}">
                                                                        <th>
                                                                            <div class="star-rating">
                                                                                <input type="radio"
                                                                                    id="5-stars{{ $value->id }}"
                                                                                    name="rating" value="5" />
                                                                                <label for="5-stars{{ $value->id }}"
                                                                                    class="star">&#9733;</label>
                                                                                <input type="radio"
                                                                                    id="4-stars{{ $value->id }}"
                                                                                    name="rating" value="4" />
                                                                                <label for="4-stars{{ $value->id }}"
                                                                                    class="star">&#9733;</label>
                                                                                <input type="radio"
                                                                                    id="3-stars{{ $value->id }}"
                                                                                    name="rating" value="3" />
                                                                                <label for="3-stars{{ $value->id }}"
                                                                                    class="star">&#9733;</label>
                                                                                <input type="radio"
                                                                                    id="2-stars{{ $value->id }}"
                                                                                    name="rating" value="2" />
                                                                                <label for="2-stars{{ $value->id }}"
                                                                                    class="star">&#9733;</label>
                                                                                <input type="radio"
                                                                                    id="1-star{{ $value->id }}"
                                                                                    name="rating" value="1" />
                                                                                <label for="1-star{{ $value->id }}"
                                                                                    class="star">&#9733;</label>
                                                                            </div>
                                                                        </th>
                                                                        <th>
                                                                            <div class="primary_input">
                                                                                <input
                                                                                    class="primary_input_field read-only-input form-control"
                                                                                    type="text" name="comment">
                                                                            </div>
                                                                        </th>
                                                                        <th>
                                                                            <button type="submit"
                                                                                class="primary-btn small fix-gr-bg">@lang('common.save')</button>
                                                                        </th>
                                                                    {{ Form::close() }}
                                                                @else
                                                                    @if (date('m/d/Y') >= date('m/d/Y', strtotime($teacherEvaluationSetting->from_date)) &&
                                                                        date('m/d/Y') <= date('m/d/Y', strtotime($teacherEvaluationSetting->to_date)))
                                                                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'teacher-evaluation-submit', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'infix_form']) }}
                                                                        <input type="hidden" name="teacher_id"
                                                                            value="{{ $value->teacher_id }}">
                                                                        <input type="hidden" name="record_id"
                                                                            value="{{ $record->id }}">
                                                                        <input type="hidden" name="student_id"
                                                                            value="{{ $record->studentDetail->id }}">
                                                                        <input type="hidden" name="parent_id"
                                                                            value="{{ $record->studentDetail->parents->id }}">
                                                                        <input type="hidden" name="subject_id"
                                                                            value="{{ $value->subject->id }}">
                                                                        <th>
                                                                            <div class="star-rating">
                                                                                <input type="radio"
                                                                                    id="5-stars{{ $value->id }}"
                                                                                    name="rating" value="5" />
                                                                                <label for="5-stars{{ $value->id }}"
                                                                                    class="star">&#9733;</label>
                                                                                <input type="radio"
                                                                                    id="4-stars{{ $value->id }}"
                                                                                    name="rating" value="4" />
                                                                                <label for="4-stars{{ $value->id }}"
                                                                                    class="star">&#9733;</label>
                                                                                <input type="radio"
                                                                                    id="3-stars{{ $value->id }}"
                                                                                    name="rating" value="3" />
                                                                                <label for="3-stars{{ $value->id }}"
                                                                                    class="star">&#9733;</label>
                                                                                <input type="radio"
                                                                                    id="2-stars{{ $value->id }}"
                                                                                    name="rating" value="2" />
                                                                                <label for="2-stars{{ $value->id }}"
                                                                                    class="star">&#9733;</label>
                                                                                <input type="radio"
                                                                                    id="1-star{{ $value->id }}"
                                                                                    name="rating" value="1" />
                                                                                <label for="1-star{{ $value->id }}"
                                                                                    class="star">&#9733;</label>
                                                                            </div>
                                                                        </th>
                                                                        <th>
                                                                            <div class="primary_input">
                                                                                <input
                                                                                    class="primary_input_field read-only-input form-control"
                                                                                    type="text" name="comment">
                                                                            </div>
                                                                        </th>
                                                                        <th>
                                                                            <button type="submit"
                                                                                class="primary-btn small fix-gr-bg">@lang('common.save')</button>
                                                                        </th>
                                                                        {{ Form::close() }}
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </x-table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@include('backEnd.partials.data_table_js')
