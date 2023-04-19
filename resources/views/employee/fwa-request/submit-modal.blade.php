@push('styles')
@endpush
@push('modals')
    <div class="modal fade" id="modal-add_fwa_request">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Submit FWA Request</h4>
                    <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-add_fwa_request" action="">
                        <div class="form-group">
                            <label for="position">Work Type</label>
                            <select name="work_type" class="custom-select form-control-border" id="exampleSelectBorder">
                                <option value="" selected>Choose work type (if any)</option>
                                <option value="flexi-hour">Flexi Hours</option>
                                <option value="work-from-home">Work From Home</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input class="form-control" id="description" name="description" type="text" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason</label>
                            <input class="form-control" id="reason" name="reason" type="text" placeholder="Reason">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                    <button class="btn btn-primary" id="add_btn" type="button" onclick="submitFWARequest()">Submit FWARequest</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endpush
@push('scripts')
    <script>
        function showSubmitFWA() {
            $('#modal-add_fwa_request').modal('show');
        }

        function submitFWARequest() {
            let original_btn_text = $('#add_btn').html();
            $('#add_btn').html('<i class="fa fa-spinner mr-1"></i>');
            $('#add_btn').attr('disabled', true);
            var formData = new FormData($('#form-add_fwa_request')[0]);
            $.ajax({
                url: '/ajax/fwa-request/submit',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                accept: "application/json;",
                success: function(result) {
                    if (result.success) {
                        showToast('success', 'Berhasil', result.message);
                        $('#modal-add_fwa_request').modal('hide');
                        $('#form-add_fwa_request')[0].reset();
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
