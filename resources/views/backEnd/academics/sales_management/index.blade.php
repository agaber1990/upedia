@extends('backEnd.master')
@section('title')
    @lang('academics.sales_management')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('academics.sales_management')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('academics.academics')</a>
                    <a href="#">@lang('academics.sales_management')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="main-title">
                            <h3 class="mb-15">@lang('academics.sales_management')</h3>
                        </div>
                        <div class="table-responsive">
                            <x-table>
                                <table id="table_id" class="table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('academics.staff_name')</th>
                                            <th>@lang('academics.category')</th>
                                            <th>@lang('academics.time_slot')</th>
                                            <th>@lang('academics.status')</th>
                                            <th>@lang('academics.session')</th>
                                            <th>@lang('academics.schedule')</th>
                                            <th>@lang('academics.start_date')</th>
                                            <th>@lang('academics.end_date')</th>
                                            <th>@lang('academics.track_type')</th>
                                            <th>@lang('academics.track')</th>
                                            <th>@lang('common.action')</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($staffScheduleds as $scheduled)
                                            <tr>
                                                <td>{{ $staff->firstWhere('id', $scheduled->staff_id)->full_name }}</td>
                                                <td>{{ $scheduled->category->name_en }}</td>
                                                <td>
                                                    @foreach (json_decode($scheduled->slot_id) as $slotId)
                                                        @php
                                                            $slot = $slotTime->firstWhere('id', $slotId);
                                                        @endphp
                                                        @if ($slot)
                                                            {{ $slot->slot_day }}:
                                                            {{ date('h:i A', strtotime($slot->slot_start)) }} -
                                                            {{ date('h:i A', strtotime($slot->slot_end)) }}<br>
                                                        @else
                                                            Invalid Slot ID: {{ $slotId }}<br>
                                                        @endif
                                                    @endforeach

                                                </td>

                                                <td>{{ $scheduled->status }}</td>
                                                <td>{{ $scheduled->session }}</td>
                                                <td>{{ $scheduled->schedule }}</td>
                                                <td>{{ $scheduled->start_date }}</td>
                                                <td>{{ $scheduled->end_date }}</td>
                                                <td>{{ $scheduled->trackType->name }}</td>
                                                <td>{{ $scheduled->track->track_name_en }}</td>

                                                <td>
                                                    <x-drop-down>
                                                        @if (userPermission('view_calendar'))
                                                            <a class="dropdown-item" href="#">@lang('common.view_calendar')</a>
                                                        @endif

                                                        @if (userPermission('discount_plans-edit'))
                                                            <a class="dropdown-item"
                                                                href="{{ route('discount_plans-edit', ['$staffScheduleds->id']) }}">@lang('common.edit')</a>
                                                        @endif

                                                        @if (userPermission('discount_plans-delete'))
                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#deletediscount_planModal{{ '$staffScheduleds->id' }}"
                                                                href="#">@lang('common.delete')</a>
                                                        @endif

                                                        @if (userPermission('assigned_students'))
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                id="student_modal_btn_{{ $scheduled->id }}"
                                                                data-bs-target="#assignedStudents_{{ $scheduled->id }}">
                                                                @lang('common.assigned_students')
                                                            </a>
                                                        @endif

                                                    </x-drop-down>
                                                </td>
                                            </tr>





                                            <!-- Modal for Assigned Students -->
                                            <div class="modal fade" id="assignedStudents_{{ $scheduled->id }}"
                                                tabindex="-1" aria-labelledby="assignedStudentsLabel_{{ $scheduled->id }}"
                                                aria-hidden="true">
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
                                                                    @lang('common.select_student') <span class="text-danger"> *</span>
                                                                </label>
                                                                <select class="primary_select form-control"
                                                                    name="studentDropdown"
                                                                    id="studentDropdown_{{ $scheduled->id }}">
                                                                    @foreach ($students as $student)
                                                                        <option value="{{ $student->id }}">
                                                                            {{ $student->full_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" id="scheduleId" name="schedule_id"
                                                                    value="{{ $scheduled->id }}">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="closeStudentModal primary-btn tr-bg"
                                                                data-bs-dismiss="modal">@lang('common.close')</button>
                                                            <button type="button"
                                                                id="saveAssignedStudents_{{ $scheduled->id }}"
                                                                class="primary-btn fix-gr-bg text-nowrap">
                                                                @lang('common.save_changes')
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>





                                            <div class="modal fade admin-query"
                                                id="deletediscount_planModal{{ '$staffScheduleds->id' }}">
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
                                                                {{ Form::open(['route' => ['discount_plans-delete', '$staffScheduleds->id'], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
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
    </script>
@endpush
