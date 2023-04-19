@extends('employee.master', [
    'page_title' => 'Dashboard',
])
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if ($role == 'supervisor')
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>1</h3>
                                    <p>Supervised Employee</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person"></i>
                                </div>
                                <a class="small-box-footer" href="/manage/customer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>1</h3>
                                    <p>Today's Schedules</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a class="small-box-footer" href="/manage/news">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>1</h3>
                                    <p>FWA Requests</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-chatbox"></i>
                                </div>
                                <a class="small-box-footer" href="/manage/message">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title m-0">Flexible Work Arrangement</h5>
                            </div>
                            <div class="card-body">
                                @if ($fwa_request)
                                    <p class="card-text">
                                        <b>Request date</b> {{ $fwa_request->request_date }} <br>
                                        <b>Work Type</b> {{ $fwa_request->work_type }} <br>
                                        <b>Description</b> {{ $fwa_request->description }} <br>
                                        <b>Reason</b> {{ $fwa_request->reason }} <br>
                                        <b>Status</b> {{ $fwa_request->status }} <br>
                                        <b>Comment</b> {{ $fwa_request->comment ?? '-' }} <br>
                                    </p>
                                @else
                                    <p class="card-text">You have no active request currently submited</p>
                                @endif
                                @if (!$fwa_request || $fwa_request->status == 'pending' || $fwa_request->status == 'rejected')
                                    <a class="btn btn-primary" href="#" @if (!$fwa_request) onclick="showSubmitFWA()" @else onclick="showToast('warning', 'Gagal', 'Please wait for review to submit new request!')" @endif>New Request</a>
                                    <a class="btn btn-secondary" href="#">History</a>
                                @endif

                            </div>
                        </div>
                @endif
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-7 connectedSortable">

                    </section>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@include('employee.fwa-request.submit-modal')

