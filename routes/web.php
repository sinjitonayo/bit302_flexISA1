<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthEmployeeController;
use App\Http\Controllers\AdminGeneralController;
use App\Http\Controllers\EmployeeGeneralController;
use App\Http\Controllers\GeneralController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->group(function(){
    Route::get('/login',[AuthAdminController::class,'login']);
    Route::post('/ajax/login',[AuthAdminController::class,'ajaxLogin']);
    Route::middleware(['auth:admin'])->group(function(){
        Route::get('/', function(){ return redirect('/admin/dashboard'); });
        Route::get('/dashboard', [AdminGeneralController::class,'dashboard']);
        Route::get('/manage/employee', [AdminGeneralController::class,'employeeIndex']);
        Route::get('/ajax/employees', [AdminGeneralController::class,'ajaxEmployees']);
        Route::post('/ajax/employee/register', [AdminGeneralController::class,'ajaxRegisterEmployee']);
    });
});

// EMPLOYEE
Route::get('/login',[AuthEmployeeController::class,'login']);
Route::post('/ajax/login',[AuthEmployeeController::class,'ajaxLogin']);
Route::get('/logout',[AuthEmployeeController::class,'logout']);

Route::get('/',[GeneralController::class,'landing'])->name('login');

Route::middleware(['auth:employee'])->group(function(){
    // 
    Route::post('/ajax/update-password',[AuthEmployeeController::class,'ajaxUpdatePassword']);    
    Route::get('/dashboard',[EmployeeGeneralController::class,'dashboard']);
    Route::get('/ajax/fwa-requests',[EmployeeGeneralController::class,'ajaxFWARequests']);
    Route::post('/ajax/fwa-request/submit',[EmployeeGeneralController::class,'ajaxSubmitFWARequest']);

    Route::get('/manage/daily-schedule',[EmployeeGeneralController::class,'manageDailySchedule']);
    Route::get('/ajax/daily-schedule/{daily_schedule}',[EmployeeGeneralController::class,'ajaxDailySchedule']);
    Route::post('/ajax/daily-schedule/save',[EmployeeGeneralController::class,'ajaxSaveDailySchedule']);

    // SUPERVISOR
    Route::get('/review/fwa-request',[EmployeeGeneralController::class,'reviewFWARequest']);
    Route::get('/ajax/review/fwa-requests',[EmployeeGeneralController::class,'ajaxReviewFWARequests']);
    Route::get('/ajax/review/fwa-request/{fwa_request}/respond',[EmployeeGeneralController::class,'ajaxRespondFWARequest']);

    Route::get('/review/daily-schedule',[EmployeeGeneralController::class,'reviewDailySchedule']);
    Route::get('/ajax/review/daily-schedules',[EmployeeGeneralController::class,'ajaxReviewDailySchedules']);
    Route::get('/ajax/review/daily-schedule/{daily_schedule}save',[EmployeeGeneralController::class,'ajaxReviewSaveDailySchedule']);
});



