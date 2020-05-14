<?php

namespace Grofie\Http\Controllers\admin;

use Grofie\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Grofie\DeliveryAssociates;
use Session;
use DB;
use Redirect;

class DeliveryController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index(Request $request)
    {
        $data = DeliveryAssociates::orderBy('id','DESC')->get();
        if(request()->ajax())
        {
          return datatables()->of($data)
                ->addColumn('action', function($data){
                  $button = '<button type="button" name="edit" id="'.$data->id.'" data-fname="'.$data->f_name.'" data-sname="'.$data->s_name.'"data-phone="'.$data->phone.'" data-email="'.$data->email.'" data-verify="'.$data->verify_stat.'" class="view btn btn-outline btn-info btn-sm">View</button>';
                  $button .= '&nbsp;';
                  $button .= '<button type="button" name="edit" id="'.$data->id.'" data-url="' . route('delivery.update') .'" data-fname="'.$data->f_name.'" data-sname="'.$data->s_name.'"data-phone="'.$data->phone.'" data-email="'.$data->email.'" class="edit btn btn-outline btn-primary btn-sm">Edit</button>';
                  $button .= '&nbsp;';
                  $button .= '<button type="button" name="delete" data-id="'.$data->id.'" data-fname="'.$data->f_name.'" data-url="' . route('delivery.destroy') .'"  class="delete btn btn-outline btn-danger btn-sm">Del</button>';
                  return $button;
                })
                ->addColumn('name', function($data){
                $name = $data->f_name.' '.$data->s_name;
                return $name;
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);       
                    
        }        
        return view('admin_v2.delivery.index');
    } 
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          'f_name' => 'required|max:255|unique:delivery_associates',
          's_name' => 'required|max:255',
          'phone' => 'required|unique:delivery_associates|max:10|regex:/^[0-9]{7,15}$/|min:10',
          'email' => 'required|max:255|unique:delivery_associates', 
        ],[
            'phone.min' => 'Please insert valid phone number format.',
            'phone.regex' => 'Please insert valid phone number format.',
        ]);
        
        if ($validator->fails())
        {
          return response()->json(['errors' => $validator->errors()]);
        }
        else
        {
            $data = new DeliveryAssociates;
            $data->f_name = $request->f_name;
            $data->s_name = $request->s_name;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $is_saved = $data-> save();  
            if($is_saved)
            {  
                $tmessage = array('tmessage' => 'Delivery Associates added successfully');
                return response()->json($tmessage);  
            }
            
        }
    

    } 
    public function update(Request $request)
    {
        $data = DeliveryAssociates::find($request->id);    
 
        if ($data->phone == $request->phone) 
        {
            $validator = \Validator::make($request->all(), [                
                'phone' => 'required|max:10|regex:/^[0-9]{7,15}$/|min:10',
                 ],[
                'phone.min' => 'Please insert valid phone number format.',
                'phone.regex' => 'Please insert valid phone number format.',
            ]);
            if ($validator->fails())
            {
                return response()->json(['errors' => $validator->errors()]);
            }
        }
        else
        {
            $validator = \Validator::make($request->all(), [
                'f_name' => 'required|max:255',           
                's_name' => 'required|max:255',
                'phone' => 'required|unique:delivery_associates|max:10|regex:/^[0-9]{7,15}$/|min:10',
                'email' => 'required|max:255', 
                 ],[
                'phone.min' => 'Please insert valid phone number format.',
                'phone.regex' => 'Please insert valid phone number format.',
            ]);
            if ($validator->fails())
            {          
                return response()->json(['errors' => $validator->errors()]);
            }
        }
        if ($data->email == $request->email) 
        {
            $validator = \Validator::make($request->all(), [                
                'email' => 'required|max:255',                 
            ]);
            if ($validator->fails())
            {
                return response()->json(['errors' => $validator->errors()]);
            }
        }
        else
        {
            $validator = \Validator::make($request->all(), [
                'f_name' => 'required|max:255',           
                's_name' => 'required|max:255',
                'phone' => 'required|max:10|regex:/^[0-9]{7,15}$/|min:10',
                'email' => 'required|max:255|unique:delivery_associates|', 
                 ],[
                'phone.min' => 'Please insert valid phone number format.',
                'phone.regex' => 'Please insert valid phone number format.',
            ]);
            if ($validator->fails())
            {          
                return response()->json(['errors' => $validator->errors()]);
            }
        }
        if($validator->passes())
        {   
            $data->f_name = $request->f_name;
            $data->s_name = $request->s_name;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $is_saved = $data-> update();  
            if($is_saved)
            {  
                $tmessage = array('tmessage' => 'Delivery Associates added successfully');
                return response()->json($tmessage);  
            }
        } 
    }
    public function destroy(Request $request)
    {
        DeliveryAssociates::find($request->id)->delete();
        $tmessage = array('tmessage' => 'Associates deleted successfully');
        return response()->json($tmessage);
        
    }




}
