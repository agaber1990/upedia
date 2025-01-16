@extends('backEnd.master')
@section('title')
    @lang('academics.track_session')
@endsection
{{-- {{ dd($track, $sessions) }} --}}
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('academics.track_session')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('academics.academics')</a>
                    <a href="#">@lang('academics.track_session')</a>
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

                            <button id="add_session_btn" class="circular-btn mx-2" aria-label="Toggle new session form">
                                <i class="fas fa-plus" style="color: #fff"></i>
                            </button>
                        </div>
                        <div id="add_session" class="input-session" style="display: none;width:100%">
                            <button id="session_modal_btn" class="session-btn">
                                <i class="fas fa-plus" style="color: #000000"></i> Session
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
                                <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('academics.add_session')</h1>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">

                                <div class="primary_input">
                                    <label class="primary_input_label" for="session_name_en">@lang('academics.session_name_en')
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input class="primary_input_field form-control" type="text" name="session_name_en"
                                        id="session_name_en" autocomplete="off">
                                    <input type="hidden" id="track_id" name="track_id" value="{{ $track->id }}">
                                </div>
                                <div class="primary_input">
                                    <label class="primary_input_label" for="session_name_ar">@lang('academics.session_name_ar')
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input class="primary_input_field form-control" type="text" id="session_name_ar"
                                        name="session_name_ar" autocomplete="off">
                                    <input type="hidden" id="track_id" name="track_id" value="{{ $track->id }}">
                                </div>

                            </div>
                            <div class="modal-footer">

                                <button type="button" id="add_session_for_submit"
                                    class="primary-btn fix-gr-bg text-nowrap">Save changes</button>
                            </div>
                        </div>
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

        background-color: #007bff;
        border: none;
        color: #fff;
    }

    .circular-btn:hover {
        background-color: #0056b3;
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
            $('#add_session_btn').click(function(event) {
                event.preventDefault();
                $('#add_session').toggle();
                if ($('#add_session').is(':visible')) {
                    $(this).html('<i class="fas fa-times " style="color: #fff"></i>');
                } else {
                    $(this).html('<i class="fas fa-plus " style="color: #fff"></i>');
                }
            });
            $('#session_modal_btn').click(function(event) {
                event.preventDefault();
                $('#exampleModal').modal('show');
            });
            $('#add_session_for_submit').click(function(event) {
                event.preventDefault();
                // Submit input to db
                let formData = {
                    session_name_en: $('#session_name_en').val(),
                    session_name_ar: $('#session_name_ar').val(),
                    track_id: $('#track_id').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: "{{ route('track_sessions_store') }}",
                    method: "POST",
                    data: formData,
                    success: function(res) {
                        // Show SweetAlert confirmation
                        $('#exampleModal').modal('hide');

                        Swal.fire({
                            title: 'Success!',
                            text: 'Session has been successfully added.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });

                        $('#session_name_en').val('')
                        $('#session_name_ar').val('')
                    },
                    error: function(xhr, status, error) {
                        $('#exampleModal').modal('hide');

                        Swal.fire({
                            title: 'Error!',
                            text: 'Sorry! you can\'t add more sessions.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });


        });
    </script>
@endpush
@include('backEnd.partials.data_table_js')
