<?php

namespace Grofie\Http\Controllers\delivery_associates;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Grofie\DeliveryAssociates;
use Grofie\Order;
use Grofie\Product;
use Grofie\Charge;
use Grofie\Address;
use Session;

class HomeController extends Controller
{
	
    public function index()
    {
    	if(Auth::check())
    	{
            $associate = DeliveryAssociates::find(Auth::id());
    		$orderAssign = Order::where('delivery_associates_id' , Auth::id())
                            ->where('order_stat','=', 2)
                            ->join('users', 'orders.user_id','=','users.id')
    						->join('products', 'orders.product_id','=','products.product_id')
    						->join('units', 'products.unit_id','=','units.unit_id')
    						->get();
            $orderAssignCount = Order::where('delivery_associates_id' , Auth::id())
                            ->where('order_stat','=', 2)->count();
    		return view('delivery.dashboard', ['orderAssign' => $orderAssign , 'associate' => $associate , 'orderAssignCount' => $orderAssignCount]);			
    	}
    	
    }
    public function orderDetails($order_id)
    {
       $orderDetails =  Order::where('order_id' , $order_id)
                        ->where('order_stat','=', 2)   
                        ->join('products', 'orders.product_id','=','products.product_id')
                        ->join('users', 'orders.user_id','=','users.id')
                        ->get();
       return response()->json(['orderDetails' => $orderDetails ]);                   
    }
    public function orderReturn($order_id , $product_id)
    {
        $subtotal = 0;
        $delCharges = Charge::select('id' , 'min_ordr_amount' ,'delivery_charges' ,'delivery_area','delivery_free_area','km_charges')->first();
        $order = Order::where('order_id','=',$order_id)->get();
        foreach ($order as $c_order)
        {
            if($c_order->product_id != $product_id)
            {
                if($c_order->offers > 0)
                {
                    $subtotal = $subtotal + $c_order->qty*$c_order->sell_price_after_offer; 
                }
                else
                {
                    $subtotal = $subtotal + $c_order->qty*$c_order->sell_price; 
                }
            }
        }
        if($delCharges->min_ordr_amount > $subtotal )
        {
            $returnOrder = Order::where('order_id','=',$order_id)
                            ->where('product_id','=',$product_id)->first();
                            
            $return_product = Product::where('product_id','=',$product_id)->first();
            $qty = $return_product->product_in_hand_stock + $returnOrder->qty;       

            Product::where('product_id','=',$product_id)->update(['product_in_hand_stock' => $qty]);
            Order::where('order_id','=',$order_id)->update(['delivery_charges' => $delCharges->delivery_charges]);

            $return_order = Order::where('order_id','=',$order_id)->where('product_id','=',$product_id)
                                    ->update(['order_stat' => -1 ]);
            $allreturned = Order::where('order_id' , $order_id)
                        ->where('order_stat', '=' , 2)->count();
       
            if($allreturned > 0)
            {
                $returnOrder = Order::where('order_id' , $order_id)
                        ->join('products', 'orders.product_id','=','products.product_id')
                        ->join('units', 'products.unit_id','=','units.unit_id')
                        ->get();

                return response()->json(['returnOrder' => $returnOrder]); 
                
            }
            else 
            {
                // if all item retun then details will be closed and reload index page
                return response()->json(['allreturned' => 1]); 
            } 
            
        }
        else
        {
            $returnOrder = Order::where('order_id','=',$order_id)
                            ->where('product_id','=',$product_id)->first();
                            
            $return_product = Product::where('product_id','=',$product_id)->first();
            $qty = $return_product->product_in_hand_stock + $returnOrder->qty;       

            Product::where('product_id','=',$product_id)->update(['product_in_hand_stock' => $qty]);
            
            $return_order = Order::where('order_id','=',$order_id)->where('product_id','=',$product_id)
                                    ->update(['order_stat' => -1 ]);

            $allreturned = Order::where('order_id' , $order_id)
                        ->where('order_stat', '=' , 2)->count();
       
            if($allreturned > 0)
            {
                $returnOrder = Order::where('order_id' , $order_id)
                        ->join('products', 'orders.product_id','=','products.product_id')
                        ->join('units', 'products.unit_id','=','units.unit_id')
                        ->get();

                return response()->json(['returnOrder' => $returnOrder]); 
                
            }
            else 
            {
                // if all item retun then details will be closed and reload index page
                return response()->json(['allreturned' => 1]); 
            }  

        }
         
    }
    public function confirmOrder($order_id)
    {
        $confirmOrder = Order::where('order_id', $order_id)->where('order_stat','=',2)->update(['order_stat' => 3 , 'delivery_date' => now()]);
        if($confirmOrder)
        {
            return response()->json(['success' => 1]);
        }
        
    }
    public function alldelivery()
    {
        if(Auth::check())
        {
            $associate = DeliveryAssociates::find(Auth::id());
            $allorders = Order::where('delivery_associates_id' , Auth::id())
                            ->where('order_stat','=', 3)
                            ->join('users', 'orders.user_id','=','users.id')
                            ->join('products', 'orders.product_id','=','products.product_id')
                            ->get();           
            return view('delivery.all_orders',['allorders' => $allorders , 'associate' => $associate]);

        }
    }
     public function deliveryDetails($order_id)
    {
        $deliveryDetails =  Order::where('order_id' , $order_id)
                            ->where('order_stat','=', 2)   
                            ->join('products', 'orders.product_id','=','products.product_id')
                            ->join('units', 'products.unit_id','=','units.unit_id')
                            ->get();
       return response()->json(['deliveryDetails' => $deliveryDetails]);      
    }
}
