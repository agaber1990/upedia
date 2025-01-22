@extends('backEnd.master')
@section('title')
    @lang('academics.pricing_plan')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('academics.dashboard')</a>
                    <a href="#">@lang('academics.academics')</a>
                    <a href="#">@lang('academics.pricing_plan')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">


            <div class="row">
                <!-- Form Section -->

                <!-- Track List Section -->
                <div class="col-md-8">
                    <div class="white-box">
                        <div class="main-title">
                            <h3 class="mb-15">@lang('academics.pricing_plan')</h3>
                        </div>
                        <form action="{{ route('track-pricing-plan.store', ['id' => $track->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="track_id" value="{{ $track->id }}">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="title-td" style="width: 160px">{{ __('common.pricing_plan_type') }}</th>
                                        @foreach ($tracktypes as $item)
                                            <th><span class="title-td">{{ $item->name }}</span></th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pricing_plan_types as $plan)
                                        <tr>
                                            <td><span class="title-td">{{ $plan->name }}</span></td>
                                            @foreach ($tracktypes as $tracktype)
                                                <td>
                                                    <input type="text"
                                                        name="pricing[{{ $plan->id }}][{{ $tracktype->id }}]"
                                                        class="form-control price-input"
                                                        value="{{ $pricing_data[$plan->id][$tracktype->id] ?? '' }}">
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div id="submit-button">
                                <button type="submit" class="btn btn-success">Add <i class="fa fa-plus"></i></button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="main-title">
                        <h3 class="mb-15">@lang('academics.discount_plan')</h3>
                    </div>
                    <div class="primary_input">
                        <label class="primary_input_label" for="">@lang('academics.discount_plan')
                        </label>
                        <select class="primary_select  form-control{{ $errors->has('discount_plan') ? ' is-invalid' : '' }}"
                            name="discount_plan" id="discount_plan">
                            @foreach ($discount_plans as $plan)
                                <option value="{{ $plan->id }}" {{ $plan->id }}>
                                    {{ $plan->name_en }}
                                </option>
                            @endforeach
                        </select>

                        @if ($errors->has('discount_plan'))
                            <span class="text-danger invalid-select" role="alert">
                                {{ $errors->first('discount_plan') }}
                            </span>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
<style>
    .table tbody td {
        padding: 10px !important;
    }

    .title-td,
    .title-th,
    .form-control {
        font-size: 13px !important;
        color: #53639b !important;
    }
</style>




@push('scripts')
    <script>
        $(document).ready(function() {
            function checkInputValues() {
                let hasValue = false;
                $('.price-input').each(function() {
                    const value = $(this).val().trim();
                    if (value !== '') {
                        hasValue = true;
                        return false;
                    }
                });
                if (hasValue) {
                    $('#submit-button').html(
                        "<button type='submit' class='btn btn-danger'>Update</button>"
                    );
                } else {
                    $('#submit-button').html(
                        "<button type='submit' class='btn btn-success'>Add</button>"
                    );
                }
            }
            checkInputValues();
        });
    </script>
@endpush
