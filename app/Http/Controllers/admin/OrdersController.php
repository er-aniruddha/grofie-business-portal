<?php

namespace Grofie\Http\Controllers\admin;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Grofie\Order;
use Grofie\User;
use Grofie\Address;
use Grofie\DeliveryAssociates;
use Grofie\Charge;
use Auth;
use Session;

class OrdersController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$orders = Order::where('order_stat','=', 1)->join('users','orders.user_id','=','users.id')->get();
      return view ('admin_v2.orders.index',['orders' => $orders]);                 
      //return $orders;
    }
    public function details($order_id)
    { 
      $associate = null;
      $user_details = Order::where('order_id' , $order_id)->join('users','orders.user_id','=','users.id')->first();
      $order_details = Order::where('order_id' , $order_id)
                              ->join('products','products.product_id','=','orders.product_id')
                              ->join('brands','products.brand_id','=','brands.brand_id')
                              ->get();        
     
     
      $select_associates = DeliveryAssociates::all();
      if($user_details->delivery_associates_id != null)
      {
        $associate = DeliveryAssociates::find($user_details->delivery_associates_id);
      }

      return view ('admin_v2.orders.details',['order_details' => $order_details , 'user_details' => $user_details, 'select_associates' => $select_associates] , ['associate' => $associate]);  
       // echo "<pre>"; print_r($address); echo "<pre>";         
    }
    public function dispatched($order_id,$associates_id)
    {
      if($associates_id == 0)
      {        
        $errors = array('errors' => 'Please assign delivery associates');
        return response()->json($errors);
      }

        $orderIds = Order::where('order_id' , $order_id)->get();

        foreach ($orderIds as $orderId)
        {
          if($orderId->order_stat == 1)
          {
            $orderId->order_stat = 2;
            $orderId->delivery_associates_id = $associates_id;          
            $orderId->update();
          }
        }
  
        $tmessage = array('tmessage' => 'Updated Successfully');
        return response()->json($tmessage);
        
      // echo "<pre>"; print_r($orderIds); echo "</pre>";

    }
    public function delCharges(Request $request)
    {
      $chargesCount = Charge::select('id')->count();
        if($request->isMethod('post'))
        {   
            if($chargesCount > 0)
            {
              $delCharges = Charge::find($request->del_id);
              $delCharges->min_ordr_amount = $request->min_ordr_amount;
              $delCharges->delivery_charges = $request->delivery_charges;
              $delCharges->delivery_area = $request->delivery_area;
              $delCharges->delivery_free_area = $request->delivery_free_area;
              $delCharges->km_charges = $request->km_charges;
              $delCharges->update();
              Session::flash('success','Charges updated successfully');  
              return redirect()->route('order.delivery.charges'); 
              
            }
            else
            {
              $delCharges = new Charge;             
              $delCharges->min_ordr_amount = $request->min_ordr_amount;
              $delCharges->delivery_charges = $request->delivery_charges;
              $delCharges->delivery_area = $request->delivery_area;
              $delCharges->delivery_free_area = $request->delivery_free_area;
              $delCharges->km_charges = $request->km_charges;
              $delCharges->save();
              Session::flash('success','Charges added successfully');  
              return redirect()->route('order.delivery.charges');              
            }
          // $data = $request->all();
          // return $data;
        }
        else            
        {
          $delCharges = Charge::select('id' , 'min_ordr_amount' ,'delivery_charges' ,'delivery_area','delivery_free_area','km_charges')->first();
          return view('admin_v2.settings.charges.index',['delCharges' => $delCharges]);          
        }  
      
    }    
}
