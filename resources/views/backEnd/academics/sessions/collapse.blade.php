{{-- @if (isset($groupedMenus[$level->id]) && count($groupedMenus[$level->id]) > 0) --}}
<div class="input-session mb-4">


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
                                        onclick="updateSession({{ $element->id }},'{{ addslashes($element->name_en) }}','{{ addslashes($element->name_ar) }}','{{ addslashes($element->description_en) }}','{{ addslashes($element->description_ar) }}','{{ $element->level_id }}','{{ $element->track_id }}',{{ json_encode($element->file) }})"
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
                                <div class="row">
                                    <div class="col">
                                        <h4>@lang('academics.track'):</h4>
                                        <p class="text-dark">{{ $element->track->track_name_en }}</p>
                                    </div>
                                    <div class="col">
                                        <h4>@lang('common.level'):</h4>
                                        <p class="text-dark">{{ $element->level->name_en }}</p>
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
                                        @if (is_array($element->file) || is_object($element->file))
                                            <div class="row">
                                                @foreach ($element->file as $index => $file)
                                                    <div class="co-md-4">
                                                        <a href="/{{ $file }}" target="_blank" class="mx-1">
                                                            <i class="fa fa-eye"></i> @lang('common.view_material')
                                                            {{ $index + 1 }}
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span>
                                                @lang('common.no_material_available')
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</div>

{{-- @endif --}}


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
        function updateSession(id, name_en, name_ar, description_en, description_ar, level_id, track_id, files) {


            $('#update_session_id').val(id);
            $('#update_name_en').val(name_en);
            $('#update_name_ar').val(name_ar);
            $('#update_description_en').val(description_en);
            $('#update_description_ar').val(description_ar);
            $('#update_level_id').val(level_id);
            $('#update_track_id').val(track_id);

            $('#existing_files').empty();
            if (typeof files === 'string') {
                try {
                    files = JSON.parse(files);
                } catch (error) {
                    console.error('Error parsing files:', error);
                    files = [];
                }
            }

            if (files && files.length > 0) {
                files.forEach((file, index) => {
                    $('#existing_files').append(`
                <div class="file-item">
                <a target="_blank" href="/${file}"><i class="fa fa-eye"></i> @lang('common.view_material') ${index +1}</a>             
                </div>
            `);
                });
            }
            $('#ModalUpdateSession').modal('show');
        }
    </script>
@endpush
