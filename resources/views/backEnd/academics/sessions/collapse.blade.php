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

                                            <div class="row align-items-center mt-4">
                                                <div class="col-md-10 col-9">
                                                    <h4>Static text [50min][unlock][lesson]</h4>
                                                </div>
                                                <div class="col-md-2">
                                                    <x-drop-down>
                                                        <a class="dropdown-item" href="">@lang('common.levels')</a>
                                                        <a class="dropdown-item" href="">@lang('common.pricing_plan')</a>
                                                        <a class="dropdown-item" href="">@lang('common.edit')</a>
                                                        <a class="dropdown-item" data-toggle="modal"
                                                            href="#">@lang('common.delete')</a>
                                                    </x-drop-down>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </li>



                     <!-- Add Lesson Modal -->
    <div class="modal fade" id="add_lesson_modal_{{ $element->id }}" tabindex="-1" aria-labelledby="add_lesson_modal_label"
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
                                <option value="">@lang('common.locked')</option>
                                <option value="">@lang('common.unlock')</option>

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
    <!-- Add Quiz Modal -->
    <div class="modal fade" id="add_quiz_modal_{{ $element->id }}" tabindex="-1" aria-labelledby="add_quiz_modal_label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="add_quiz_modal_label">@lang('academics.add_quiz')</h1>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div id="choose_quiz_type">
                            <div class="row">
                                <div class="col-lg-12 radio-btn-flex">
                                    <div class="row">
                                        <div class="col-lg-5 primary_input sm_mb_20">
                                            <input type="radio" name="quiz_option" id="exist_quiz"
                                                class="common-radio" value="1">
                                            <label for="exist_quiz">@lang('common.existing')</label>
                                        </div>
                                        <div class="col-lg-7 primary_input sm_mb_20">
                                            <input type="radio" name="quiz_option" id="new_quiz"
                                                class="common-radio" value="0">
                                            <label for="new_quiz">@lang('common.new')</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="additional_inputs"></div>
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
    <!-- Add Assignment Modal -->
    <div class="modal fade" id="add_assignment_modal_{{ $element->id }}" tabindex="-1" aria-labelledby="add_assignment_modal_label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="add_assignment_modal_label">@lang('academics.add_assignment')</h1>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="primary_input">
                            <label class="primary_input_label" for="name">@lang('academics.title')
                                <span class="text-danger"> *</span>
                            </label>
                            <input class="primary_input_field form-control" type="text" name="title"
                                id="title" autocomplete="off">
                        </div>
                        <div class="row">
                            <div class="col primary_input">
                                <label class="primary_input_label" for="name">@lang('academics.marks')
                                    <span class="text-danger"> *</span>
                                </label>
                                <input class="primary_input_field form-control" type="text" name="marks"
                                    id="marks" autocomplete="off">
                            </div>
                            <div class="col primary_input">
                                <label class="primary_input_label" for="name">@lang('academics.min_percentage')
                                    <span class="text-danger"> *</span>
                                </label>
                                <input class="primary_input_field form-control" type="text" name="min_percentage"
                                    id="min_percentage" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col primary_input">
                                <label class="primary_input_label" for="name">@lang('academics.attachment')
                                    <span class="text-danger"> *</span>
                                </label>
                                <input class="primary_input_field form-control" id="attachment" type="file"
                                    id="attachment" name="attachment" autocomplete="off">
                            </div>
                            <div class="col primary_input">
                                <label class="primary_input_label" for="name">@lang('academics.submit_date')
                                    <span class="text-danger"> *</span>
                                </label>
                                <input class="primary_input_field form-control" type="date" name="submit_date"
                                    id="submit_date" autocomplete="off">
                            </div>
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
                            <label class="primary_input_label" for="">@lang('academics.privacy')
                            </label>
                            <select class="primary_select form-control" name="privacy" id="privacy">
                                <option value="">@lang('common.select')</option>
                                <option value="">@lang('common.locked')</option>
                                <option value="">@lang('common.unlock')</option>

                            </select>
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

            $(document).ready(function() {
                // Function to handle the display of fields based on the selected radio button
                function handleQuizOption() {
                    if ($('#exist_quiz').prop('checked')) {
                        $('#additional_inputs').html(`
                <div class="primary_input">
                    <label class="primary_input_label" for="">@lang('academics.quiz')</label>
                    <select class="primary_select form-control" name="quiz" id="quiz">
                        <option value="">@lang('common.select')</option>
                        <option value="">static quiz 1</option>
                        <option value="">static quiz 2</option>
                        <option value="">static quiz 3</option>
                    </select>
                </div>
                <div class="primary_input">
                    <label class="primary_input_label" for="">@lang('academics.privacy')</label>
                    <select class="primary_select form-control" name="privacy" id="privacy">
                        <option value="">@lang('common.select')</option>
                        <option value="">@lang('common.locked')</option>
                        <option value="">@lang('common.unlock')</option>
                    </select>
                </div>
            `);
                    } else if ($('#new_quiz').prop('checked')) {
                        $('#additional_inputs').html(`
                <div class="primary_input">
                    <label class="primary_input_label" for="name">@lang('academics.title')
                        <span class="text-danger"> *</span>
                    </label>
                    <input class="primary_input_field form-control" type="text" name="title" id="title" autocomplete="off">
                </div>
                <div class="primary_input">
                    <label class="primary_input_label" for="name">@lang('academics.instruction')
                        <span class="text-danger"> *</span>
                    </label>
                    <input class="primary_input_field form-control" type="text" name="instruction" id="instruction" autocomplete="off">
                </div>
                <div class="primary_input">
                    <label class="primary_input_label" for="name">@lang('academics.min_percentage')
                        <span class="text-danger"> *</span>
                    </label>
                    <input class="primary_input_field form-control" type="text" name="min_percentage" id="min_percentage" autocomplete="off">
                </div>
                <div class="primary_input">
                    <label class="primary_input_label" for="">@lang('academics.privacy')</label>
                    <select class="primary_select form-control" name="privacy" id="privacy">
                        <option value="">@lang('common.select')</option>
                        <option value="">@lang('common.locked')</option>
                        <option value="">@lang('common.unlock')</option>
                    </select>
                </div>
            `);
                    }
                }

                // Call the function on page load
                handleQuizOption();

                // Event listener for when the "Existing" quiz option is selected
                $('#exist_quiz').change(function() {
                    handleQuizOption();
                });

                // Event listener for when the "New" quiz option is selected
                $('#new_quiz').change(function() {
                    handleQuizOption();
                });
            });




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


            $(document).on('click', '[id^="add_btn_session_"]', function(event) {
                event.preventDefault();
                event.stopPropagation();

                // Get the unique session ID from the button's ID
                var elementId = $(this).attr('id').split('_')[
                    3]; // Get the ID part after 'add_btn_session_'

                // Toggle the session form for this specific element
                $('#add_session_session_' + elementId).toggle();

                // Change the button icon based on visibility
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

                    // Get the target modal from the data attribute
                    var modalTarget = $(this).data('modal-target');

                    // Show the modal associated with the button
                    $(modalTarget).modal('show');
                });

            $(document).on('click', function(event) {
                // Check if the clicked target is outside the button and session form
                if (!$(event.target).closest('[id^="add_session_session_"]').length && !$(event.target)
                    .closest('[id^="add_btn_session_"]').length) {
                    // Hide all session forms and reset the button icons
                    $('[id^="add_session_session_"]').hide();
                    $('[id^="add_btn_session_"]').html('<i class="fas fa-plus" style="color: #fff"></i>');
                }
            });




            // $(document).on('click', '[id^="add_btn_session_"]', function(event) {
            //     event.preventDefault();
            //     event.stopPropagation();

            //     // Get the unique session ID from the button's ID
            //     var elementId = $(this).attr('id').split('_')[
            //         3]; // Get the ID part after 'add_btn_session_'

            //     // Toggle the session form for this specific element
            //     $('#add_session_session_' + elementId).toggle();

            //     // Change the button icon based on visibility
            //     if ($('#add_session_session_' + elementId).is(':visible')) {
            //         $(this).html('<i class="fas fa-times" style="color: #fff"></i>');
            //     } else {
            //         $(this).html('<i class="fas fa-plus" style="color: #fff"></i>');
            //     }
            // });

            // $(document).on('click', function(event) {
            //     // Check if the clicked target is outside the button and session form
            //     if (!$(event.target).closest('[id^="add_session_session_"]').length && !$(event.target)
            //         .closest('[id^="add_btn_session_"]').length) {
            //         // Hide all session forms and reset the button icons
            //         $('[id^="add_session_session_"]').hide();
            //         $('[id^="add_btn_session_"]').html('<i class="fas fa-plus" style="color: #fff"></i>');
            //     }
            // });




            // $('#add_lesson_modal_btn').click(function(event) {
            //     event.preventDefault();
            //     $('#add_lesson_modal').modal('show');
            // });
            // $('#add_quiz_modal_btn').click(function(event) {
            //     event.preventDefault();
            //     $('#add_quiz_modal').modal('show');
            // });
            // $('#add_assignment_modal_btn').click(function(event) {
            //     event.preventDefault();
            //     $('#add_assignment_modal').modal('show');
            // });
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
