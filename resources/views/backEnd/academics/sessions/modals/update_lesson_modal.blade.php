<!-- Update Lesson Modal -->
<div class="modal fade" id="update_lesson_modal_{{ $item->id }}" tabindex="-1"
    aria-labelledby="update_lesson_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">


        <form id="sessionLessonFormUpdate"
            action="{{ route('track_levels_sessions_lessons_update', ['id' => $item->id]) }}" method="POST"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="update_lesson_modal_label">@lang('academics.update_lesson')
                    </h1>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="primary_input">
                        <label class="primary_input_label" for="name">@lang('academics.lesson_name')

                        </label>
                        <input class="primary_input_field form-control" type="text" value="{{ $item->name }}"
                            name="name" id="lesson_name" autocomplete="off">
                    </div>
                    <div class="primary_input">
                        <label class="primary_input_label" for="duration">@lang('academics.duration_in_minute')

                        </label>
                        <input class="primary_input_field form-control" type="text" name="duration"
                            id="lesson_duration" value="{{ $item->duration }}" autocomplete="off">
                    </div>

                    @php
                        $hostTypeEnum = DB::select("SHOW COLUMNS FROM session_lessons WHERE Field = 'host_type'")[0]
                            ->Type;
                        preg_match('/^enum\((.*)\)$/', $hostTypeEnum, $matches);
                        $hostTypes = array_map(fn($value) => trim($value, "'"), explode(',', $matches[1]));

                    @endphp

                    <div class="primary_input">
                        <label class="primary_input_label" for="">
                            @lang('academics.host')
                        </label>
                        <select class="primary_select form-control" name="host_type"
                            id="lesson_host_type_{{ $item->id }}">
                            <option value="">@lang('common.select')</option>
                            @foreach ($hostTypes as $type)
                                <option value="{{ $type }}" {{ $item->host_type == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}</option>
                            @endforeach

                        </select>
                    </div>



                    <div id="youtubeUrlDiv_{{ $item->id }}">

                    </div>

                    <div id="fileUploadDiv_{{ $item->id }}">

                    </div>

                    <div class="primary_input">
                        <label class="primary_input_label" for="">@lang('academics.privacy')</label>
                        <select class="primary_select form-control" name="privacy" id="lesson_privacy">
                            <option value="">@lang('common.select')</option>

                            @php
                                $enumValues = DB::select("SHOW COLUMNS FROM session_lessons WHERE Field = 'privacy'")[0]
                                    ->Type;
                                preg_match('/^enum\((.*)\)$/', $enumValues, $matches);
                                $privacyOptions = array_map(fn($value) => trim($value, "'"), explode(',', $matches[1]));

                            @endphp

                            @foreach ($privacyOptions as $option)
                                <option value="{{ $option }}" {{ $item->privacy == $option ? 'selected' : '' }}>
                                    {{ ucfirst($option) }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="primary_input">
                        <label class="primary_input_label" for="description">@lang('academics.description')

                        </label>

                        <textarea class="primary_input_field form-control" name="description" id="lesson_description" rows="5">{{ $item->description }}</textarea>

                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" id="sessionLessonFormBtnUpdate" class="primary-btn fix-gr-bg text-nowrap">
                        @lang('common.update')
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>



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
                var selectedHostType = $('#lesson_host_type_{{ $item->id }}').val();
                toggleHostFields(selectedHostType);
                $('#lesson_host_type_{{ $item->id }}').change(function() {
                    var selectedHostType = $(this).val();
                    toggleHostFields(selectedHostType);
                });

                function toggleHostFields(hostType) {
                    if (hostType === "youtube") {
                        $('#youtubeUrlDiv_{{ $item->id }}').html(`
               <div class="primary_input">
                   <label class="primary_input_label" for="host_path_url">@lang('common.url')</label>
                   <input class="primary_input_field form-control" id="host_path_url" type="text" name="host_path" value="{{ $item->host_path }}" placeholder="Enter YouTube URL" autocomplete="off">
               </div>
           `);
                        $('#fileUploadDiv_{{ $item->id }}').empty();
                    } else if (hostType !== "") {
                        $('#fileUploadDiv_{{ $item->id }}').html(`
               <div class="primary_input">
                   <label for="host_path_file" class="primary_input_label">@lang('common.file')</label>
                   <input class="primary_input_field form-control" type="file" name="host_path" id="host_path_file" value="{{ $item->host_path }}">
                   <small>Current file: <a target="_blank" href="/{{ $item->host_path }}"><i class="fa fa-eye"></i> @lang('common.view_file')</a>  </small>
               </div>
           `);
                        $('#youtubeUrlDiv_{{ $item->id }}').empty();
                    }
                }
            });


            $(document).ready(function() {

                $("#sessionLessonFormUpdate").on('submit', function(event) {
                    event.preventDefault();

                    var formData = new FormData(this);
                    var hostType = $('[id^="lesson_host_type_"]').val();


                    if (hostType === "youtube") {
                        var hostUrl = $("#host_path_url");
                        if (hostUrl.length > 0) {
                            formData.append("host_path", hostUrl.val());
                        } else {
                            toastr.error("Host URL input is missing.");
                            return;
                        }
                    } else {
                        var hostFile = $("#host_path_file")[0];
                        if (hostFile && hostFile.files.length > 0) {
                            formData.append("host_path", hostFile.files[0]);
                        }
                    }
                });
            });

        });
    </script>
@endpush
