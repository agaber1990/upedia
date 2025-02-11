<!-- Add Assignment Modal -->
<div class="modal fade" id="add_assignment_modal_{{ $element->id }}" tabindex="-1"
    aria-labelledby="add_assignment_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="sessionAssignmentForm_{{ $element->id }}" action="{{ route('track_levels_sessions_assignment') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="add_assignment_modal_label">
                        @lang('academics.add_assignment')</h1>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <input type="hidden" name="session_id" value="{{ $element->id }}">
                    <input type="hidden" name="level_id" value="{{ $level->id }}">

                    <div class="primary_input">
                        <label class="primary_input_label" for="title">@lang('academics.title')
                            <span class="text-danger"> *</span>
                        </label>
                        <input class="primary_input_field form-control" type="text" name="title" required>
                    </div>

                    <div class="row">
                        <div class="col primary_input">
                            <label class="primary_input_label" for="marks">@lang('academics.marks')
                                <span class="text-danger"> *</span>
                            </label>
                            <input class="primary_input_field form-control" type="number" name="marks" required>
                        </div>
                        <div class="col primary_input">
                            <label class="primary_input_label" for="min_percentage">@lang('academics.min_percentage')
                                <span class="text-danger"> *</span>
                            </label>
                            <input class="primary_input_field form-control" type="number" name="min_percentage"
                                required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col primary_input">
                            <label class="primary_input_label" for="attachment">@lang('academics.attachment')
                                <span class="text-danger"> *</span>
                            </label>
                            <input class="primary_input_field form-control" type="file" name="attachment" required>
                        </div>
                        <div class="col primary_input">
                            <label class="primary_input_label" for="submit_date">@lang('academics.submit_date')
                                <span class="text-danger"> *</span>
                            </label>
                            <input class="primary_input_field form-control" type="date" name="submit_date" required>
                        </div>
                    </div>

                    <div class="primary_input">
                        <label class="primary_input_label" for="description">@lang('academics.description')
                            <span class="text-danger"> *</span>
                        </label>
                        <textarea class="primary_input_field form-control" name="description" rows="5" required></textarea>
                    </div>

                    <div class="primary_input">
                        <label class="primary_input_label" for="assignment_privacy">@lang('academics.privacy')
                            <span class="text-danger"> *</span></label>
                        <select class="primary_select form-control" name="privacy" required>
                            <option value="">@lang('common.select')</option>
                            @php
                                $enumValues = DB::select(
                                    "SHOW COLUMNS FROM session_assignments WHERE Field = 'privacy'",
                                )[0]->Type;
                                preg_match('/^enum\((.*)\)$/', $enumValues, $matches);
                                $privacyOptions = array_map(fn($value) => trim($value, "'"), explode(',', $matches[1]));
                            @endphp
                            @foreach ($privacyOptions as $option)
                                <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="sessionAssignmentFormBtn_{{ $element->id }}" class="primary-btn fix-gr-bg text-nowrap">
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

    .item_header .pull-left,
    .item_header .primary-btn,
    .item_header .collapge_arrow_normal {
        color: #fff;
    }
</style>


@push('script')
    <script>
        $(document).ready(function() {
            $('[id^="sessionAssignmentForm_"]').off('submit').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                var form = $(this);
                var formData = new FormData(this); // Create FormData object
        
                var submitButton = form.find('[id^="sessionAssignmentFormBtn_"]');

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
