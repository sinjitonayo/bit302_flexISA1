@push('styles')
@endpush
@push('modals')
    <div class="modal fade" id="modal-add_daily_schedule">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Submit Daily Schedule</h4>
                    <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-add_daily_schedule" action="">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input class="form-control" id="date" name="date" type="text" placeholder="Date" readonly value="@if(isset($choosen_date)) {{$choosen_date}} @endif">
                        </div>
                        <div class="form-group">
                            <label for="work_location">Work Location</label>
                            <input class="form-control" id="work_location" name="work_location" type="text" placeholder="Work location">
                        </div>
                        <div class="form-group">
                            <label for="position">Work Hours</label>
                            <select name="work_hours" class="custom-select form-control-border" id="exampleSelectBorder">
                                <option value="" selected>Choose Work Hours</option>
                                <option value="8am - 4pm">8am - 4pm</option>
                                <option value="9am - 5pm">9am - 5pm</option>
                                <option value="10am - 6pm">10am - 6pm</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="work_report">Work Report</label>
                            <input class="form-control" id="work_report" name="work_report" type="text" placeholder="Work Report">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                    <button class="btn btn-primary" id="add_btn" type="button" onclick="submitDailySchedule()">Submit Daily Schedule</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endpush
@push('scripts')
    <script>
        function showSubmitDailySchedule() {
            $('#modal-add_daily_schedule').modal('show');
        }

        function submitDailySchedule() {
            let original_btn_text = $('#add_btn').html();
            $('#add_btn').html('<i class="fa fa-spinner mr-1"></i>');
            $('#add_btn').attr('disabled', true);
            var formData = new FormData($('#form-add_daily_schedule')[0]);
            $.ajax({
                url: '/ajax/daily-schedule/save',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                accept: "application/json;",
                success: function(result) {
                    if (result.success) {
                        showToast('success', 'Berhasil', result.message);
                        $('#modal-add_daily_schedule').modal('hide');
                        $('#form-add_daily_schedule')[0].reset();
                        window.location.reload();
                    } else {
                        showToast('danger', 'Gagal', result.message);
                    }
                },
                complete: function() {
                    $('#add_btn').html(original_btn_text);
                    $('#add_btn').attr('disabled', false);
                }
            });
        }
    </script>
@endpush
