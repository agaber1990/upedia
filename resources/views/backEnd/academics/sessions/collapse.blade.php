@if (count(@$menus) > 0)
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div id="accordion" class="dd">
                        <ol class="dd-list">
                            @foreach ($menus as $key => $element)
                                <li class="dd-item" data-id="{{ $element->id }}">
                                    <div class="card accordion_card" id="accordion_{{ $element->id }}">
                                        <div class="card-header item_header" id="heading_{{ $element->id }}">
                                            <div class="dd-handle">
                                                <div class="pull-left">
                                                    @lang('common.title') : {{ $element->session_name_en }}
                                                </div>
                                            </div>
                                            <div class="pull-right btn_div">
                                                @if (userPermission('element-update'))
                                                    <a href="javascript:void(0);" onclick="" data-toggle="collapse"
                                                        data-target="#collapse_{{ $element->id }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapse_{{ $element->id }}"
                                                        class="primary-btn btn_zindex panel-title">
                                                        @lang('common.edit')
                                                        <span class="collapge_arrow_normal"></span>
                                                    </a>
                                                @endif
                                                @if (env('APP_SYNC') == true)
                                                    <a href="javascript:void(0);" class="primary-btn btn_zindex"
                                                        title="Disable For Demo" data-toggle="tooltip">
                                                        <i class="ti-close"></i>
                                                    </a>
                                                @else
                                                    @if (userPermission('delete-element'))
                                                        <a href="javascript:void(0);"
                                                            onclick="elementDelete({{ $element->id }})"
                                                            class="primary-btn btn_zindex">
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
                                                <form enctype="multipart/form-data" id="elementEditForm">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div>

                                                                <button class="btn btn-primary btn-sm"
                                                                    onclick="updateSession({{ $element->id }}, '{{ $element->session_name_en }}', '{{ $element->session_name_ar }}')">
                                                                    Edit
                                                                </button>
                                                            </div>
                                                            <div>
                                                                @lang('common.session_name_en') : {{ $element->session_name_en }}
                                                            </div>
                                                            <div>
                                                                @lang('common.session_number') : {{ $element->session_number }}
                                                            </div>
                                                            <div>
                                                                @lang('common.session_ref') : {{ $element->session_ref }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body text-center">
            @lang('front_settings.not_found_data')
        </div>
    </div>
@endif

@push('script')
    <script>
        function updateSession(id, session_name_en, session_name_ar) {
            $('#update_session_name_en').val(session_name_en);
            $('#update_session_name_ar').val(session_name_ar);
            $('#update_session_track_id').val(id);

            $('#ModalUpdateSession').modal('show');
        }
    </script>
@endpush
