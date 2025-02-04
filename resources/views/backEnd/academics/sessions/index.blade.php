@extends('backEnd.master')
@section('title')
    @lang('academics.sessions')
@endsection

{{-- {{dd($menus)}} --}}
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('academics.track_session')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a>@lang('academics.academics')</a>
                    <a href="{{ route('tracks') }}">@lang('academics.track')</a>
                    <a href="{{ route('track_levels', ['track_id' => $track->id]) }}">@lang('academics.levels')</a>
                    <a>@lang('common.session')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor up_st_admin_visitor pl_22">
        <div class="container-fluid p-0">
            @if (isset($discountPlan))
                @if (userPermission('track_sessions-store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ route('track_sessions') }}" class="primary-btn small fix-gr-bg">
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

                            <button id="add_btn" class="circular-btn mx-2" aria-label="Toggle new session form">
                                <i class="fas fa-plus" style="color: #fff"></i>
                            </button>
                        </div>
                        <div id="add_session" class="input-session" style="display: none;width:100%">
                            <button id="modal_btn" class="session-btn">
                                <i class="fas fa-plus" style="color: #000000"></i> @lang('academics.session')
                            </button>
                        </div>
                    </div>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('track_levels_sessions_store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf


                            <div class="modal-content">

                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('academics.add_session')</h1>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <input type="hidden" id="track_id" name="track_id" value="{{ $track->id }}">
                                    <input type="hidden" id="level_id" name="level_id" value="{{ $level->id }}">


                                    <div class="primary_input">
                                        <label class="primary_input_label" for="name_en">@lang('academics.name_en')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text" name="name_en"
                                            id="name_en" autocomplete="off">
                                    </div>

                                    <div class="primary_input">
                                        <label class="primary_input_label" for="name_ar">@lang('academics.name_ar')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text" id="name_ar"
                                            name="name_ar" autocomplete="off">
                                    </div>
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="description_en">@lang('academics.description_en')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text" name="description_en"
                                            id="description_en" autocomplete="off">
                                    </div>

                                    <div class="primary_input">
                                        <label class="primary_input_label" for="description_ar">@lang('academics.description_ar')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text" id="description_ar"
                                            name="description_ar" autocomplete="off">
                                    </div>

                                    <div class="primary_input">
                                        <label class="primary_input_label" for="file">@lang('common.material')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" id="file" type="file"
                                            multiple id="file" name="file[]" autocomplete="off">
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



                <!-- Modal Update -->
                <div class="modal fade" id="ModalUpdateSession" tabindex="-1" aria-labelledby="ModalLabelUpdateSession"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('track_levels_sessions_update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="ModalLabelUpdateSession">@lang('academics.update_session')</h1>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="update_track_id" name="track_id">
                                    <input type="hidden" id="update_level_id" name="level_id">
                                    <input type="hidden" id="update_session_id" name="id">

                                    <div class="primary_input">
                                        <label class="primary_input_label" for="update_name_en">@lang('academics.name_en')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text" name="name_en"
                                            id="update_name_en" autocomplete="off">
                                    </div>

                                    <div class="primary_input">
                                        <label class="primary_input_label" for="update_name_ar">@lang('academics.name_ar')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text" name="name_ar"
                                            id="update_name_ar" autocomplete="off">
                                    </div>

                                    <div class="primary_input">
                                        <label class="primary_input_label" for="update_description_en">@lang('academics.description_en')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text"
                                            name="description_en" id="update_description_en" autocomplete="off">
                                    </div>

                                    <div class="primary_input">
                                        <label class="primary_input_label" for="update_description_ar">@lang('academics.description_ar')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="text"
                                            name="description_ar" id="update_description_ar" autocomplete="off">
                                    </div>

                                    <!-- Display existing files -->
                                    <div class="primary_input">
                                        <label class="primary_input_label">@lang('common.existing_materials')</label>
                                        <div id="existing_files">
                                            <!-- Files will be dynamically added here -->
                                        </div>
                                    </div>

                                    <div class="primary_input">
                                        <label class="primary_input_label" for="update_file">@lang('common.material')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input class="primary_input_field form-control" type="file" name="file[]"
                                            id="update_file" multiple autocomplete="off">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit"
                                        class="primary-btn fix-gr-bg text-nowrap">@lang('common.update')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section>

        @include('backEnd.academics.sessions.session_card')
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

    .input-session {
        padding: 8px 12px;
        border-radius: 4px;
        background: #fff;
        box-shadow: 0px 4px 20px rgba(39, 32, 120, 0.1)
    }

    .session-btn {
        background: none;
        border: none;
    }

    .session-btn:hover {
        color: #007bff;
    }
</style>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#add_btn').click(function(event) {
                event.preventDefault();
                event.stopPropagation();
                $('#add_session').toggle();
                if ($('#add_session').is(':visible')) {
                    $(this).html('<i class="fas fa-times" style="color: #fff"></i>');
                } else {
                    $(this).html('<i class="fas fa-plus" style="color: #fff"></i>');
                }
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('#add_session').length && !$(event.target).closest(
                        '#add_btn').length) {
                    $('#add_session').hide();
                    $('#add_btn').html('<i class="fas fa-plus" style="color: #fff"></i>');
                }
            });

            $('#modal_btn').click(function(event) {
                event.preventDefault();
                $('#exampleModal').modal('show');
            });
        });
    </script>
@endpush
@include('backEnd.partials.data_table_js')
