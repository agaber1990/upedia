 <!-- Update Quiz Modal -->
 <div class="modal fade" id="update_quiz_modal_{{ $item->id }}" tabindex="-1" aria-labelledby="update_quiz_modal_label"
     aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <form id="sessionQuizForm_{{ $item->id }}"
             action="{{ route('track_levels_sessions_quiz_update', ['id' => $item->id]) }}" method="POST"
             enctype="multipart/form-data">
             @method('PUT')
             @csrf
             <div class="modal-content">

                 <div class="modal-header">
                     <h1 class="modal-title fs-5" id="update_quiz_modal_label">@lang('academics.update_quiz')</h1>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                 </div>
                 <div class="modal-body">
                     <meta name="csrf-token" content="{{ csrf_token() }}">

                     <div class="">
                         <div class="primary_input">
                             <label class="primary_input_label" for="name">@lang('academics.title')
                             </label>
                             <input class="primary_input_field form-control" type="text" name="title"
                                 id="title" autocomplete="off" value="{{ $item->title }}">
                         </div>
                         <div class="primary_input">
                             <label class="primary_input_label" for="name">@lang('academics.instruction')
                             </label>
                             <input class="primary_input_field form-control" type="text" name="instruction"
                                 id="instruction" autocomplete="off" value="{{ $item->instruction }}">
                         </div>
                         <div class="primary_input">
                             <label class="primary_input_label" for="name">@lang('academics.min_percentage')
                             </label>
                             <input class="primary_input_field form-control" type="text" name="min_percentage"
                                 id="min_percentage" autocomplete="off" value="{{ $item->min_percentage }}">
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
                                     <option value="{{ $option }}"
                                         {{ $item->privacy == $option ? 'selected' : '' }}>
                                         {{ ucfirst($option) }}</option>
                                 @endforeach
                             </select>
                         </div>

                     </div>

                 </div>
                 <div class="modal-footer">

                     <button type="submit" id="sessionQuizFormBtn_{{ $item->id }}"
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
     <script></script>
 @endpush
