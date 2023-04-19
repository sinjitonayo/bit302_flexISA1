<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FWARequest;
use App\Models\DailySchedule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmployeeGeneralController extends Controller
{
    public function dashboard()
    {
        $employee = Auth::guard('employee')->user();
        return view('employee.dashboard', [
            'fwa_request' => $employee
                ->fwa_requests()
                ->where('status', '!=', 'rejected')
                ->orderBy('request_date', 'DESC')
                ->first(),
            'today_schedule' => $employee
                ->daily_schedules()
                ->where('date', Carbon::now()->format('Y-m-d'))
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
        Auth::guard('employee')->user()->supervisor->notify(new \App\Notifications\PendingFWARequest());
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
