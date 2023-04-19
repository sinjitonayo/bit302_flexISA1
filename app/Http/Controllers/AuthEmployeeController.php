<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthEmployeeController extends Controller
{
    public function login(){
        return view('employee.login');
    }
    public function ajaxLogin(Request $request){
        $data = $request->validate([
            'employee_id'   => 'required',
            'password' => 'required|min:6'
        ]);
        $employee = \App\Models\Employee::where('employee_id', $data['employee_id'])->first();
        if(!$employee){
            return response()->json([
                "success"=>false,
                "message"=>"Invalid employee ID"
            ]);
        }
        if (!Hash::check($data['password'], $employee->password)){
            return response()->json([
                "success"=>false,
                "message"=>"Incorrect password"
            ]);
        }
        \Auth::guard('employee')->loginUsingId($employee->id);
        return response()->json([
            "success"=>true,
            "message"=>"Success",
            "data"=>"/dashboard"
        ]);
    }
    public function logout(){
        session()->flush();
        return redirect('/login');
    }
}
