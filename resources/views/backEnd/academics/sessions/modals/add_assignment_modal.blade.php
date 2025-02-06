 <!-- Add Assignment Modal -->
 <div class="modal fade" id="add_assignment_modal_{{ $element->id }}" tabindex="-1"
     aria-labelledby="add_assignment_modal_label" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <form action="" method="POST" enctype="multipart/form-data">
             @csrf
             <div class="modal-content">

                 <div class="modal-header">
                     <h1 class="modal-title fs-5" id="add_assignment_modal_label">
                         @lang('academics.add_assignment')</h1>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                 </div>
                 <div class="modal-body">

                     <div class="primary_input">
                         <label class="primary_input_label" for="name">@lang('academics.title')
                             <span class="text-danger"> *</span>
                         </label>
                         <input class="primary_input_field form-control" type="text" name="title" id="title"
                             autocomplete="off">
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
                         <textarea name="" class="primary_input_field form-control" name="description" id="description" rows="5">
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
     <script></script>
 @endpush
