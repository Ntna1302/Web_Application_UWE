<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Roles;
use Illuminate\Support\Facades\Auth;

use Toastr;
class AuthController extends Controller
{
    public function register_auth(){
        return view('admin.custom_auth.register');
    }

    public function login_auth(){
        return view('admin.login.login_auth');
    }

    public function logout_auth(){
        Auth::logout();
        
        Toastr::success('Successfully logged out','Successful');

        return redirect('/login-auth');
    }

    public function login(Request $request){
     
        $data = $request->validate([
        'admin_email' => 'required|email|max:255',
        
        'admin_password' => 'required',
       
        
    ],[ 
        'admin_email.required' => 'Please fill in Email address',
        'admin_email.email' => 'Invalid Email Address',

        'admin_password.required' => 'Please fill in password',
      
    ]
);

        if (Auth::attempt(['admin_email' => $request->admin_email,'admin_password' =>  $request->admin_password])){

            Toastr::success('Successfully logged in','Successful');

            return redirect('/dashboard');
        } else {
            Toastr::error('Incorrect password, please try again','Failed');

            return redirect('/login-auth');

        }
    }
    
    public function register(Request $request){
         $this->validation($request);
         $data = $request->all();

         $admin = new Admin();
         $admin->admin_name = $data['admin_name'];
         $admin->admin_phone = $data['admin_phone'];
         $admin->admin_email = $data['admin_email'];
         $admin->admin_password = md5($data['admin_password']);
         $admin->save();

         return redirect('/register-auth')->with('message','Account registration successful');
    }

    public function validation($request){

        return $this->validate($request,[
            'admin_name' => 'required|max:255',
            'admin_phone' =>'required|max:255',
            'admin_email' =>'required|unique:tbl_admin,admin_email|max:255',
            'admin_password' =>'required|max:255',
            ]);
    }
}