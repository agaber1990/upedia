 <!-- Add Lesson Modal -->
 <div class="modal fade" id="add_lesson_modal_{{ $element->id }}" tabindex="-1" aria-labelledby="add_lesson_modal_label"
     aria-hidden="true">
     <div class="modal-dialog modal-lg">

         <form id="sessionLessonForm" action="{{ route('track_levels_sessions_lessons') }}" method="POST"
             enctype="multipart/form-data">
             @csrf
             <div class="modal-content">

                 <div class="modal-header">
                     <h1 class="modal-title fs-5" id="add_lesson_modal_label">@lang('academics.add_lesson')
                     </h1>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                 </div>
                 <div class="modal-body">

                     <meta name="csrf-token" content="{{ csrf_token() }}">
                     <input type="hidden" name="session_id" id="lesson_session_id" value="{{ $element->id }}">
                     <input type="hidden" name="level_id" id="lesson_level_id" value="{{ $level->id }}">

                     <div class="primary_input">
                         <label class="primary_input_label" for="name">@lang('academics.lesson_name')
                             <span class="text-danger"> *</span>
                         </label>
                         <input class="primary_input_field form-control" type="text" name="name" id="lesson_name"
                             autocomplete="off">
                     </div>
                     <div class="primary_input">
                         <label class="primary_input_label" for="duration">@lang('academics.duration_in_minute')
                             <span class="text-danger"> *</span>
                         </label>
                         <input class="primary_input_field form-control" type="text" name="duration"
                             id="lesson_duration" autocomplete="off">
                     </div>

                     @php
                         $hostTypeEnum = DB::select("SHOW COLUMNS FROM session_lessons WHERE Field = 'host_type'")[0]
                             ->Type;
                         preg_match('/^enum\((.*)\)$/', $hostTypeEnum, $matches);
                         $hostTypes = array_map(fn($value) => trim($value, "'"), explode(',', $matches[1]));
                     @endphp

                     <div class="primary_input">
                         <label class="primary_input_label" for="">
                             @lang('academics.host') <span class="text-danger"> *</span>
                         </label>
                         <select class="primary_select form-control" name="host_type"
                             id="lesson_host_type_{{ $element->id }}">
                             <option value="">@lang('common.select')</option>
                             @foreach ($hostTypes as $type)
                                 <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                             @endforeach
                         </select>
                     </div>



                     <div id="youtubeUrlDiv_{{ $element->id }}">

                     </div>

                     <div id="fileUploadDiv_{{ $element->id }}">

                     </div>

                     <div class="primary_input">
                         <label class="primary_input_label" for="">@lang('academics.privacy')<span class="text-danger">
                                 *</span></label>
                         <select class="primary_select form-control" name="privacy" id="lesson_privacy">
                             <option value="">@lang('common.select')</option>

                             @php
                                 $enumValues = DB::select(
                                     "SHOW COLUMNS FROM session_lessons WHERE Field = 'privacy'",
                                 )[0]->Type;
                                 preg_match('/^enum\((.*)\)$/', $enumValues, $matches);
                                 $privacyOptions = array_map(
                                     fn($value) => trim($value, "'"),
                                     explode(',', $matches[1]),
                                 );
                             @endphp

                             @foreach ($privacyOptions as $option)
                                 <option value="{{ $option }}">{{ ucfirst($option) }}
                                 </option>
                             @endforeach
                         </select>
                     </div>


                     <div class="primary_input">
                         <label class="primary_input_label" for="description">@lang('academics.description')
                             <span class="text-danger"> *</span>
                         </label>

                         <textarea class="primary_input_field form-control" name="description" id="lesson_description" rows="5"></textarea>

                     </div>
                 </div>
                 <div class="modal-footer">

                     <button type="submit" id="sessionLessonFormBtn" class="primary-btn fix-gr-bg text-nowrap">
                         @lang('common.submit')
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
             var selectedType = $('[id^="lesson_host_type_"]').val();

             $('[id^="youtubeUrlDiv_"]').empty();
             $('[id^="fileUploadDiv_"]').empty();

             if (selectedType === "youtube") {
                 $('[id^="youtubeUrlDiv_"]').append(
                     `
                    <div class="primary_input">
                        <label class="primary_input_label" for="host_path_url">@lang('common.url')</label>
                        <input class="primary_input_field form-control" id="host_path_url" type="text" name="host_path" placeholder="Enter YouTube URL" autocomplete="off">
                    </div>
                    `
                 );
             } else if (selectedType !== "") {
                 $('[id^="fileUploadDiv_"]').append(
                     `
                    <div class="primary_input">
                        <label for="host_path_file" class="primary_input_label">@lang('common.file')</label>
                        <input class="primary_input_field form-control" type="file" name="host_path" id="host_path_file">
                    </div>
                    `
                 );
             }

             $('[id^="lesson_host_type_"]').change(function() {
                 var selectedHostType = $(this).val();

                 $('[id^="youtubeUrlDiv_"]').empty();
                 $('[id^="fileUploadDiv_"]').empty();

                 if (selectedHostType === "youtube") {
                     $('[id^="youtubeUrlDiv_"]').append(
                         `
                        <div class="primary_input">
                            <label class="primary_input_label" for="host_path_url">@lang('common.url')</label>
                            <input class="primary_input_field form-control" id="host_path_url" type="text" name="host_path" placeholder="Enter YouTube URL" autocomplete="off">
                        </div>
                        `
                     );
                 } else {
                     $('[id^="fileUploadDiv_"]').append(
                         `
                            <div class="primary_input">
                                <label for="host_path_file" class="primary_input_label">@lang('common.file')</label>
                                <input class="primary_input_field form-control" type="file" name="host_path" id="host_path_file">
                            </div>
                            `
                     );
                 }
             });


             $(document).ready(function() {
                 // Handle form submission
                 $("#sessionLessonForm").on('submit', function(event) {
                     event.preventDefault(); // Prevent the default form submission

                     var formData = new FormData(this); // Create FormData object
                     var hostType = $('[id^="lesson_host_type_"]').val(); // Get selected host type

                     // Append host_path based on host_type
                     if (hostType === "youtube") {
                         var hostUrl = $("#host_path_url");
                         if (hostUrl.length > 0) {
                             formData.append("host_path", hostUrl.val()); // Append YouTube URL
                         } else {
                             toastr.error("Host URL input is missing.");
                             return; // Stop execution if host URL is missing
                         }
                     } else {
                         var hostFile = $("#host_path_file")[0];
                         if (hostFile && hostFile.files.length > 0) {
                             formData.append("host_path", hostFile.files[0]); // Append file
                         } else {
                             toastr.error("Host file input is missing.");
                             return; // Stop execution if host file is missing
                         }
                     }

                     // Send AJAX request
                     $.ajax({
                         url: $(this).attr('action'), // Use the form's action attribute
                         type: "POST",
                         data: formData,
                         processData: false,
                         contentType: false,
                         beforeSend: function() {
                             $("#sessionLessonFormBtn").prop('disabled',
                                 true); // Disable submit button
                         },
                         success: function(response) {
                             toastr.success(response.message,
                                 'Success'); // Show success message
                             $("#sessionLessonForm")[0].reset(); // Reset the form
                             location.reload(); // Reload the page (optional)
                         },
                         error: function(xhr) {
                             if (xhr.responseJSON && xhr.responseJSON.errors) {
                                 var errors = xhr.responseJSON.errors;
                                 $.each(errors, function(key, value) {
                                     toastr.error(value[0],
                                         key); // Show validation errors
                                 });
                             } else {
                                 toastr.error(
                                     'Something went wrong. Please try again later.',
                                     'Failed');
                             }
                             $("#sessionLessonFormBtn").prop('disabled',
                                 false); // Re-enable submit button
                         }
                     });
                 });
             });

         });
     </script>
 @endpush
