<?php

namespace Grofie\Http\Controllers\delivery_associates;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Grofie\DeliveryAssociates;
use Validator;
use Session;

class LoginController extends Controller
{

    public function loginform()
    {
    	return "1";
    }
    protected function guard()
    {
        return Auth::guard('delivery');
    }
    // protected $redirectTo = '/delivery/dashboard';

    public function __construct()
    {
        $this->middleware('guest:delivery')->except('logout');       
       
    }
    public function login(Request $request)
    {  
        $associates =DeliveryAssociates::where('phone', $request->phone)->first();	
    	$validator = \Validator::make($request->all(), [
          'phone' => 'required|max:10|min:10|exists:delivery_associates',          
        ]);                
        if ($validator->fails())
        {           
          return response()->json(['errors' => $validator->errors()]);
        }
 
        if(!$associates->verify_stat)
        {
            Session::put('user', $associates);
            $notverified = array('notverified' => $associates);
            return response()->json($notverified); 
        }
        else
        {
            Session::put('user', $associates);
            $verified = array('verified' => $associates);
            return response()->json($verified); 
        }
    }


    public function confirm(Request $request)
    {
        $user = Session::get('user');
        $pin = md5($request->pin);

       
        $validator = \Validator::make($request->all(), [
          'pin' => 'required|max:6|min:6',          
        ]);
        if ($validator->fails())
        {           
          return response()->json(['errors' => $validator->errors()]);
        }
        if($pin != $user->pin)
        {
            $invalid = array('invalid' => 'Incorrect PIN');
            return response()->json($invalid); 
        }
        else
        {
            $this->guard()->login($user); 
            return response()->json(['success' => 1]); 
        }
        // $this->guard()->login($user); 
        // return redirect()->route('delivery.dashboard');  
        // echo "<pre>";     print_r($user->pin); echo "</pin>";
    }

    public function setpin(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          'pin' => 'required|confirmed|min:6',         
        ]);                
        if ($validator->fails())
        {           
          return response()->json(['errors' => $validator->errors()]);
        }
        else
        {   
            $user = Session::get('user');
            $associates = DeliveryAssociates::find($user->id);
            $associates->pin = md5($request->pin);
            $associates->verify_stat = now();
            $is_update = $associates->update(); 
            if($is_update)
            {
                $this->guard()->login($user); 
                return response()->json(['success' => 1]);          
                // return redirect()->route('delivery.dashboard');   
            }
            
       
            // echo "<pre>"; print_r($request->pin); echo "</pre>";
        }     
      
    }
    public function logout(Request $request)
    {
        Auth::guard('delivery')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->guest(route( 'delivery.login.form' ));
    }

}
