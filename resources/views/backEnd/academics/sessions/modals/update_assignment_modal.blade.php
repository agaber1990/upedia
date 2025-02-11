<!-- Update Assignment Modal -->
<div class="modal fade" id="update_assignment_modal_{{ $item->id }}" tabindex="-1"
    aria-labelledby="update_assignment_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">


        <form id="sessionAssignmentFormUpdate"
            action="{{ route('track_levels_sessions_assignment_update', ['id' => $item->id]) }}" method="POST"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="update_assignment_modal_label">@lang('academics.update_assignment')
                    </h1>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <meta name="csrf-token" content="{{ csrf_token() }}">


                    <div class="primary_input">
                        <label class="primary_input_label" for="title">@lang('academics.title')

                        </label>
                        <input class="primary_input_field form-control" type="text" value="{{ $item->title }}"
                            name="title">
                    </div>


                    <div class="row">
                        <div class="col primary_input">
                            <label class="primary_input_label" for="marks">@lang('academics.marks')

                            </label>
                            <input class="primary_input_field form-control" type="number" value="{{ $item->marks }}"
                                name="marks">
                        </div>
                        <div class="col primary_input">
                            <label class="primary_input_label" for="min_percentage">@lang('academics.min_percentage')

                            </label>
                            <input class="primary_input_field form-control" type="number"
                                value="{{ $item->min_percentage }}" name="min_percentage">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col primary_input">
                            <label class="primary_input_label" for="attachment">@lang('academics.attachment')

                            </label>
                            <input class="primary_input_field form-control" type="file" name="attachment">
                            <small>Current file: <a target="_blank" href="/{{ $item->attachment }}"><i
                                        class="fa fa-eye"></i> @lang('common.view_file')</a> </small>
                        </div>


                        <div class="col primary_input">
                            <label class="primary_input_label" for="submit_date">@lang('academics.submit_date')

                            </label>
                            <input class="primary_input_field form-control" type="date"
                                value="{{ $item->submit_date }}" name="submit_date">
                        </div>
                    </div>


                    <div class="primary_input">
                        <label class="primary_input_label" for="description">@lang('academics.description')

                        </label>
                        <textarea class="primary_input_field form-control" name="description" rows="5">{{ $item->description }}</textarea>
                    </div>

                    <div class="primary_input">
                        <label class="primary_input_label" for="">@lang('academics.privacy')</label>
                        <select class="primary_select form-control" name="privacy" id="assignment_privacy">
                            <option value="">@lang('common.select')</option>

                            @php
                                $enumValues = DB::select(
                                    "SHOW COLUMNS FROM session_assignments WHERE Field = 'privacy'",
                                )[0]->Type;
                                preg_match('/^enum\((.*)\)$/', $enumValues, $matches);
                                $privacyOptions = array_map(fn($value) => trim($value, "'"), explode(',', $matches[1]));

                            @endphp

                            @foreach ($privacyOptions as $option)
                                <option value="{{ $option }}" {{ $item->privacy == $option ? 'selected' : '' }}>
                                    {{ ucfirst($option) }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">

                    <button type="submit" id="sessionAssignmentFormBtnUpdate"
                        class="primary-btn fix-gr-bg text-nowrap">
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
    <script></script>
@endpush
