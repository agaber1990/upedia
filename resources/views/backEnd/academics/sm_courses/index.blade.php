@extends('backEnd.master')
@section('title')
    @lang('academics.courses')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('academics.courses')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('academics.academics')</a>
                    <a href="#">@lang('academics.courses')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">

                        <div class="table-responsive">
                            <x-table>
                                <table id="table_id" class="table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('academics.course_name_en')</th>
                                            <th>@lang('academics.start_date')</th>
                                            <th>@lang('academics.end_date')</th>

                                            <th>@lang('common.action')</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($staffScheduleds as $scheduled)
                                            {{-- {{ dd($staffScheduleds) }} --}}
                                            <tr>
                                                <td>{{ $scheduled->course_name_en }}</td>
                                                <td>{{ $scheduled->start_date }}</td>
                                                <td>{{ $scheduled->end_date }}</td>
                                                <td>
                                                    <x-drop-down>
                                                        @if (userPermission('view_calendar'))
                                                            <a class="dropdown-item" href="#">@lang('common.view_calendar')</a>
                                                        @endif
                                                        @if (userPermission('assigned_students'))
                                                            <a class="dropdown-item"
                                                                onclick="openModalAssigns({{ $scheduled->id }})">
                                                                @lang('common.request_invoice')
                                                            </a>
                                                        @endif
                                                        @if (userPermission('assigned_students'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('sm_courses_show', $scheduled->id) }}">
                                                                @lang('common.edit')
                                                            </a>
                                                        @endif

                                                    </x-drop-down>
                                                </td>
                                            </tr>

                                            <!-- Modal for Assigned Students -->
                                            <div class="modal fade" id="assign_student_modal_{{ $scheduled->id }}"
                                                tabindex="-1" aria-labelledby="assignedStudentsLabel_{{ $scheduled->id }}"
                                                aria-hidden="true">
                                                <form action="{{ route('sm_courses_store') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="assignedStudentsLabel_{{ $scheduled->id }}">
                                                                    @lang('common.assigned_students')
                                                                </h1>
                                                                <button type="button" class="close closeStudentModal"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="primary_input">
                                                                    <label class="primary_input_label"
                                                                        for="studentDropdown_{{ $scheduled->id }}">
                                                                        @lang('common.select_student') <span
                                                                            class="text-danger">*</span>
                                                                    </label>
                                                                    <select class="primary_select form-control"
                                                                        name="student_id"
                                                                        id="studentDropdown_{{ $scheduled->id }}">
                                                                        @foreach ($students as $student)
                                                                            <option value="{{ $student->id }}">
                                                                                {{ $student->full_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <input type="hidden" id="scheduleId"
                                                                    name="staff_scheduleds_id"
                                                                    value="{{ $scheduled->id }}">
                                                                <input type="hidden" id="levelId" name="levels_id"
                                                                    value="{{ $scheduled->track->level_number }}">
                                                            </div>
                                                            <div class="modal-footer"
                                                                id="modal_footer_{{ $scheduled->id }}">
                                                                <button type="submit"
                                                                    class="primary-btn fix-gr-bg text-nowrap">
                                                                    @lang('common.request_invoice')
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
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
    </section>
@endsection
@include('backEnd.partials.data_table_js')

@push('script')
    <script>
        $(document).ready(function() {
            $('[id^="student_modal_btn_"]').click(function(event) {
                event.preventDefault();
                const targetModal = $(this).data('bs-target');
                $(targetModal).modal('show');
            });

            $('.closeStudentModal').click(function(event) {
                event.preventDefault();
                $(this).closest('.modal').modal('hide');
            });
        });


        function openModalAssigns(id) {
            $('#assign_student_modal_' + id).modal('show');

        }
    </script>
@endpush
