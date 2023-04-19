<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FWARequest;
use App\Models\DailySchedule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmployeeGeneralController extends Controller
{
    public function dashboard(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $choosen_date = NULL;
        $choosen_schedule = NULL;
        $now = Carbon::now();
        $week_dates = [
            $now->startOfWeek(Carbon::MONDAY)->format('Y-m-d'),
            $now
                ->startOfWeek(Carbon::MONDAY)
                ->addDays(1)
                ->format('Y-m-d'),
            $now
                ->startOfWeek(Carbon::MONDAY)
                ->addDays(2)
                ->format('Y-m-d'),
            $now
                ->startOfWeek(Carbon::MONDAY)
                ->addDays(3)
                ->format('Y-m-d'),
            $now
                ->startOfWeek(Carbon::MONDAY)
                ->addDays(4)
                ->format('Y-m-d'),
            $now
                ->startOfWeek(Carbon::MONDAY)
                ->addDays(5)
                ->format('Y-m-d'),
        ];
        if($request->has('date')){
            $choosen_date = $request->input('date');
            $choosen_schedule = $employee->daily_schedules()->where('date',$choosen_date)->first();
        }

        return view('employee.dashboard', [
            'choosen_date' => $choosen_date,
            'choosen_schedule'=> $choosen_schedule,
            'week_dates'=>$week_dates,
            'fwa_request' => $employee
                ->fwa_requests()
                ->where('status', '!=', 'rejected')
                ->orderBy('request_date', 'DESC')
                ->first(),
            'role' => $employee->role(),
        ]);
    }
    public function ajaxFWARequests(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $employee->fwa_requests,
        ]);
    }
    public function ajaxSubmitFWARequest(Request $request)
    {
        $data = $request->validate([
            'work_type' => 'required|in:flexi-hour,work-from-home,hybrid',
            'description' => 'required',
            'reason' => 'required',
        ]);
        $data['request_id'] = rand(1000, 9999) . '';
        $data['request_date'] = \Carbon\Carbon::now();
        $data['status'] = 'pending';
        $data['employee_id'] = Auth::guard('employee')->id();
        $fwa_request = FWARequest::create($data);
        Auth::guard('employee')
            ->user()
            ->supervisor->notify(new \App\Notifications\PendingFWARequest());
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $fwa_request,
        ]);
    }

    public function manageDailySchedule(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $choosen_date = NULL;
        $choosen_schedule = NULL;
        if($request->has('date')){
            $choosen_date = $request->input('date');
            $choosen_schedule = $employee->daily_schedules()->where('date',$choosen_date)->first();
        }
        
        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $weekEndDate = $now->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');
        $week_dates = [
            $now->startOfWeek(Carbon::MONDAY)->format('Y-m-d'),
            $now
                ->startOfWeek(Carbon::MONDAY)
                ->addDays(1)
                ->format('Y-m-d'),
            $now
                ->startOfWeek(Carbon::MONDAY)
                ->addDays(2)
                ->format('Y-m-d'),
            $now
                ->startOfWeek(Carbon::MONDAY)
                ->addDays(3)
                ->format('Y-m-d'),
            $now
                ->startOfWeek(Carbon::MONDAY)
                ->addDays(4)
                ->format('Y-m-d'),
            $now
                ->startOfWeek(Carbon::MONDAY)
                ->addDays(5)
                ->format('Y-m-d'),
        ];
        $daily_schedules = $employee->daily_schedules()->orderBy('date','ASC')->where('date', '>=', $weekStartDate)
            ->where('date', '<=', $weekEndDate)
            ->get()
            ->keyBy('date');
        return view('employee.daily-schedule.index', [
            'choosen_date' => $choosen_date,
            'choosen_schedule'=> $choosen_schedule,
            'week_dates' => $week_dates,
            'daily_schedules' => $daily_schedules,
            'weekEndDate' => $weekEndDate,
            'now' => $now->format('Y-m-d'),
            'today_schedule' => $employee
                ->daily_schedules()
                ->where('date', Carbon::now()->format('Y-m-d'))
                ->first(),
        ]);
    }
    public function ajaxDailySchedule(DailySchedule $daily_schedule, Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $fwa_request,
            'html' => view('employee.daily-schedule.edit-component')->render(),
        ]);
    }
    public function ajaxSaveDailySchedule(Request $request)
    {
        $data = $request->validate([
            'date'=>'required',
            'work_location' => 'required',
            'work_hours' => 'required',
            'work_report' => 'required',
        ]);
        $data['employee_id'] = Auth::guard('employee')->id();
        $fwa_request = DailySchedule::updateOrCreate(
            [
                'date' => $data['date'],
                'employee_id' => $data['employee_id'],
            ],
            [
                'work_location' => $data['work_location'],
                'work_hours' => $data['work_hours'],
                'work_report' => $data['work_report'],
            ],
        );
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $fwa_request,
        ]);
    }

    // SUPERVISORS
    public function reviewFWARequest()
    {
    }
    public function ajaxReviewFWARequests(Request $request)
    {
    }
    public function ajaxRespondFWARequest(Request $request)
    {
    }

    public function reviewDailySchedule()
    {
    }
    public function ajaxReviewDailySchedules(Request $request)
    {
    }
    public function ajaxReviewSaveDailySchedule(Request $request)
    {
    }
}
