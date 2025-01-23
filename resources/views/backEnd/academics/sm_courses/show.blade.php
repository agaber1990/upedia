@extends('backEnd.master')
@section('title')
    @lang('academics.courses')
@endsection

{{-- {{dd($students)}} --}}
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('academics.academics')</a>
                    <a href="#">@lang('academics.courses')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="">
                <h3 class="mb-0">
                    @lang('academics.students')</h3>
            </div>
            <div class="">
                <button class="primary-btn small fix-gr-bg"id="assign_student">
                    <span class="ti-plus pr-2"></span>
                    @lang('common.add')
                </button>



            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="assing_modal" tabindex="-1" aria-labelledby="assing_modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="assing_modalLabel">@lang('academics.add_new')</h1>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form action="{{ route('sm_courses_storeCourseToStudent') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $course->id }}" name="course_id">
                        <div class="modal-body">
                            <div class="primary_input">
                                <label class="primary_input_label" for="student_id">
                                    @lang('common.select_student') <span class="text-danger"> *</span>
                                </label>
                                <select class="primary_select form-control" name="student_id" id="student_id">
                                    @foreach ($students as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="primary-btn fix-gr-bg text-nowrap">
                                @lang('common.save_changes')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">

                        <div class="table-responsive">
                            <x-table>
                                <table id="table_id" class="table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('academics.student_name')</th>
                                            <th>@lang('common.action')</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $item)
                                            <tr>
                                                <td>{{ $item->full_name }}</td>
                                                <td>
                                                    <x-drop-down>


                                                        @if (userPermission(''))
                                                            <a class="dropdown-item" href="">
                                                                @lang('common.edit')
                                                            </a>
                                                        @endif

                                                        @if (userPermission(''))
                                                            <a class="dropdown-item" href="">
                                                                @lang('common.delete')
                                                            </a>
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#assign_student').click(function(event) {
                event.preventDefault();
                $('#assing_modal').modal('show');
            });
        });
    </script>
@endpush
@include('backEnd.partials.data_table_js')
