@extends('backEnd.master')
@section('title')
    @lang('academics.track_level')
@endsection
{{-- {{dd($menus )}} --}}
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('academics.track_level')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a>@lang('academics.academics')</a>
                    <a href="{{ route('tracks') }}">@lang('academics.track')</a>
                    <a>@lang('academics.levels')</a>

                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid p-0">
            @if (isset($discountPlan))
                @if (userPermission('track_levels-store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ route('track_levels') }}" class="primary-btn small fix-gr-bg">
                                <span class="ti-plus pr-2"></span>
                                @lang('common.add')
                            </a>
                        </div>
                    </div>
                @endif
            @endif
            <div class="row">

                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="btnSelect">

                            <button id="add_level_btn" class="circular-btn mx-2" aria-label="Toggle new level form">
                                <i class="fas fa-plus" style="color: #fff"></i>
                            </button>
                        </div>
                        <div id="add_level" class="input-level" style="display: none;width:100%">
                            <button id="level_modal_btn" class="level-btn">
                                <i class="fas fa-plus" style="color: #000000"></i> Level
                            </button>
                        </div>
                    </div>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('track_levels_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf


                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('academics.add_level')</h1>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>



                                <div class="modal-body">
                                    <input type="hidden" id="track_id" name="track_id" value="{{ $track->id }}">

                                    <div class="primary_input">
                                        <label class="primary_input_label" for="name_en">@lang('academics.level_name_en')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text" name="name_en"
                                            id="name_en" autocomplete="off">
                                    </div>
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="name_ar">@lang('academics.level_name_ar')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text" id="name_ar"
                                            name="name_ar" autocomplete="off">
                                    </div>

                                    <div class="primary_input">
                                        <label class="primary_input_label" for="description_en">@lang('academics.level_description_en')
                                            <span class="text-danger"> *</span></label>
                                        <input class="primary_input_field form-control" type="text" name="description_en"
                                            id="description_en" autocomplete="off">
                                    </div>
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="description_ar">@lang('academics.level_description_ar')
                                            <span class="text-danger"> *</span></label>
                                        <input class="primary_input_field form-control" type="text" name="description_ar"
                                            id="description_ar" autocomplete="off">
                                    </div>
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="file">@lang('common.material')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="file" id="file"
                                            name="file">
                                    </div>
                                </div>
                                <div class="modal-footer">

                                    <button type="submit" class="primary-btn fix-gr-bg text-nowrap">
                                        @lang('common.submit')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- Modal Update -->
                <div class="modal fade" id="ModalUpdateLevel" tabindex="-1" aria-labelledby="ModalLabelUpdateLevel"
                    aria-hidden="true">
                    <div class="modal-dialog">


                        <form action="{{ route('track_level_update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="ModalLabelUpdateLevel">@lang('common.update')</h1>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <!-- Hidden input for track ID -->
                                    <input type="hidden" id="update_level_track_id" name="id">

                                    <!-- Level Name (EN) -->
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="update_level_name_en">@lang('academics.level_name_en')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text" name="name_en"
                                            id="update_level_name_en" autocomplete="off">
                                    </div>

                                    <!-- Level Name (AR) -->
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="update_level_name_ar">@lang('academics.level_name_ar')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text" name="name_ar"
                                            id="update_level_name_ar" autocomplete="off">
                                    </div>

                                    <!-- Description (EN) -->
                                    <div class="primary_input">
                                        <label class="primary_input_label"
                                            for="update_level_description_en">@lang('academics.level_description_en')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text"
                                            name="description_en" id="update_level_description_en" autocomplete="off">
                                    </div>

                                    <!-- Description (AR) -->
                                    <div class="primary_input">
                                        <label class="primary_input_label"
                                            for="update_level_description_ar">@lang('academics.level_description_ar')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text"
                                            name="description_ar" id="update_level_description_ar" autocomplete="off">
                                    </div>

                                    <!-- File Upload -->
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="update_level_file">@lang('common.material')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="update_level_file"
                                                name="file">
                                            <label class="custom-file-label" for="update_level_file">@lang('common.choose_material')</label>
                                        </div>
                                        <small class="form-text text-muted">@lang('common.current_material'): <span id="current_file_name">No
                                            @lang('common.material_upload')</span></small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" id="update_level_for_submit"
                                        class="primary-btn fix-gr-bg text-nowrap">Update changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </section>


    <section>

        @include('backEnd.academics.track_levels.track_card')
    </section>
@endsection

<style>
    .btnSelect {
        border-radius: 50%;
        display: flex;
        align-items: center;
    }

    .btnSelect .circular-btn {
        border-radius: 50%;
        padding: 16px 17px;

    }

    .btnSelect .fa {
        padding: 15px;
    }

    .circular-btn {

        background-color: #3f4d8f;
        border: none;
        color: #fff;
    }

    .circular-btn:hover {
        background-color: #212c60;
    }

    .input-level {
        padding: 8px 12px;
        border-radius: 4px;
        background: #fff;
        box-shadow: 0px 4px 20px rgba(39, 32, 120, 0.1)
    }

    .level-btn {
        background: none;
        border: none;
    }

    .level-btn:hover {
        color: #007bff;
    }
</style>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#add_level_btn').click(function(event) {
                event.preventDefault();
                $('#add_level').toggle();
                if ($('#add_level').is(':visible')) {
                    $(this).html('<i class="fas fa-times " style="color: #fff"></i>');
                } else {
                    $(this).html('<i class="fas fa-plus " style="color: #fff"></i>');
                }
            });
            $('#level_modal_btn').click(function(event) {
                event.preventDefault();
                $('#exampleModal').modal('show');
            });


        });
    </script>
@endpush
@include('backEnd.partials.data_table_js')
