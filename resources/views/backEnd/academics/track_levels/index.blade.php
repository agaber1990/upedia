@extends('backEnd.master')
@section('title')
    @lang('academics.track_level')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('academics.track_level')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('academics.academics')</a>
                    <a href="#">@lang('academics.track_level')</a>
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
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('academics.add_level')</h1>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">

                                <div class="primary_input">
                                    <label class="primary_input_label" for="level_id">
                                        @lang('common.select_student') <span class="text-danger"> *</span>
                                    </label>
                                    <select class="primary_select form-control" name="level_id" id="level_id">
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}">
                                                {{ $level->level_number }}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="primary_input">

                                    <label class="primary_input_label" for="level_name_en">@lang('academics.level_name_en')
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input class="primary_input_field form-control" type="text" name="level_name_en"
                                        id="level_name_en" autocomplete="off">
                                    <input type="hidden" id="track_id" name="track_id" value="{{ $track->id }}">
                                </div>
                                <div class="primary_input">
                                    <label class="primary_input_label" for="level_name_ar">@lang('academics.level_name_ar')
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input class="primary_input_field form-control" type="text" id="level_name_ar"
                                        name="level_name_ar" autocomplete="off">
                                    <input type="hidden" id="track_id" name="track_id" value="{{ $track->id }}">
                                </div>

                            </div>
                            <div class="modal-footer">

                                <button type="button" id="add_level_for_submit" class="primary-btn fix-gr-bg text-nowrap">
                                    @lang('common.save_changes')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal update -->
                <div class="modal fade" id="ModalUpdateLevel" tabindex="-1" aria-labelledby="ModalLabelUpdateLevel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="ModalLabelUpdateLevel">@lang('academics.update_level')</h1>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">

                                <div class="primary_input">
                                    <label class="primary_input_label" for="update_level_id">
                                        @lang('common.select_student') <span class="text-danger"> *</span>
                                    </label>
                                    <select class="primary_select form-control" name="level_id" id="update_level_id">
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}">
                                                {{ $level->level_number }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="primary_input">
                                    <label class="primary_input_label" for="update_level_name_en">@lang('academics.level_name_en')
                                        <span class="text-danger"> *</span></label>
                                    <input class="primary_input_field form-control" type="text" name="level_name_en"
                                        id="update_level_name_en" autocomplete="off">
                                </div>
                                <div class="primary_input">
                                    <label class="primary_input_label" for="update_level_name_ar">@lang('academics.level_name_ar')
                                        <span class="text-danger"> *</span></label>
                                    <input class="primary_input_field form-control" type="text" name="level_name_ar"
                                        id="update_level_name_ar" autocomplete="off">
                                </div>
                                <input type="hidden" id="update_level_track_id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="update_level_for_submit"
                                    class="primary-btn fix-gr-bg text-nowrap">Update changes</button>
                            </div>
                        </div>
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
            $('#add_level_for_submit').click(function(event) {
                event.preventDefault();
                let formData = {
                    level_name_en: $('#level_name_en').val(),
                    level_name_ar: $('#level_name_ar').val(),
                    level_id: $('#level_id').val(),
                    track_id: $('#track_id').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: "{{ route('track_levels_store') }}",
                    method: "POST",
                    data: formData,

                    success: function(response) {
                        $('#level_name_en').val('')
                        $('#level_name_ar').val('')
                        $('#level_id').val('')
                        $('#exampleModal').modal('hide');
                        window.location.reload()

                    },

                    error: function(xhr, status, error) {
                        $('#exampleModal').modal('hide');

                        Swal.fire({
                            title: 'Error!',
                            text: 'Sorry! you can\'t add more levels.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });


            $(document).ready(function() {
                $('#update_level_for_submit').click(function(event) {
                    event.preventDefault();
                    const levelId = $('#update_level_track_id').val();

                    const data = {
                        level_name_en: $('#update_level_name_en').val(),
                        level_name_ar: $('#update_level_name_ar').val(),
                        level_id: $('#update_level_id').val(),
                        track_id: $('#track_id').val(),
                        _token: '{{ csrf_token() }}'
                    };


                    $.ajax({
                        url: `/track_levels/${levelId}`,
                        method: "PUT",
                        data: data,
                        // success: function(res) {
                        //     $('#ModalUpdateLevel').modal('hide');
                        //     Swal.fire({
                        //         title: 'Success!',
                        //         text: 'Level has been successfully updated.',
                        //         icon: 'success',
                        //         confirmButtonText: 'OK'
                        //     });
                        // },

                        success: function(response) {
                            $('#ModalUpdateLevel').modal('hide');
                            window.location.reload()


                        },
                        error: function(xhr, status, error) {
                            $('#ModalUpdateLevel').modal('hide');
                            Swal.fire({
                                title: 'Error!',
                                text: 'Sorry! You can\'t update the level.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            console.error('Error:', error);
                        }
                    });
                });
            });
        });
    </script>
@endpush
@include('backEnd.partials.data_table_js')
