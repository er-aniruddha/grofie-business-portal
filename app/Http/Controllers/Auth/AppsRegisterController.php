<?php

namespace Grofie\Http\Controllers\Auth;

use Grofie\User;
use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Grofie\SMS;
use DB;

class AppsRegisterController extends Controller
{
    public function redirectLogin()
    {
      return redirect()->route('apps.login');    
    } 
    
    protected function guard(){
        
        return Auth::guard('apps');
    }
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/register/mobile/verification';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:apps')->except('logout');
    }

 
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Grofie\User
     */
    public function register(Request $request)
    {
      $validator = \Validator::make($request->all(), [
          'f_name' => 'required|max:255',
          's_name' => 'required|max:255',   
          'phone' => 'required|unique:users,phone|numeric|regex:/[6-9][0-9]{9}/',
          'email' => 'required|max:255|email|unique:users,email',
      ],[
        'f_name.required' => 'Please enter First name',
        's_name.required' => 'Please enter Surname',
        'phone.required' => 'Please enter Phone number',
        'phone.min' => 'Please enter Phone number',
        'phone.numeric' => 'Please enter Phone number',
        'phone.regex' => 'Please enter Phone number',
        'email.required' => 'Please enter email id',
      ]);
      
      if ($validator->fails())
      {
        return response()->json(['errors' => $validator->errors()]);
      }

      // // for send SMS
      $number = $request->phone;
      $smsGateway = SMS::select('id' , 'api' , 'secret' , 'email')->first();
      //

      $users = new User;
      $users->f_name = $request->f_name;
      $users->s_name = $request->s_name;
      $users->phone = $request->phone;
      $users->email = $request->email;        
      $is_saved = $users->save();

      if($is_saved)
      {
        $otp = mt_rand('1000','9999');
        $url="https://www.way2sms.com/api/v1/sendCampaign";
        $message = urlencode('Hi, This is your OTP for register to store :'. $otp );// urlencode your message
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);// set post data to true
        curl_setopt($curl, CURLOPT_POSTFIELDS, "apikey=$smsGateway->api&secret=$smsGateway->secret&usetype=stage&phone=$number&senderid=$smsGateway->email&message=$message");// post data
        // query parameter values must be given without squarebrackets.
         // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = json_decode(curl_exec($curl));
        curl_close($curl);
        if($result->code == 200)
        {
            Session::put('users', $users);
            Session::put('otp', $otp);
            $tmessage = array('tmessage' => 'OTP has been sent.');
            return response()->json(['success' => 1,'otp' => $otp , 'tmessage' => $tmessage]);
        }
        elseif($result->code == 400)
        {
            $tmessage = array('tmessage' => 'Something went wrong!!! Try again later');
            return response()->json(['tmessage' => $tmessage]);
        }
        else
        {
            $tmessage = array('tmessage' => $result->message);
            return response()->json(['tmessage' => $tmessage]);
        }            
      }     
    }

}
