<?php

namespace Grofie\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Grofie\Admin;
use Session;
class AdminLoginController extends Controller
{
    /**
     * Show the application’s login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin_v2.auth.login');
    }

    protected function guard(){
        
        return Auth::guard('admin');
    }
    
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }
    public function login(Request $request)
    {
        $data = $request->all();
        $admin = Admin::where('email', $data['email'])->first();
        // echo "<pre>"; print_r($admin->email); echo "</pre>";  
        if($data)
        {
            if($admin)
            {
                if($admin->password == md5($request->password))
                {
                    $this->guard()->login($admin); 
                    return redirect()->route('admin.dashboard');
                }
                else
                {
                    Session::flash('error', 'Wrong Password.Please enter correct password.');
                    return redirect()->route('admin.login');
                }
                
            }
            else
            {
                Session::flash('error', 'This email id is not registerted');
                return redirect()->route('admin.login');
            }
        }  
        else
        {
            Session::flash('error', 'Please Enter email-id and password');
            return redirect()->route('admin.login');   
        }

    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->guest(route( 'admin.login' ));
    }
}