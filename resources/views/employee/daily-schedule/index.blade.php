@extends('employee.master', [
    'page_title' => '>Daily Schedule',
])
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Daily Schedule</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">>Daily Schedule</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="col-lg-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h5 class="card-title m-0">Update Work Schedule</h5>
                        </div>
                        <div class="card-body">
                            <form action="/manage/daily-schedule" method="GET">
                                <div class="form-group col-xl-4">
                                    <label for="position">Week Date</label>
                                    <select onchange="this.form.submit()" class="custom-select form-control-border" id="exampleSelectBorder" name="date">
                                        <option value="" selected>Choose Date</option>
                                        @foreach ($week_dates as $date)
                                            <option value="{{ $date }}" @if (isset($choosen_date) && $choosen_date == $date) selected @endif>{{ $date }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                            <hr>
                            <h5>Daily Schedule Detail</h5>
                            @if (isset($choosen_schedule))
                                <p class="card-text">
                                    <b>Date</b> {{ $choosen_schedule->date }} <br>
                                    <b>Work Location</b> {{ $choosen_schedule->work_location }} <br>
                                    <b>Work Hours</b> {{ $choosen_schedule->work_hours }} <br>
                                    <b>Work Report</b> {{ $choosen_schedule->work_report }} <br>
                                    <b>Supervisor Comment</b> {{ $choosen_schedule->supervisor_comments ?? '-' }} <br>
                                </p>
                            @else
                                <p class="card-text">No Schedule for choosen date</p>
                            @endif
                            <a class="btn btn-info" href="#" @if (isset($choosen_date)) onclick="showSubmitDailySchedule()" @else onclick="showToast('warning', 'Gagal', 'Please choose date and check schedule first!')" @endif>Update Daily Schedule</a>
                            <a class="btn btn-secondary" href="/manage/daily-schedule">View All</a>

                        </div>
                    </div>
                    <h5>This Week Schedule</h5>
                    @if ($daily_schedules->count() < 1)
                        There is no schedule found
                    @endif
                    @foreach ($daily_schedules as $daily_schedule)
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h5 class="card-title m-0">{{ $daily_schedule->date }} Work Schedule</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <b>Work Location</b> {{ $daily_schedule->work_location }} <br>
                                    <b>Work Hours</b> {{ $daily_schedule->work_hours }} <br>
                                    <b>Work Report</b> {{ $daily_schedule->work_report }} <br>
                                    <b>Supervisor Comment</b> {{ $daily_schedule->supervisor_comments ?? '-' }} <br>
                                </p>
                            </div>
                        </div>
                    @endforeach

                </div>
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
@include('employee.daily-schedule.submit-modal',[
    "choosen_date" => isset($choosen_date)? $choosen_date : NULL
])
