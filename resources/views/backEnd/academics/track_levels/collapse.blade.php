    <div class="input-level mb-4">
        <div id="accordion" class="dd">
            <ol class="dd-list">
                @foreach ($menu as $key => $element)
                    <li class="dd-item" data-id="{{ $element->id }}">
                        <div class="card accordion_card" id="accordion_{{ $element->id }}">
                            <div class=" item_header" id="heading_{{ $element->id }}">
                                <div class="dd-handle">
                                    <div class="pull-left">
                                        {{ $element->level_name_en }}
                                    </div>
                                </div>
                                <div class="pull-right btn_div">
                                    @if (userPermission('element-update'))
                                        <a href="javascript:void(0);"
                                            onclick="updateLevel({{ $element->id }}, '{{ $element->level_name_en }}', '{{ $element->level_name_ar }}','{{ $element->level_id }}')"
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
            function updateLevel(id, level_name_en, level_name_ar, level_id) {
                $('#update_level_name_en').val(level_name_en);
                $('#update_level_name_ar').val(level_name_ar);
                $('#update_level_id').val(level_id);
                $('#update_level_track_id').val(id);
                $('#ModalUpdateLevel').modal('show');
                console.log(level_id);

            }
        </script>
    @endpush
