@push('styles')
@endpush
@push('modals')
    <div class="modal fade" id="modal-add_employee">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Register Employee</h4>
                    <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-add_employee" action="">
                        <div class="form-group">
                            <label for="employee_id">Employee ID</label>
                            <input class="form-control" id="employee_id" name="employee_id" type="text" placeholder="Employee ID">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" id="password" name="password" type="text" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" id="email" name="email" type="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="position">Position</label>
                            <input class="form-control" id="position" name="position" type="text" placeholder="Position">
                        </div>
                        <div class="form-group">
                            <label for="supervisor_employee_id">Supervisor</label>
                            <select name="supervisor_employee_id" class="custom-select form-control-border" id="supervisor_employee_id">
                                <option value="" selected>Choose supervisor (if any)</option>
                                @foreach ($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="position">Department</label>
                            <select name="department_id" class="custom-select form-control-border" id="exampleSelectBorder">
                                <option value="" selected disabled>Choose department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                    <button class="btn btn-primary" id="add_btn" type="button" onclick="addEmployee()">Register Employee</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endpush
@push('scripts')
    <script>
        function showAdd() {
            $('#modal-add_employee').modal('show');
        }

        function addEmployee() {
            let original_btn_text = $('#add_btn').html();
            $('#add_btn').html('<i class="fa fa-spinner mr-1"></i>');
            $('#add_btn').attr('disabled', true);
            var formData = new FormData($('#form-add_employee')[0]);
            $.ajax({
                url: '/admin/ajax/employee/register',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                accept: "application/json;",
                success: function(result) {
                    if (result.success) {
                        showToast('success', 'Berhasil', result.message);
                        $('#modal-add_employee').modal('hide');
                        $('#form-add_employee')[0].reset();
                        window.location.reload();
                        if (afterAddCallback) afterAddCallback();
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
