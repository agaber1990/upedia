@if (isset($menus) && count($menus) > 0)
    <div class="input-session mb-4">
        {{-- {{dd($lessons)}} --}}
        <div id="accordion" class="dd">
            <ol class="dd-list">
                @foreach ($menus as $key => $element)
                    <li class="dd-item" data-id="{{ $element->id }}">
                        <div class="card accordion_card" id="accordion_{{ $element->id }}">
                            <div class=" item_header" id="heading_{{ $element->id }}">
                                <div class="dd-handle">
                                    <div class="pull-left">
                                        {{ $element->name_en }}
                                    </div>
                                </div>
                                <div class="pull-right btn_div">
                                    @if (userPermission('element-update'))
                                        <a href="javascript:void(0);"
                                            onclick="updateSession({{ $element->id }},'{{ addslashes($element->name_en) }}','{{ addslashes($element->name_ar) }}','{{ addslashes($element->description_en) }}','{{ addslashes($element->description_ar) }}','{{ $element->level_id }}','{{ $element->track_id }}',{{ json_encode($element->file) }})"
                                            class="primary-btn btn_zindex panel-title">
                                            @lang('common.edit')
                                            <i class="ti-pencil-alt"></i>
                                        </a>
                                    @endif
                                    @if (userPermission('element-update'))
                                        <a href="javascript:void(0);" onclick="" data-toggle="collapse"
                                            data-target="#collapse_{{ $element->id }}" aria-expanded="false"
                                            aria-controls="collapse_{{ $element->id }}"
                                            class="primary-btn btn_zindex panel-title">
                                            @lang('common.show')
                                            <i class="ti-angle-down"></i>
                                        </a>
                                    @endif
                                    @if (env('APP_SYNC') == true)
                                        <a href="javascript:void(0);" class="primary-btn btn_zindex mb-3"
                                            title="Disable For Demo" data-toggle="tooltip">
                                            <i class="ti-close"></i>
                                        </a>
                                    @else
                                        @if (userPermission('delete-element'))
                                            <a href="javascript:void(0);" onclick="elementDelete({{ $element->id }})"
                                                class="primary-btn btn_zindex mb-3">
                                                <i class="ti-close"></i>
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div id="collapse_{{ $element->id }}" class="collapse"
                                aria-labelledby="heading_{{ $element->id }}"
                                data-parent="#accordion_{{ $element->id }}">
                                <div class="card-body">

                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="btnSelect">
                                                <button id="add_btn_session_{{ $element->id }}"
                                                    class="circular-btn mx-2" aria-label="Toggle new session form">
                                                    <i class="fas fa-plus" style="color: #fff"></i>
                                                </button>
                                            </div>

                                            <div id="add_session_session_{{ $element->id }}" class="input-session"
                                                style="display: none;width:100%">
                                                <button id="add_lesson_modal_btn_{{ $element->id }}"
                                                    class="session-btn m-2"
                                                    data-modal-target="#add_lesson_modal_{{ $element->id }}">
                                                    <i class="fas fa-plus" style="color: #000000"></i> @lang('academics.add_lesson')
                                                </button>
                                                <button id="add_quiz_modal_btn_{{ $element->id }}"
                                                    class="session-btn m-2"
                                                    data-modal-target="#add_quiz_modal_{{ $element->id }}">
                                                    <i class="fas fa-plus" style="color: #000000"></i> @lang('academics.add_quiz')
                                                </button>
                                                <button id="add_assignment_modal_btn_{{ $element->id }}"
                                                    class="session-btn m-2"
                                                    data-modal-target="#add_assignment_modal_{{ $element->id }}">
                                                    <i class="fas fa-plus" style="color: #000000"></i> @lang('academics.add_assignment')
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col">
                                                    <h4>@lang('academics.track'):</h4>
                                                    <p class="text-dark">
                                                        {{ $element->track->track_name_en }}
                                                    </p>
                                                </div>
                                                <div class="col">
                                                    <h4>@lang('common.level'):</h4>
                                                    <p class="text-dark">
                                                        {{ $element->level->name_en }}</p>
                                                </div>
                                                <div class="col">
                                                    <h4>@lang('academics.name_en'):</h4>
                                                    <p class="text-dark">
                                                        {{ $element->name_en }}</p>
                                                </div>
                                                <div class="col">
                                                    <h4>@lang('academics.name_ar'):</h4>
                                                    <p class="text-dark">
                                                        {{ $element->name_ar }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">

                                            @foreach ($lessons->where('session_id', $element->id) as $item)
                                                <div class="row align-items-center mt-4">
                                                    <div class="col-md-10 col-9">
                                                        <h4>
                                                            {{ $item->name }} [{{ $item->duration }}]
                                                            [{{ $item->privacy }}] [lesson]

                                                        </h4>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <x-drop-down>
                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#update_lesson_modal_{{ $item->id }}"
                                                                href="#">@lang('common.edit')</a>
                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#deleteAssignmentModal{{ $item->id }}"
                                                                href="#">@lang('common.delete')</a>
                                                        </x-drop-down>
                                                    </div>

                                                    <!-- Update Lesson Modal -->
                                                    @include('backEnd.academics.sessions.modals.update_lesson_modal')

                                                    {{-- delete modal --}}
                                                    <div class="modal fade admin-query"
                                                        id="deleteAssignmentModal{{ $item->id }}">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">@lang('academics.delete_lesson')</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="text-center">
                                                                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                                    </div>
                                                                    <div class="mt-40 d-flex justify-content-between">
                                                                        <button type="button"
                                                                            class="primary-btn tr-bg"
                                                                            data-dismiss="modal">@lang('common.cancel')</button>
                                                                        {{ Form::open(['route' => ['track_levels_sessions_lessons_delete', $item->id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                                        <button class="primary-btn fix-gr-bg"
                                                                            type="submit">@lang('common.delete')</button>
                                                                        {{ Form::close() }}
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach


                                            @foreach ($assignments->where('session_id', $element->id) as $item)
                                                <div class="row align-items-center mt-4">
                                                    <div class="col-md-10 col-9">
                                                        <h4>
                                                            {{ $item->title }} [{{ $item->privacy }}] [Assignment]
                                                        </h4>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <x-drop-down>
                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#update_assignment_modal_{{ $item->id }}"
                                                                href="#">@lang('common.edit')</a>
                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#deleteAssignmentModal{{ $item->id }}"
                                                                href="#">@lang('common.delete')</a>
                                                        </x-drop-down>
                                                    </div>

                                                    <!-- Update assignment Modal -->
                                                    @include('backEnd.academics.sessions.modals.update_assignment_modal')

                                                    {{-- delete assignment modal --}}
                                                    <div class="modal fade admin-query"
                                                        id="deleteAssignmentModal{{ $item->id }}">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">@lang('academics.delete_assignment')</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="text-center">
                                                                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                                    </div>
                                                                    <div class="mt-40 d-flex justify-content-between">
                                                                        <button type="button"
                                                                            class="primary-btn tr-bg"
                                                                            data-dismiss="modal">@lang('common.cancel')</button>
                                                                        {{ Form::open(['route' => ['track_levels_sessions_assignment_delete', $item->id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                                        <button class="primary-btn fix-gr-bg"
                                                                            type="submit">@lang('common.delete')</button>
                                                                        {{ Form::close() }}
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            @foreach ($quiz->where('session_id', $element->id) as $item)
                                                <div class="row align-items-center mt-4">
                                                    <div class="col-md-10 col-9">
                                                        <h4>
                                                            {{ $item->title }} [{{ $item->privacy }}] [Quiz]
                                                        </h4>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <x-drop-down>
                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#update_quiz_modal_{{ $item->id }}"
                                                                href="#">@lang('common.edit')</a>
                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#deleteQuizModal{{ $item->id }}"
                                                                href="#">@lang('common.delete')</a>
                                                        </x-drop-down>
                                                    </div>


                                                    <!-- Update quiz Modal -->
                                                    @include('backEnd.academics.sessions.modals.update_quiz_modal')

                                                    {{-- delete quiz modal --}}
                                                    <div class="modal fade admin-query"
                                                        id="deleteQuizModal{{ $item->id }}">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">@lang('academics.delete_quiz')</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="text-center">
                                                                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                                    </div>
                                                                    <div class="mt-40 d-flex justify-content-between">
                                                                        <button type="button"
                                                                            class="primary-btn tr-bg"
                                                                            data-dismiss="modal">@lang('common.cancel')</button>
                                                                        {{ Form::open(['route' => ['track_levels_sessions_quiz_delete', $item->id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                                        <button class="primary-btn fix-gr-bg"
                                                                            type="submit">@lang('common.delete')</button>
                                                                        {{ Form::close() }}
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>




                    <!-- Add Lesson Modal -->
                    @include('backEnd.academics.sessions.modals.add_lesson_modal')

                    <!-- Add Quiz Modal -->
                    @include('backEnd.academics.sessions.modals.add_quiz_modal')

                    <!-- Add Assignment Modal -->
                    @include('backEnd.academics.sessions.modals.add_assignment_modal')
                @endforeach
            </ol>
        </div>
    </div>
@else
    <div>
        <div class="text-center">
            <h4>
                @lang('common.no_sessions')
            </h4>
        </div>

    </div>
@endif













<style>
    .item_header {
        background: #415094;

    }

    .item_header .pull-left {
        color: #fff;
    }

    .item_header .primary-btn {
        color: #fff;

    }

    .item_header .collapge_arrow_normal {
        color: #fff;

    }
</style>
@push('script')
    <script>
        $(document).ready(function() {



            $(document).on('click', '[id^="add_btn_session_"]', function(event) {
                event.preventDefault();
                event.stopPropagation();

                var elementId = $(this).attr('id').split('_')[
                    3];

                $('#add_session_session_' + elementId).toggle();
                if ($('#add_session_session_' + elementId).is(':visible')) {
                    $(this).html('<i class="fas fa-times" style="color: #fff"></i>');
                } else {
                    $(this).html('<i class="fas fa-plus" style="color: #fff"></i>');
                }
            });





            $(document).on('click',
                '[id^="add_lesson_modal_btn_"], [id^="add_quiz_modal_btn_"], [id^="add_assignment_modal_btn_"]',
                function(event) {
                    event.preventDefault();
                    var modalTarget = $(this).data('modal-target');
                    $(modalTarget).modal('show');
                });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('[id^="add_session_session_"]').length && !$(event.target)
                    .closest('[id^="add_btn_session_"]').length) {
                    $('[id^="add_session_session_"]').hide();
                    $('[id^="add_btn_session_"]').html('<i class="fas fa-plus" style="color: #fff"></i>');
                }
            });

        });



        function updateSession(id, name_en, name_ar, description_en, description_ar, level_id, track_id, files) {
            $('#update_session_id').val(id);
            $('#update_name_en').val(name_en);
            $('#update_name_ar').val(name_ar);
            $('#update_description_en').val(description_en);
            $('#update_description_ar').val(description_ar);
            $('#update_level_id').val(level_id);
            $('#update_track_id').val(track_id);

            $('#existing_files').empty();
            if (typeof files === 'string') {
                try {
                    files = JSON.parse(files);
                } catch (error) {
                    console.error('Error parsing files:', error);
                    files = [];
                }
            }

            if (files && files.length > 0) {
                files.forEach((file, index) => {
                    $('#existing_files').append(`
                <div class="file-item">
                <a target="_blank" href="/${file}"><i class="fa fa-eye"></i> @lang('common.view_material') ${index +1}</a>             
                </div>
            `);
                });
            }
            $('#ModalUpdateSession').modal('show');
        }
    </script>
@endpush
