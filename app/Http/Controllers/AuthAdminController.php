<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthAdminController extends Controller
{
    public function login(){
        return view('admin.login');
    }
    public function ajaxLogin(Request $request){
        $data = $request->validate([
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        if (!\Auth::guard('admin')->attempt($request->only(['email','password']))){
            return response()->json([
                "success"=>false,
                "message"=>"Invalid E-mail or password"
            ]);
        }
        return response()->json([
            "success"=>true,
            "message"=>"Success",
            "data"=>"/admin/dashboard"
        ]);
    }
    public function logout(){
        session()->flush();
        return redirect('/admin/login');
    }
}
