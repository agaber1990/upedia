@if (isset($menus) && count($menus) > 0)
    <div class="input-session mb-4">


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

                                                <button id="add_btn_session" class="circular-btn mx-2"
                                                    aria-label="Toggle new session form">
                                                    <i class="fas fa-plus" style="color: #fff"></i>
                                                </button>
                                            </div>
                                            <div id="add_session_session" class="input-session"
                                                style="display: none;width:100%">
                                                <button id="add_lesson_modal_btn" class="session-btn">
                                                    <i class="fas fa-plus" style="color: #000000"></i> @lang('academics.add_lesson')
                                                </button>

                                                <ul class="nav nav-tabs tabs_scroll_nav px-0" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active"
                                                            href="#session_info_{{ $element->id }}" role="tab"
                                                            data-toggle="tab">@lang('common.session_info')</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#quiz_{{ $element->id }}"
                                                            role="tab" data-toggle="tab">@lang('common.quiz')</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#lesson_{{ $element->id }}"
                                                            role="tab" data-toggle="tab">@lang('common.lesson')</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#assignment_{{ $element->id }}"
                                                            role="tab" data-toggle="tab">@lang('common.assignment')</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#extra_{{ $element->id }}"
                                                            role="tab" data-toggle="tab">@lang('common.extra')</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>







                                    <div class="row">
                                        <div class="col-lg-12 form_tab">



                                            <div class="col-lg-12">
                                                <div class="form-tab-container">
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane fade show active"
                                                            id="session_info_{{ $element->id }}">
                                                            <div class="row pt-4 row-gap-24">
                                                                <div class="col-lg-12 p-0">
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
                                                            </div>
                                                        </div>

                                                        <div role="tabpanel" class="tab-pane fade"
                                                            id="quiz_{{ $element->id }}">
                                                            <div class="row pt-4 row-gap-24">
                                                                <div class="col-lg-12 p-0">Quiz</div>
                                                            </div>
                                                        </div>

                                                        <div role="tabpanel" class="tab-pane fade"
                                                            id="lesson_{{ $element->id }}">
                                                            <div class="row pt-4 row-gap-24">
                                                                <div class="col-lg-12 p-0">Lesson</div>
                                                            </div>
                                                        </div>

                                                        <div role="tabpanel" class="tab-pane fade"
                                                            id="assignment_{{ $element->id }}">
                                                            <div class="row pt-4 row-gap-24">
                                                                <div class="col-lg-12 p-0">Assignment</div>
                                                            </div>
                                                        </div>

                                                        <div role="tabpanel" class="tab-pane fade"
                                                            id="extra_{{ $element->id }}">
                                                            <div class="row pt-4 row-gap-24">
                                                                <div class="col-lg-12 p-0">Extra</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>



    <!-- Add Lesson Modal -->
    <div class="modal fade" id="add_lesson_modal" tabindex="-1" aria-labelledby="add_lesson_modal_label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf


                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="add_lesson_modal_label">@lang('academics.add_lesson')</h1>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" id="track_id" name="track_id" value="{{ $track->id }}">
                        <input type="hidden" id="level_id" name="level_id" value="{{ $level->id }}">


                        <div class="primary_input">
                            <label class="primary_input_label" for="name">@lang('academics.lesson_name')
                                <span class="text-danger"> *</span>
                            </label>
                            <input class="primary_input_field form-control" type="text" name="name"
                                id="name" autocomplete="off">
                        </div>
                        <div class="primary_input">
                            <label class="primary_input_label" for="duration">@lang('academics.duration_in_minute')
                                <span class="text-danger"> *</span>
                            </label>
                            <input class="primary_input_field form-control" type="text" name="duration"
                                id="duration" autocomplete="off">
                        </div>


                        <div class="primary_input">
                            <label class="primary_input_label" for="">@lang('academics.host')
                            </label>
                            <select class="primary_select form-control" name="host" id="host">
                                <option value="">@lang('common.select')</option>
                                <option value="youtube">@lang('common.youtube')</option>
                                <option value="pdf">@lang('common.pdf')</option>
                                <option value="image">@lang('common.image')</option>
                                {{-- @foreach ($departments as $key => $value)
                                    <option value="{{ $value->id }}"
                                        {{ old('department_id') == $value->id ? 'selected' : '' }}>
                                        {{ $value->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>

                        <div class="primary_input" id="hostValue">
                        </div>

                        <div class="primary_input">
                            <label class="primary_input_label" for="">@lang('academics.privacy')
                            </label>
                            <select class="primary_select form-control" name="privacy" id="privacy">
                                <option value="">@lang('common.select')</option>

                            </select>
                        </div>

                        <div class="primary_input">
                            <label class="primary_input_label" for="description">@lang('academics.description')
                                <span class="text-danger"> *</span>
                            </label>
                            <textarea name="" class="primary_input_field form-control" name="description" id="description"
                                rows="5">
                                </textarea>
                        </div>





                        <div class="primary_input">
                            <label class="primary_input_label" for="file">@lang('common.material')
                                <span class="text-danger"> *</span>
                            </label>
                            <input class="primary_input_field form-control" id="file" type="file" multiple
                                id="file" name="file[]" autocomplete="off">
                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="submit" id="add_for_submit" class="primary-btn fix-gr-bg text-nowrap">
                            @lang('common.submit')
                        </button>
                    </div>
                </div>
            </form>
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

            function updateInputField() {
                const selectedValue = $('#host').val();
                let inputHtml = '';

                if (selectedValue === 'youtube') {
                    inputHtml =
                        `
                         <label class="primary_input_label" for="">@lang('common.url')
                            </label>
                        <input class="primary_input_field form-control " type="text" name="youtube_url" placeholder="Enter YouTube URL" autocomplete="off">
                        
                        `;
                } else if (selectedValue === 'image' || selectedValue === 'pdf') {
                    inputHtml =
                        `
  <label class="primary_input_label" for="">@lang('common.file')
                            </label>
                        <input class="primary_input_field form-control" type="file" name="file" accept="${selectedValue === 'image' ? 'image/*' : 'application/pdf'}">
                        
                        `;
                }

                $('#hostValue').html(inputHtml);
            }

            updateInputField();
            $('#host').on('change', updateInputField);


            $('#add_btn_session').click(function(event) {
                event.preventDefault();
                event.stopPropagation();
                $('#add_session_session').toggle();
                if ($('#add_session_session').is(':visible')) {
                    $(this).html('<i class="fas fa-times" style="color: #fff"></i>');
                } else {
                    $(this).html('<i class="fas fa-plus" style="color: #fff"></i>');
                }
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('#add_session_session').length && !$(event.target).closest(
                        '#add_btn_session').length) {
                    $('#add_session_session').hide();
                    $('#add_btn_session').html('<i class="fas fa-plus" style="color: #fff"></i>');
                }
            });

            $('#add_lesson_modal_btn').click(function(event) {
                event.preventDefault();
                $('#add_lesson_modal').modal('show');
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
