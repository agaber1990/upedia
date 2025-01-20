@if (count(@$menus) > 0)
<div class="input-session">
    
    <div id="accordion" class="dd">
        <ol class="dd-list">
            @foreach ($menus as $key => $element)
                <li class="dd-item" data-id="{{ $element->id }}">
                    <div class="card accordion_card" id="accordion_{{ $element->id }}">
                        <div class=" item_header" id="heading_{{ $element->id }}">
                            <div class="dd-handle">
                                <div class="pull-left">
                                    {{ $element->session_name_en }}
                                </div>
                            </div>
                            <div class="pull-right btn_div">
                                @if (userPermission('element-update'))
                                    <a href="javascript:void(0);"
                                        onclick="updateSession({{ $element->id }}, '{{ $element->session_name_en }}', '{{ $element->session_name_ar }}')"
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
                                <form enctype="multipart/form-data" id="elementEditForm">
                                    <div class="row">

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
@else
    <div class="input-session">
        <div class="card-body text-center">

           No Data
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
        function updateSession(id, session_name_en, session_name_ar) {
            $('#update_session_name_en').val(session_name_en);
            $('#update_session_name_ar').val(session_name_ar);
            $('#update_session_track_id').val(id);

            $('#ModalUpdateSession').modal('show');
        }
    </script>
@endpush
