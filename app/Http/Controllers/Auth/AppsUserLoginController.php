<?php

namespace Grofie\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Grofie\User;
use Grofie\SMS;
use Session;
use DB;
class AppsuserLoginController extends Controller
{
    /**
     * Show the application’s login form.
     *
     * @return \Illuminate\Http\Response
     */   
    public function showLoginForm()
    {
        return view('apps.auth.login');
    }

    protected function guard(){
        
        return Auth::guard('apps');
    }
    
    //use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/intended';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:apps')->except('logout');       
       
    }
    public function login(Request $request)
    {    
        if($request->method('post'))
        {
            $users = User::where('phone', $request->phone)->first();
            if(Auth::check())
            {
                return redirect()->route('apps.account');
            }        
            $validator = \Validator::make($request->all(), [
                'phone' => 'required|numeric|regex:/[6-9][0-9]{9}/',
            ],[
                'phone.required' => 'Please enter Phone number',                
                'phone.numeric' => 'Please enter Phone number',
                'phone.regex' => 'Please enter Phone number',
            ]);
            if ($validator->fails())
            {
              return response()->json(['errors' => $validator->errors()]);
            }
            if($users)
            {                  
                if(!$users->phone_verified_at)
                {
                    $otp = mt_rand('1000','9999');  
                     // for send SMS
                    $number = $request->phone;
                    // $smsGateway = SMS::select('id' , 'api' , 'secret' , 'email')->first();
                    // $url="https://www.way2sms.com/api/v1/sendCampaign";
                    // $message = urlencode('Hi, This is your OTP for register to store :'. $otp );// urlencode your message
                    // $curl = curl_init();
                    // curl_setopt($curl, CURLOPT_POST, 1);// set post data to true
                    // curl_setopt($curl, CURLOPT_POSTFIELDS, "apikey=$smsGateway->api&secret=$smsGateway->secret&usetype=stage&phone=$number&senderid=$smsGateway->email&message=$message");// post data
                    // // query parameter values must be given without squarebrackets.
                    //  // Optional Authentication:
                    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    // curl_setopt($curl, CURLOPT_URL, $url);
                    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    // $result = json_decode(curl_exec($curl));
                    // curl_close($curl);
                    // if($result->code == 200)
                    // {
                        Session::put('users', $users);
                        Session::put('otp', $otp);
                        // return redirect()->route('apps.otp.submit');
                        $tmessage = array('tmessage' => 'Your account is not activated. OTP has been send to your mobile.');
                        return response()->json(['success' => 1 ,'otp' => $otp , 'tmessage' => $tmessage]);
                    // }
                   // elseif($result->code == 400)
                    // {    
                           // $tmessage = array('tmessage' => 'Something went wrong!!! Try again later');
                           // return response()->json(['tmessage' => $tmessage]);
                    // }
                    // else
                    // {
                           // $tmessage = array('tmessage' => $result->message);
                           // return response()->json(['tmessage' => $tmessage]);
                    // }  
                }
                else
                {
                    // $smsGateway = SMS::select('id' , 'api' , 'secret' , 'email')->first();
                    $otp = mt_rand('1000','9999'); 
                     // for send SMS
                    // $number = $request->phone;
                    // $url="https://www.way2sms.com/api/v1/sendCampaign";
                    // $message = urlencode('Hi, This is your OTP for register to store :'. $otp );// urlencode your message
                    // $curl = curl_init();
                    // curl_setopt($curl, CURLOPT_POST, 1);// set post data to true
                    // curl_setopt($curl, CURLOPT_POSTFIELDS, "apikey=$smsGateway->api&secret=$smsGateway->secret&usetype=stage&phone=$number&senderid=$smsGateway->email&message=$message");// post data
                    // //query parameter values must be given without squarebrackets.
                    // // Optional Authentication:
                    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    // curl_setopt($curl, CURLOPT_URL, $url);
                    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    // $result = json_decode(curl_exec($curl));
                    // curl_close($curl);
                  
                    // if($result->code == 200)
                    // {
                        Session::put('users', $users);
                        Session::put('otp', $otp);
                        $tmessage = array('tmessage' => 'OTP has been sent.');
                        return response()->json(['success' => 1,'otp' => $otp , 'tmessage' => $tmessage]);
                    // }
                    // elseif($result->code == 400)
                    // {    
                           // $tmessage = array('tmessage' => 'Something went wrong!!! Try again later');
                           // return response()->json(['tmessage' => $tmessage]);
                    // }
                    // else
                    // {
                           // $tmessage = array('tmessage' => $result->message);
                           // return response()->json(['tmessage' => $tmessage]);
                    // }  
                }   
            } 
            else
            {
                return response()->json(['errors' => 'This mobile number is not registerted.']);
            }  
        }    
    }
    public function chkOtpLogin(Request $request)
    {
        $user = Session::get('users');       
        $sended_otp = Session::get('otp');
        $getotp = $request->otp;
        if($sended_otp == $getotp)
        {
            if($user->phone_verified_at)
            {
                $this->guard()->login($user); 
                Session::put('AuthUser' , $user);
                Session::forget('users');
                Session::forget('otp');
                // return redirect()->intended('/'); 
               return response()->json(['login' => 1]);
            }
            else
            {
                $this->guard()->login($user);                 
                User::where('id',$user->id)->update(['phone_verified_at' => now()]);

                Session::forget('users');
                Session::forget('otp');
                Session::put('AuthUser' , $user);
                return response()->json(['login' => 1]);
                // return redirect()->intended('/');                 
            }
        }
        else
        {
            return response()->json(['errors' => 'Please enter valid OTP.']);      
        }
       
    }  

    public function resendOtp()
    {
         
        $user_data = Session::get('users'); 
        $otp = mt_rand('1000','9999');
         // for send SMS
        // $number = $user_data->phone;
        // $smsGateway = SMS::select('id' , 'api' , 'secret' , 'email')->first();  
        // //
        // $url="https://www.way2sms.com/api/v1/sendCampaign";
        // $message = urlencode('Hi, This is your OTP for register to store :'. $otp );// urlencode your message
        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_POST, 1);// set post data to true
        // curl_setopt($curl, CURLOPT_POSTFIELDS, "apikey=$smsGateway->api&secret=$smsGateway->secret&usetype=stage&phone=$number&senderid=$smsGateway->email&message=$message");// post data
        // // query parameter values must be given without squarebrackets.
        //  // Optional Authentication:
        // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // curl_setopt($curl, CURLOPT_URL, $url);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // $result = json_decode(curl_exec($curl));
        // curl_close($curl);

        // if($result->code == 200)
        // {
             
            Session::put('otp', $otp);
            $tmessage = array('tmessage' => 'OTP has been sent.');
            return response()->json(['success' => 1,'otp' => $otp , 'tmessage' => $tmessage]);
     
        // }
        // elseif($result->code == 400)
        // {
            // $tmessage = array('tmessage' => 'Something went wrong!!! Try again later.');
            // return response()->json(['tmessage' => $tmessage]);
        // }
        // else
        // {
        //     $tmessage = array('tmessage' => $result->message);
        //     return response()->json(['tmessage' => $tmessage]);
        // }  

    }

    public function logout(Request $request)
    {
        Auth::guard('apps')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->guest(route( 'apps.login' ));
    }
}