<?php

namespace Grofie\Http\Controllers\admin;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use DB;
use Grofie\SMS;
use Session;

class SmsController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {   
        $smscount = SMS::select('id')->count();
        if($request->isMethod('post'))
        {   
            if($smscount > 0)
            {
                $smsGateway = SMS::find($request->id);
                $smsGateway->api = $request->api_key;
                $smsGateway->secret = $request->api_secret;
                $smsGateway->email = $request->email;
                $smsGateway->update();
                Session::flash('success','SMS Gateway updated successfully');  
                return redirect()->to('admin/sms'); 
            }
            else
            {
                $smsGateway = new SMS;
                $smsGateway->api = $request->api_key;
                $smsGateway->secret = $request->api_secret;
                $smsGateway->email = $request->email;
                $smsGateway->save();
                Session::flash('success','SMS Gateway created successfully');
                return redirect()->to('admin/sms');               
            }
        }
        else            
        {
            $smsGateway = SMS::select('id' , 'api' , 'secret', 'email')->first();
            return view('admin_v2.settings.sms.index',['smsGateway' => $smsGateway ]);           
        }  
    }
    public function chksms(Request $request)
    {
         $data = $request->all();
         $smsGateway = SMS::select('id' , 'api' , 'secret' , 'email')->first();
         if($data)
         {
            $number = $data['phone'];
            $url="https://www.way2sms.com/api/v1/sendCampaign";
            $message = urlencode($request->message);// urlencode your message
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);// set post data to true
            curl_setopt($curl, CURLOPT_POSTFIELDS, 
            "apikey=$smsGateway->api&secret=$smsGateway->secret&usetype=stage&phone=$number&senderid=$smsGateway->email&message=$message");// post data
            // query parameter values must be given without squarebrackets.
             // Optional Authentication:
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
           // echo $result;
            if($result->code == 200)
            {
                Session::flash('success', 'SMS has been send successfully');  
                return redirect()->to('admin/sms');
            }
            elseif($result->code == 400)
            {
                Session::flash('error', $result->message);  
                return redirect()->to('admin/sms');
            }
            else
            {
                Session::flash('error', $result->message);  
                return redirect()->to('admin/sms');   
            }
     
            // Session::flash('info', $result);  
            // return redirect()->to('admin/sms');
            //if()
            
         }

    }

}
