    @if (isset($menus) && count($menus) > 0)

        <div class="input-level mb-4">
            <div id="accordion" class="dd">
                <ol class="dd-list">
                    @foreach ($menus as $key => $element)
                        <li class="dd-item" data-id="{{ $element->id }}">
                            <div class="card accordion_card" id="accordion_{{ $element->id }}">
                                <div class=" item_header" id="heading_{{ $element->id }}">
                                    <div class="dd-handle">
                                        <div class="pull-left">
                                            {{ $element->name_en }}
                                        </div>
                                    </div>
                                    <div class="pull-right btn_div">
                                        @if (userPermission('element-update'))
                                            <a href="javascript:void(0);"
                                                onclick="updateLevel({{ $element->id }}, '{{ $element->name_en }}', '{{ $element->name_ar }}', '{{ $element->description_en }}', '{{ $element->description_ar }}', '{{ $element->file }}')"
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
                                        @if (userPermission('element-update'))
                                            <a href="{{ route('track_levels_sessions', ['track_id' => $element->track_id, 'level_id' => $element->id]) }}"
                                                class="primary-btn btn_zindex panel-title">
                                                @lang('common.sessions')
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        @endif
                                        @if (env('APP_SYNC') == true)
                                            <a href="javascript:void(0);" class="primary-btn btn_zindex mb-3"
                                                title="Disable For Demo" data-toggle="tooltip">
                                                <i class="ti-close"></i>
                                            </a>
                                        @else
                                            @if (userPermission('delete-element'))
                                                <a href="javascript:void(0);"
                                                    onclick="elementDelete({{ $element->id }})"
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
                                        <div class="row">
                                            <div class="col">
                                                <h4>@lang('academics.track'):</h4>
                                                <p class="text-dark">{{ $element->track->name_en }}</p>
                                            </div>

                                            <div class="col">
                                                <h4>@lang('academics.name_en'):</h4>
                                                <p class="text-dark">{{ $element->name_en }}</p>
                                            </div>
                                            <div class="col">
                                                <h4>@lang('academics.name_ar'):</h4>
                                                <p class="text-dark">{{ $element->name_ar }}</p>
                                            </div>

                                            <div class="col">
                                                <h4>@lang('common.materials'):</h4>
                                                <a href="/{{ $element->file }}" target="_blank" class="mx-1">
                                                    <i class="fa fa-eye"></i> @lang('common.view_material')
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </ol>
            </div>
        </div>
    @else
    <div class="text-center">

            <h4>
                @lang('common.no_levels')
            </h4>

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
            function updateLevel(id, name_en, name_ar, description_en, description_ar, file) {
                $('#update_level_name_en').val(name_en);
                $('#update_level_name_ar').val(name_ar);
                $('#update_level_description_en').val(description_en);
                $('#update_level_description_ar').val(description_ar);
                $('#update_level_track_id').val(id);
                $('#current_file_name').html(`
                <a target="_blank" href="/${file}"><i class="fa fa-eye"></i> View @lang('common.view_material')</a>
                `);
                $('#ModalUpdateLevel').modal('show');
            }
        </script>
    @endpush
