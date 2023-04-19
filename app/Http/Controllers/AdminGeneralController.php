<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class AdminGeneralController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }
    
    public function employeeIndex(){
        return view('admin.employee.index',[
            "supervisors"=>Employee::where('supervisor_employee_id',NULL)->get(),
            "departments"=>Department::all()
        ]);
    } 
    public function ajaxEmployees(Request $request){
        $query = Employee::query()->with('supervisor')->with('department');
        return DataTables::eloquent($query)
        ->addColumn('supervisor', function (Employee $employee) {
            return  $employee->supervisor ? $employee->supervisor->name : "None";
        })
        ->addColumn('department', function (Employee $employee) {
            return $employee->department ? $employee->department->department_name : "None";
        })
        ->toJson();
    } 
    public function ajaxRegisterEmployee(Request $request){
        $data = $request->validate([
            "employee_id"=>"required|unique:employees,employee_id",
            "email"=>"required|unique:employees,email",
            "password"=>"required",
            "name"=>"required",
            "position"=>"required",
            "supervisor_employee_id"=>"nullable|exists:employees,id",
            "department_id"=>"required|exists:departments,id"
        ]);
        $data['password'] = Hash::make($data['password']);
        // dd($data);
        $employee = Employee::create($data);
        $employee->notify(new \App\Notifications\EmployeeRegistered());
        if(!$employee){
            return response()->json([
                "success"=>false,
                "message"=>"Gagal"
            ]);
        }
        return response()->json([
            "success"=>true,
            "message"=>"Berhasil",
            "data"=>$employee
        ]);
    }
}
