<?php

namespace Grofie\Http\Controllers\admin;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Redirect;
use Grofie\Unit;
use Grofie\Product;
use Grofie\Tax;
use Grofie\Category;
use Grofie\SubCategory;
use Grofie\Cart;
use Grofie\Order;
use Grofie\Brand;
use DB;
use Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {   
      $products = Product::join('brands','products.brand_id','=','brands.brand_id')
                  ->join('categories','products.category_id','=','categories.category_id')
                  ->join('units','products.unit_id','=','units.unit_id')
                  ->select(array('products.product_id','products.product_image_main','products.product_name','products.product_description','products.product_buy_price','products.product_offers','products.product_sell_price_after_offer','products.product_sell_price','products.product_in_hand_stock','products.product_stat','products.cgst_rate','products.sgst_rate','products.igst_rate','products.ugst_rate','brands.brand_name','categories.category_name','units.unit_name_lm'))
                  ->orderBy('products.product_id','DESC')->get();

        $categories = Category::orderBy('category_id','ASC')->get();
        $sub_categories = SubCategory::orderBy('sub_cat_id','ASC')->get();
        $brands = Brand::orderBy('brand_id','ASC')->get();
        $taxes = Tax::orderBy('tax_id','ASC')->get();
        $unites = Unit::orderBy('unit_id','ASC')->get();

            //Product::orderBy('product_id','DESC')->get();
       // return view('admin.product.index', ['products' => $products ]);
      if(request()->ajax())
        {
          return Datatables()->of($products)
                ->addColumn('action', function($data){
                  $button = '<a type="button" href="' .route('product.show',$data->product_id).'" class="view btn btn-outline btn-info btn-sm">View</a>';
                  $button .= '&nbsp;';
                  $button .= '<a type="button" href="' .route('product.edit',$data->product_id).'" class="edit btn btn-outline btn-primary btn-sm">Edit</a>';
                  $button .= '&nbsp;';
                  $button .= '<button type="button" name="delete" data-id="'.$data->product_id.'" data-name="'.$data->product_name.'" data-url="' . route('product.delete', $data->product_id) .'" class="delete btn btn-outline btn-danger btn-sm">Del</button>';
                  return $button;
                })
                ->addColumn('status', function($data){
                  if( $data->product_stat == 1)
                  {
                     $status = '<button type="button" id="'.$data->product_id.'" data-url="' . route('product.active', $data->product_id) .'" class="active btn btn-success btn-xs">Active</button>';  
                  }
                  else
                  {
                    $status = '<button type="button" id="'.$data->product_id.'" data-url="' . route('product.deactive', $data->product_id) .'" class="deactive btn btn-danger btn-xs">Deactive</button type="button">';   
                  }
                  return $status;
                })
                 ->addColumn('sell_price', function($data){
                  if( $data->cgst > 0 || $data->sgst > 0 || $data->igst > 0 || $data->ugst > 0)
                  {
                    $sell_price = '<strong><p class="text-primary">'.$data->product_sell_price.'</p></strong>';
                  }
                  else
                  {
                    $sell_price = $data->product_sell_price;   
                  }
                  return $sell_price;
                })
                ->addIndexColumn()              
                ->rawColumns(['action' , 'status', 'sell_price',])
                ->make(true);       
                    
        }         
    return view('admin_v2.product.index',['products' => $products ,'categories' => $categories, 'sub_categories' => $sub_categories , 'brands' => $brands, 'taxes' => $taxes , 'unites' => $unites]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
               
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validator = \Validator::make($request->all(), [
          'product_name' => 'required|max:255',
          'product_description' => 'required',          
          'brand_id' => 'required|not_in:0',
          'category_id' => 'required|not_in:0',     
          'sub_cat_id' => 'required|not_in:0',         
          'unit_id' => 'required|not_in:0',
          'product_buy_price' => 'required|integer',
          'product_buy_qty' => 'required|integer',
          'product_sell_price' => 'required|integer',
          'product_offers' => 'required|integer',        
          'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048|image',
          'image1' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
          'image2' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
          'image3' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
          'image4' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
          'image5' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
          'product_stat' => 'required',
        ],[
          'image.required'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048',
          'image.upload'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048',
          'image1.upload'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048',
          'image2.upload'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048',   
          'image3.upload'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048', 
          'image4.upload'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048',     
          'image5.upload'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048',   
        ]);
        if ($validator->fails())
        {
          return response()->json(['errors' => $validator->errors()]);
        }
        $products = new Product;
        $image = $request->file('image');
        $image1 = $request->file('image1');
        $image2 = $request->file('image2');
        $image3 = $request->file('image3');
        $image4 = $request->file('image4');
        $image5 = $request->file('image5');

       if ($image){
          $image_name=str_random(20);
          $ext=strtolower($image->getClientOriginalExtension());
          $image_full_name=$image_name.'.'.$ext;
          $upload_path='../img-file-manager/product/';
          $image_url=$upload_path.$image_full_name;
          $success=$image->move($upload_path,$image_full_name);
          if($success){
            $products->product_image_main=$image_url;
          }
       }
       if ($image1){
          $image_name=str_random(20);
          $ext=strtolower($image1->getClientOriginalExtension());
          $image_full_name=$image_name.'.'.$ext;
          $upload_path='../img-file-manager/product/';
          $image_url=$upload_path.$image_full_name;
          $success=$image1->move($upload_path,$image_full_name);
          if($success){
            $products->product_image1=$image_url;
          }
       }
          if ($image2){
          $image_name=str_random(20);
          $ext=strtolower($image2->getClientOriginalExtension());
          $image_full_name=$image_name.'.'.$ext;
          $upload_path='public/image/product/';
          $image_url=$upload_path.$image_full_name;
          $success=$image2->move($upload_path,$image_full_name);
          if($success){
            $products->product_image2=$image_url;
          }
       }
          if ($image3){
          $image_name=str_random(20);
          $ext=strtolower($image3->getClientOriginalExtension());
          $image_full_name=$image_name.'.'.$ext;
          $upload_path='../img-file-manager/product/';
          $image_url=$upload_path.$image_full_name;
          $success=$image3->move($upload_path,$image_full_name);
          if($success){
            $products->product_image3=$image_url;
          }
       }
          if ($image4){
          $image_name=str_random(20);
          $ext=strtolower($image4->getClientOriginalExtension());
          $image_full_name=$image_name.'.'.$ext;
          $upload_path='../img-file-manager/product/';
          $image_url=$upload_path.$image_full_name;
          $success=$image4->move($upload_path,$image_full_name);
          if($success){
            $products->product_image4=$image_url;
          }
       }
          if ($image5){
          $image_name=str_random(20);
          $ext=strtolower($image5->getClientOriginalExtension());
          $image_full_name=$image_name.'.'.$ext;
          $upload_path='../img-file-manager/product/';
          $image_url=$upload_path.$image_full_name;
          $success=$image5->move($upload_path,$image_full_name);
          if($success){
            $products->product_image5=$image_url;
          }
       }

        $products->product_name = $request->product_name;
        $products->product_description = $request->product_description;
        $products->category_id = $request->category_id;
        $products->sub_cat_id = $request->sub_cat_id;
        $products->brand_id = $request->brand_id;   
        $products->unit_id = $request->unit_id;
        $products->product_buy_price = $request->product_buy_price;
        $products->product_buy_qty = $request->product_buy_qty;
        $products->product_offers = $request->product_offers;
        $products->cgst_rate = $request->cgst_rate;
        $products->sgst_rate = $request->sgst_rate;
        $products->igst_rate = $request->igst_rate;
        $products->ugst_rate = $request->ugst_rate;
        /* Without Offers Sell Price */
        $products->cgst_amount = ($request->product_sell_price * $request->cgst_rate)/100;
        $products->sgst_amount = ($request->product_sell_price * $request->sgst_rate)/100;
        $products->igst_amount = ($request->product_sell_price * $request->igst_rate)/100;
        $products->ugst_amount = ($request->product_sell_price * $request->ugst_rate)/100;    

        $products->product_sell_price = $request->product_sell_price;
        $products->product_sell_price_ex_gst = $request->product_sell_price - ($products->cgst_amount+$products->sgst_amount+$products->igst_amount+$products->ugst_amount);
        /* Without Offers Sell Price */

        /* With Offers Sell Price */
       if( $request->product_offers>0){
        $offer_price = $request->product_sell_price - (($request->product_sell_price*$request->product_offers)/100) ;
        $products->cgst_amount = ($offer_price * $request->cgst_rate)/100;
        $products->sgst_amount = ($offer_price * $request->sgst_rate)/100;
        $products->igst_amount = ($offer_price * $request->igst_rate)/100;
        $products->ugst_amount = ($offer_price * $request->ugst_rate)/100;
        $products->product_sell_price_after_offer = $offer_price;
        $products->product_sell_price_after_offer_ex_gst = $offer_price - ($products->cgst_amount+$products->sgst_amount+$products->igst_amount+$products->ugst_amount);
       }
       
       /* With Offers Sell Price */ 

       $products->product_in_hand_stock = $products->product_in_hand_stock + $request->product_buy_qty;        
       $products->product_stat = $request->product_stat;
       $is_saved = $products-> save();

       if($is_saved){
        $tmessage = array('tmessage' => 'Product added successfully');
        return response()->json($tmessage); 
      
       }
      // $data = $request->all();
      // echo "<pre>"; print_r($data); echo "<pre>";
       // return $products;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
        $products = Product::where('product_id','=',$product_id)
                    ->join('brands','products.brand_id','=','brands.brand_id')
                    ->join('categories','products.category_id','=','categories.category_id')
                    ->join('sub_categories','products.sub_cat_id','=','sub_categories.sub_cat_id')
                    ->join('units','products.unit_id','=','units.unit_id')
                    ->first();
        return view('admin_v2.product.view',['products' => $products]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($product_id)
    {
        $categories = Category::orderBy('category_id','ASC')->get();
        $sub_categories = SubCategory::orderBy('sub_cat_id','ASC')->get();
        $brands = Brand::orderBy('brand_id','ASC')->get();
        $taxes = Tax::orderBy('tax_id','ASC')->get();
        $unites = Unit::orderBy('unit_id','ASC')->get();
      
        $products = Product::find($product_id);
        return view('admin_v2.product.edit',['products'=>$products , 'categories' => $categories ,'sub_categories' => $sub_categories , 'brands' => $brands, 'taxes' => $taxes , 'unites' => $unites]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {
         $request->validate([
          'product_name' => 'required|max:255',
          'product_description' => 'required',          
          'brand_id' => 'required|not_in:0',
          'category_id' => 'required|not_in:0',  
          'sub_cat_id' => 'required|not_in:0',         
          'unit_id' => 'required|not_in:0',
          'product_buy_price' => 'required|integer',
          'product_buy_qty' => 'required|integer',
          'product_sell_price' => 'required|integer',
          'product_offers' => 'required|integer',
          'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
          'image1' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
          'image2' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
          'image3' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
          'image4' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
          'image5' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
          'product_stat' => 'required',
        ],[
         // 'image.required'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048',          
          'image.upload'=>'Image format jpeg,png,jpg,gif,svg|max:2048',
          'image1.upload'=>'Image format jpeg,png,jpg,gif,svg|max:2048',
          'image2.upload'=>'Image format jpeg,png,jpg,gif,svg|max:2048',   
          'image3.upload'=>'Image format jpeg,png,jpg,gif,svg|max:2048', 
          'image4.upload'=>'Image format jpeg,png,jpg,gif,svg|max:2048',     
          'image5.upload'=>'Image format jpeg,png,jpg,gif,svg|max:2048',   
        ]);
        
        $image = $request->file('image');
        $image1 = $request->file('image1');
        $image2 = $request->file('image2');
        $image3 = $request->file('image3');
        $image4 = $request->file('image4');
        $image5 = $request->file('image5');
        $products = Product::find($product_id);

        if($image){
          if(file_exists($products->product_image)){
            unlink($products->product_image);
            }
            /*$image_name=$required->product_id.$image->getClientOriginalExtension();
            $upload_path='public/image/';
            $image_url=$upload_path.$image_name;*/
            $image_name=str_random(20);
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='../img-file-manager/product/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if($success){
                $products->product_image_main=$image_url;
             }
        }     
        if($image1){
          if(file_exists($products->product_image1)){
            unlink($products->product_image1);
            }
            /*$image_name=$required->product_id.$image->getClientOriginalExtension();
            $upload_path='public/image/';
            $image_url=$upload_path.$image_name;*/
            $image_name=str_random(20);
            $ext=strtolower($image1->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='../img-file-manager/product/';
            $image_url=$upload_path.$image_full_name;
            $success=$image1->move($upload_path,$image_full_name);
            if($success){
                $products->product_image1=$image_url;
             }
        }     
        if($image2){
          if(file_exists($products->product_image2)){
            unlink($products->product_image2);
            }
            /*$image_name=$required->product_id.$image->getClientOriginalExtension();
            $upload_path='public/image/';
            $image_url=$upload_path.$image_name;*/
            $image_name=str_random(20);
            $ext=strtolower($image2->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='../img-file-manager/product/';
            $image_url=$upload_path.$image_full_name;
            $success=$image2->move($upload_path,$image_full_name);
            if($success){
                $products->product_image2=$image_url;
             }
        }
        if($image3){
          if(file_exists($products->product_image3)){
            unlink($products->product_image3);
            }
            /*$image_name=$required->product_id.$image->getClientOriginalExtension();
            $upload_path='public/image/';
            $image_url=$upload_path.$image_name;*/
            $image_name=str_random(20);
            $ext=strtolower($image3->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='../img-file-manager/product/';
            $image_url=$upload_path.$image_full_name;
            $success=$image3->move($upload_path,$image_full_name);
            if($success){
                $products->product_image3=$image_url;
             }
        }     
        if($image4){
          if(file_exists($products->product_image4)){
            unlink($products->product_image4);
            }
            /*$image_name=$required->product_id.$image->getClientOriginalExtension();
            $upload_path='public/image/';
            $image_url=$upload_path.$image_name;*/
            $image_name=str_random(20);
            $ext=strtolower($image4->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='../img-file-manager/product/';
            $image_url=$upload_path.$image_full_name;
            $success=$image4->move($upload_path,$image_full_name);
            if($success){
                $products->product_image4=$image_url;
             }
        }     
        if($image5){
          if(file_exists($products->product_image5)){
            unlink($products->product_image5);
            }
            /*$image_name=$required->product_id.$image->getClientOriginalExtension();
            $upload_path='public/image/';
            $image_url=$upload_path.$image_name;*/
            $image_name=str_random(20);
            $ext=strtolower($image5->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='../img-file-manager/product/';
            $image_url=$upload_path.$image_full_name;
            $success=$image5->move($upload_path,$image_full_name);
            if($success){
                $products->product_image5=$image_url;
             }
        }     
        // }
        // else{   
        //    $products->product_image_main=$products->product_image;
        // }

        $products->product_name = $request->product_name;
        $products->product_description = $request->product_description;
        $products->category_id = $request->category_id;
        $products->sub_cat_id = $request->sub_cat_id;
        $products->brand_id = $request->brand_id;   
        $products->unit_id = $request->unit_id;
        $products->product_buy_price = $request->product_buy_price;
        $products->product_buy_qty = $request->product_buy_qty;
       
        $products->product_offers = $request->product_offers;
        $products->cgst_rate = $request->cgst_rate;
        $products->sgst_rate = $request->sgst_rate;
        $products->igst_rate = $request->igst_rate;
        $products->ugst_rate = $request->ugst_rate;

        /* Without Offers Sell Price */
        $products->cgst_amount = ($request->product_sell_price * $request->cgst_rate)/100;
        $products->sgst_amount = ($request->product_sell_price * $request->sgst_rate)/100;
        $products->igst_amount = ($request->product_sell_price * $request->igst_rate)/100;
        $products->ugst_amount = ($request->product_sell_price * $request->ugst_rate)/100;    

        $products->product_sell_price = $request->product_sell_price;
        $products->product_sell_price_ex_gst = $request->product_sell_price - ($products->cgst_amount+$products->sgst_amount+$products->igst_amount+$products->ugst_amount);
        /* Without Offers Sell Price */

        /* With Offers Sell Price */
       if( $request->product_offers>0){
        $offer_price = $request->product_sell_price - (($request->product_sell_price*$request->product_offers)/100) ;
        $products->cgst_amount = ($offer_price * $request->cgst_rate)/100;
        $products->sgst_amount = ($offer_price * $request->sgst_rate)/100;
        $products->igst_amount = ($offer_price * $request->igst_rate)/100;
        $products->ugst_amount = ($offer_price * $request->ugst_rate)/100;
        $products->product_sell_price_after_offer = $offer_price;
        $products->product_sell_price_after_offer_ex_gst = $offer_price - ($products->cgst_amount+$products->sgst_amount+$products->igst_amount+$products->ugst_amount);
       }
       
       /* With Offers Sell Price */  
       if($request->product_buy_qty > 0)
        {
          $products->product_buy_date = now()->format('d-m-Y');
        }
       $products->product_in_hand_stock = $products->product_in_hand_stock + $request->product_buy_qty; 
       $products->product_stat = $request->product_stat;
       $is_saved = $products-> update();

      if($is_saved){
        Session::flash('success','Product updated successfully');
        return redirect()->route('product.index');
      }

     //  $categories->timestamps = now();
       // $is_saved = $products-> update();

       // if($is_saved){
       //  Session::flash('success','Product updated successfully');
       //  return redirect()->route('product.index');
       // }

        // echo "<pre>";
        // print_r($products);
        // echo "</pre>";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {      
      $inCart = Cart::where('product_id' , $product_id)->first();
      $inOrder = Order::where('product_id' , $product_id)->first();

      if($inCart)
      {
        return response()->json(['errors' => 'Product is in cart, can not delete']); 
      }
      if($inOrder)
      {
        return response()->json(['errors' => 'Product is in order, can not delete']); 
      }
      else
      {
        $product = Product::find($product_id);

        if(file_exists($product->product_image_main)){
            unlink($product->product_image_main);
        }
        if(file_exists($product->product_image1)){
            unlink($product->product_image1);
        }
        if(file_exists($product->product_image2)){
            unlink($product->product_image2);
        }
        if(file_exists($product->product_image3)){
            unlink($product->product_image3);
        }
        if(file_exists($product->product_image4)){
            unlink($product->product_image4);
        }
        if(file_exists($product->product_image5)){
            unlink($product->product_image5);
        }

        $product->delete();
        $tmessage = array('tmessage' => 'Product Deleted successfully');
        return response()->json($tmessage); 
      }

    }

    public function imageDel($product_id, $img_id)
    {
      $products = Product::find($product_id);
      if($img_id == 0)
      {
        if(file_exists($products->product_image_main)){
          unlink($products->product_image_main);
        }
        $products->product_image_main = '';
        $products->update();
        return response()->json(['success' => 1]);
      } 
      if($img_id == 1)
      {
        if(file_exists($products->product_image1)){
          unlink($products->product_image1);
        }
        $products->product_image1 = '';
        $products->update();
        return response()->json(['success' => 1]);
      }
      if($img_id == 2)
      {
        if(file_exists($products->product_image2)){
          unlink($products->product_image2);
        }
        $products->product_image2 = '';
        $products->update();
        return response()->json(['success' => 1]);
      }
      if($img_id == 3)
      {
        if(file_exists($products->product_image3)){
          unlink($products->product_image3);
        }
        $products->product_image3 = '';
        $products->update();
        return response()->json(['success' => 1]);
      }
      if($img_id == 4)
      {
        if(file_exists($products->product_image4)){
          unlink($products->product_image4);
        }
        $products->product_image4 = '';
        $products->update();
        return response()->json(['success' => 1]);
      }
      if($img_id == 5)
      {
        if(file_exists($products->product_image5)){
          unlink($products->product_image5);
        }
        $products->product_image5 = '';
        $products->update();
        return response()->json(['success' => 1]);
      }

    }

     public function active($product_id)
    {
        DB::table('products')
            ->where('product_id',$product_id)
            ->update(['product_stat' => 0]);

    Session::flash('error','Product deactivated successfully');
    return redirect()->route('product.index');
    }
    public function deactive($product_id)
    {
         DB::table('products')
            ->where('product_id',$product_id)
            ->update(['product_stat' => 1]);

     Session::flash('success','Product activated successfully');       
     return redirect()->route('product.index');
      
    }
}

