<div class="col-md-12 mb-20">
    <div id="slotContainer"></div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Show day field based on schedule selection
        $('#scheduled').on('change', function() {
            var schedule = $(this).val();
            var slotContainer = $('#slotContainer');
            slotContainer.empty();

            if (schedule === 'once') {
                slotContainer.html(`
                    <div class="row" id="once_schedule">
                        <div class="col-md-4">
                            <label class="primary_input_label">@lang('common.select_day')</label>
                            <select class="form-control" name="day_1" id="day_1">
                                <option value="">@lang('common.select_day')</option>
                                <option value="Sunday">@lang('common.sunday')</option>
                                <option value="Monday">@lang('common.monday')</option>
                                <option value="Tuesday">@lang('common.tuesday')</option>
                                <option value="Wednesday">@lang('common.wednesday')</option>
                                <option value="Thursday">@lang('common.thursday')</option>
                                <option value="Friday">@lang('common.friday')</option>
                                <option value="Saturday">@lang('common.saturday')</option>
                            </select>
                        </div>
                        <div class="col-md-4" id="start_time_container_1"></div>
                        <div class="col-md-4" id="end_time_container_1"></div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-2">
                            <h5>@lang('academics.available_teachers')</h5>
                        </div>
                        <div class="col-1">
                            <i class="fas fa-circle" style="color: #FFD43B;"></i> @lang('academics.available')
                        </div>
                        <div class="col-1">
                            <i class="fas fa-circle" style="color: #f6c49c;"></i> @lang('academics.paid')
                        </div>
                        <div class="col-1">
                            <i class="fas fa-circle" style="color: #ff3c3c;"></i> @lang('academics.unpaid')
                        </div>
                    </div>

                    <div id="teachers_table" class="mt-3"></div>
                `);
            } else if (schedule === 'twice') {
                slotContainer.html(`
                    <div class="row mb-3" id="twice_schedule_1">
                        <div class="col-md-4">
                            <label class="primary_input_label">@lang('common.select_day')</label>
                            <select class="form-control" name="day_1" id="day_1">
                                <option value="">@lang('common.select_day')</option>
                                <option value="Sunday">@lang('common.sunday')</option>
                                <option value="Monday">@lang('common.monday')</option>
                                <option value="Tuesday">@lang('common.tuesday')</option>
                                <option value="Wednesday">@lang('common.wednesday')</option>
                                <option value="Thursday">@lang('common.thursday')</option>
                                <option value="Friday">@lang('common.friday')</option>
                                <option value="Saturday">@lang('common.saturday')</option>
                            </select>
                        </div>
                        <div class="col-md-4" id="start_time_container_1"></div>
                        <div class="col-md-4" id="end_time_container_1"></div>
                    </div>
                    <div class="row" id="twice_schedule_2">
                        <div class="col-md-4">
                            <label class="primary_input_label">@lang('common.select_day')</label>
                            <select class="form-control" name="day_2" id="day_2">
                                <option value="">@lang('common.select_day')</option>
                                <option value="Sunday">@lang('common.sunday')</option>
                                <option value="Monday">@lang('common.monday')</option>
                                <option value="Tuesday">@lang('common.tuesday')</option>
                                <option value="Wednesday">@lang('common.wednesday')</option>
                                <option value="Thursday">@lang('common.thursday')</option>
                                <option value="Friday">@lang('common.friday')</option>
                                <option value="Saturday">@lang('common.saturday')</option>
                            </select>
                        </div>
                        <div class="col-md-4" id="start_time_container_2"></div>
                        <div class="col-md-4" id="end_time_container_2"></div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-2">
                            <h5>@lang('academics.available_teachers')</h5>
                        </div>
                        <div class="col-1">
                            <i class="fas fa-circle" style="color: #FFD43B;"></i> @lang('academics.available')
                        </div>
                        <div class="col-1">
                            <i class="fas fa-circle" style="color: #f6c49c;"></i> @lang('academics.paid')
                        </div>
                        <div class="col-1">
                            <i class="fas fa-circle" style="color: #ff3c3c;"></i> @lang('academics.unpaid')
                        </div>
                    </div>
                    <div id="teachers_table" class="mt-3 table-container"></div>
                `);
            }
        });
    });
</script>
@endpush