 <!-- Add Quiz Modal -->
 <div class="modal fade" id="add_quiz_modal_{{ $element->id }}" tabindex="-1" aria-labelledby="add_quiz_modal_label"
     aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <form id="sessionQuizForm_{{ $element->id }}" action="{{ route('track_levels_sessions_quiz') }}" method="POST"
             enctype="multipart/form-data">
             @csrf
             <div class="modal-content">

                 <div class="modal-header">
                     <h1 class="modal-title fs-5" id="add_quiz_modal_label">@lang('academics.add_quiz')</h1>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                 </div>
                 <div class="modal-body">
                     <meta name="csrf-token" content="{{ csrf_token() }}">
                     <input type="hidden" name="session_id" id="lesson_session_id" value="{{ $element->id }}">
                     <input type="hidden" name="level_id" id="lesson_level_id" value="{{ $level->id }}">

                     <!-- Add this div to store quiz options -->
                     <div id="quizOptions_{{ $element->id }}" data-quiz-options='@json($quiz->where('session_id', $element->id)->toArray())'>
                     </div>

                     <div id="choose_quiz_type_{{ $element->id }}">
                         <div class="row">
                             <div class="col-lg-12 radio-btn-flex">
                                 <div class="row">
                                     <div class="col-lg-5 primary_input sm_mb_20">
                                         <input type="radio" name="quiz_option_{{ $element->id }}"
                                             id="exist_quiz_{{ $element->id }}" class="common-radio" value="1">
                                         <label for="exist_quiz_{{ $element->id }}">@lang('common.existing')</label>
                                     </div>
                                     <div class="col-lg-7 primary_input sm_mb_20">
                                         <input type="radio" name="quiz_option_{{ $element->id }}"
                                             id="new_quiz_{{ $element->id }}" class="common-radio" value="0">
                                         <label for="new_quiz_{{ $element->id }}">@lang('common.new')</label>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div id="additional_inputs_{{ $element->id }}"></div>
                     </div>

                 </div>
                 <div class="modal-footer">

                     <button type="submit" id="sessionQuizFormBtn_{{ $element->id }}"
                         class="primary-btn fix-gr-bg text-nowrap">
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
             function handleQuizOption(modalId) {
                 const existQuiz = $('#exist_quiz_' + modalId).prop('checked');
                 const newQuiz = $('#new_quiz_' + modalId).prop('checked');

                 const quizOptions = $('#quizOptions_' + modalId).data('quiz-options');
                 const quizOptionsArray = Array.isArray(quizOptions) ? quizOptions : Object.values(quizOptions);

                 if (Array.isArray(quizOptionsArray)) {
                     let optionsHtml = '<option value="">@lang('academics.add_quiz')</option>';
                     quizOptionsArray.forEach(option => {
                         optionsHtml += `<option value="${option.id}">${option.title}</option>`;
                     });


                     if (existQuiz) {
                         $('#additional_inputs_' + modalId).html(`
                           <div class="primary_input">
                                   <label class="primary_input_label" for="">@lang('common.existing')</label>
                                   <select class="primary_select form-control" name="quiz" id="quiz">
                                        ${optionsHtml}
                                   </select>
                               </div>
                               <div class="primary_input">
                                   <label class="primary_input_label" for="">@lang('common.new')</label>
                                   <select class="primary_select form-control" name="privacy" id="privacy">
                                       <option value="">@lang('common.select')</option>
                                       @php
                                           $enumValues = DB::select("SHOW COLUMNS FROM session_quizzes WHERE Field = 'privacy'")[0]->Type;
                                           preg_match('/^enum\((.*)\)$/', $enumValues, $matches);
                                           $privacyOptions = array_map(fn($value) => trim($value, "'"), explode(',', $matches[1]));
                                       @endphp

                             @foreach ($privacyOptions as $option)
                                 <option value="{{ $option }}">{{ ucfirst($option) }}
                                 </option>
                             @endforeach
                                   </select>
                               </div>
                           `);
                     } else if (newQuiz) {
                         $('#additional_inputs_' + modalId).html(`
                           <div class="primary_input">
                               <label class="primary_input_label" for="name">@lang('academics.title')
                                   <span class="text-danger"> *</span>
                               </label>
                               <input class="primary_input_field form-control" type="text" name="title" required id="title" autocomplete="off">
                           </div>
                           <div class="primary_input">
                               <label class="primary_input_label" for="name">@lang('academics.instruction')
                                   <span class="text-danger"> *</span>
                               </label>
                               <input class="primary_input_field form-control" type="text" required name="instruction" id="instruction" autocomplete="off">
                           </div>
                           <div class="primary_input">
                               <label class="primary_input_label" for="name">@lang('academics.min_percentage')
                                   <span class="text-danger"> *</span>
                               </label>
                               <input class="primary_input_field form-control" type="text" name="min_percentage" required id="min_percentage" autocomplete="off">
                           </div>
                           <div class="primary_input">
                               <label class="primary_input_label" for="">@lang('academics.privacy')</label>
                               <select class="primary_select form-control" name="privacy" id="privacy">
                                   <option value="">@lang('common.select')</option>
                                   @php
                                 $enumValues = DB::select(
                                     "SHOW COLUMNS FROM session_quizzes WHERE Field = 'privacy'",
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
                       `);
                     }
                 } else {
                     console.error("Quiz options are not an array:", quizOptions);
                 }
             }
             // Bind event listeners when a quiz modal is opened
             $(document).on('click', '[id^="add_quiz_modal_btn_"]', function(event) {
                 event.preventDefault();
                 const modalTarget = $(this).data('modal-target');
                 $(modalTarget).modal('show');

                 // Extract the modal ID
                 const modalId = modalTarget.split('_').pop();

                 // Bind change event to the radio buttons
                 $(`#exist_quiz_${modalId}, #new_quiz_${modalId}`).change(function() {
                     handleQuizOption(modalId);
                 });

                 // Initialize the quiz options
                 handleQuizOption(modalId);
             });



             $('[id^="sessionQuizForm_"]').off('submit').on('submit', function(event) {
                 event.preventDefault(); // Prevent the default form submission

                 var form = $(this);
                 var formData = new FormData(this); // Create FormData object

                 var submitButton = form.find('[id^="sessionQuizFormBtn_"]');

                 // Disable submit button to prevent multiple clicks
                 submitButton.prop('disabled', true);

                 // Send AJAX request
                 $.ajax({
                     url: form.attr('action'), // Use the form's action attribute
                     type: "POST",
                     data: formData,
                     processData: false,
                     contentType: false,
                     success: function(response) {
                         toastr.success(response.message,
                             'Success'); // Show success message
                         form[0].reset(); // Reset the form
                         setTimeout(function() {
                             location
                                 .reload(); // Reload the page after a delay (optional)
                         }, 1000);
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
                                 'Failed'
                             );
                         }
                         submitButton.prop('disabled',
                             false); // Re-enable submit button on failure
                     }
                 });
             });
         });
     </script>
 @endpush
