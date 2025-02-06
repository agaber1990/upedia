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

                     <button type="submit" id="add_for_submit" class="primary-btn fix-gr-bg text-nowrap">
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

                 if (existQuiz) {
                     $('#additional_inputs_' + modalId).html(`
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
                 } else if (newQuiz) {
                     $('#additional_inputs_' + modalId).html(`
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
         });
     </script>
 @endpush
