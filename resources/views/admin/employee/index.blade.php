@extends('admin.master',[
    "page_title"=>"Manage Employee"
])
@section('style')
    <!-- summernote -->
    <link href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet">
    <!-- SimpleMDE -->
    <link href="{{ asset('plugins/simplemde/simplemde.min.css') }}" rel="stylesheet">
    <!-- DataTables -->
    <link href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Manage Employees</h1>
                        
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Manage Employees</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex">
                                <h3 class="card-title">Employees</h3>
                                <button type="button" class="btn btn-primary ml-auto" onclick="showAdd()"><i class="fa fa-plus mr-1"></i>Add Employee</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped" id="employee-table">
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Position</th>
                                            <th>FWA Status</th>
                                            <th>Supervisor</th>
                                            <th>Department</th>
                                        </tr>
                                    </thead>

                                    <tfoot>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Position</th>
                                            <th>FWA Status</th>
                                            <th>Supervisor</th>
                                            <th>Department</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('script')
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        function deleteEmployee(id){
            if(!confirm('Apakah anda yakin untuk menghapus produk secara permanen?')) return;
            let original_btn_text = $('#delete_btn_'+id).html();
            $('#delete_btn_'+id).html('<i class="fa fa-spinner mr-1"></i>');
            $('#delete_btn_'+id).attr('disabled', true);
            $.ajax({
                url: '/ajax/employee/'+id+'/delete',
                type: "POST",
                accept: "application/json;",
                success: function(result) {
                    if (result.success) {
                        showToast('success', 'Berhasil', result.message);
                        refreshTable();
                    } else {
                        showToast('danger', 'Gagal', result.message);
                    }
                },
                complete: function() {
                    $('#delete_btn_'+id).html(original_btn_text);
                    $('#delete_btn_'+id).attr('disabled', false);
                }
            });
        }
        //DATATABLE
        $(function() {
            $("#employee-table").DataTable({
                serverSide: true,
                processing: true,
                ajax: '/admin/ajax/employees',
                columns: [
                    {
                        data: 'employee_id',
                        name: 'employee_id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'position',
                        name: 'position'
                    },
                    {
                        data: 'fwa_status',
                        name: 'fwa_status'
                    },
                    {
                        data: 'supervisor',
                        name: 'supervisor.name',
                        sortable:false,
                        // searchable:false
                    },
                    {
                        data: 'department',
                        name: 'department.department_name',
                        sortable:false,
                        // searchable:false

                    },
                    // {
                    //     data: null,
                    //     render: function(data, type, row) {
                    //         return  '<div class="d-flex">' +
                    //                     // '<button id="detail_btn_'+row.id+'" onclick="showDetail('+row.id+')" type="button" class="btn btn-info mr-1">View</button>' + 
                    //                     // '<button id="edit_btn_'+row.id+'" onclick="showEdit('+row.id+')" type="button" class="btn btn-primary mr-1">Edit</button>' + 
                    //                     '<button id="delete_btn_'+row.id+'" onclick="deleteEmployee('+row.id+')" type="button" class="btn btn-danger">Delete</button>'+
                    //                 '</div>'
                    //     }
                    // }
                ],

            });
        });
        function refreshTable(){
            $('#employee-table').DataTable().ajax.reload();
        }

        // CALLBACK
        function afterAddCallback(){
            refreshTable();
        }
    </script>
@endsection
@include('admin.employee.add-modal',[
    "supervisors"=>$supervisors,
    "departments"=>$departments
])
