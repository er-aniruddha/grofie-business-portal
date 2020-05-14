<?php

namespace Grofie\Http\Controllers\admin;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Grofie\Brand;
use Grofie\Product;
use Session;
use Validator;

class BrandController extends Controller
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
       // $brands = Brand::orderBy('brand_id','DESC')->get();
         // return view('admin_v2.brand.index');
      if(request()->ajax())
        {
          return datatables()->of(Brand::orderBy('brand_id','DESC')->get())
                ->addColumn('action', function($data){
                  $button = '<button type="button" name="view" id="'.$data->brand_id.'" data-name="'.$data->brand_name.'" data-desc="'.$data->brand_description.'" data-image="'.asset($data->brand_image).'" data-status="'.$data->publication_status.'" class="view btn btn-outline btn-info btn-sm">View</button>';
                  $button .= '&nbsp;';
                  $button .= '<button type="button" name="edit" id="'.$data->brand_id.'" data-name="'.$data->brand_name.'" data-desc="'.$data->brand_description.'" data-image="'.$data->brand_image.'"
                    data-status="'.$data->publication_status.'" class="edit btn btn-outline btn-primary btn-sm">Edit</button>';
                  $button .= '&nbsp;';
                  $button .= '<button type="button" name="delete" data-id="'.$data->brand_id.'" data-name="'.$data->brand_name.'" data-url="' . route('brand.delete') .'"  class="delete btn btn-outline btn-danger btn-sm">Del</button>';
                  return $button;
                })
                ->addColumn('status', function($data){
                  if( $data->publication_status == 1)
                  {
                     $status = '<button type="button" id="'.$data->brand_id.'" data-url="' . route('brand.active', $data->brand_id) .'" class="active btn btn-success btn-xs">Active</button>';  
                  }
                  else
                  {
                    $status = '<button type="button" id="'.$data->brand_id.'" data-url="' . route('brand.deactive', $data->brand_id) .'" class="deactive btn btn-danger btn-xs">Deactive</button type="button">';   
                  }
                  return $status;
                })
                ->addIndexColumn()
                ->rawColumns(['action' , 'status'])
                ->make(true);       
                    
        }        
        return view('admin_v2.brand.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         // return view('admin.brand.create');
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
          'brand_name' => 'required|max:255|unique:brands',
          'brand_description' => 'required|max:255',
          'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',    
          'publication_status' => 'required'
        ],[
          'image.required'=>'Image format should be in jpeg,png,jpg,gif,svg',
          'image.uploaded'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048', 
        ]);
        
        if ($validator->fails())
        {
            // return response()->json(['errors'=>$validator->errors()->all()]);
          return response()->json(['errors' => $validator->errors()]);
        }

        $brands = new Brand;
        $image = $request->file('image');
        if ($image){
            $image_name=str_random(20);
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='../img-file-manager/brand/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if($success){
              $brands->brand_image=$image_url;
            }
        } 

      $brands->brand_name = $request->brand_name;
      $brands->brand_description = $request->brand_description;
      $brands->publication_status = $request->publication_status;
       // $categories->timestamps = now();
      $is_saved = $brands-> save();    
      
      $tmessage = array('tmessage' => 'Brand created successfully');
      return response()->json($tmessage);  
    
        // $image = $request->all();
        // return response()->json($image);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    { 

      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $image = $request->file('image');
      $brands = Brand::find($request->brand_id);

      if($brands->brand_name == $request->brand_name)
      {
        $validator = \Validator::make($request->all(), [
          'brand_name' => 'required|max:255',
          'brand_description' => 'required|max:255',  
          'publication_status' => 'required'           
          ]);
        if ($validator->fails())
        {          
          return response()->json(['errors' => $validator->errors()]);
        }
      }
      else
      {
        $validator = \Validator::make($request->all(), [
          'brand_name' => 'required|max:255|unique:brands',
          'brand_description' => 'required|max:255',
          'publication_status' => 'required'
          ]);
        if ($validator->fails())
        {          
          return response()->json(['errors' => $validator->errors()]);
        }
      }  
      if($image)
      {
        $validator = \Validator::make($request->all(), [          
          'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048|image'     
          ],[
          'image.required'=>'Image format should be in jpeg,png,jpg,gif,svg',
          'image.uploaded'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048', 
        ]); 
        if ($validator->fails())
        {          
          return response()->json(['errors' => $validator->errors()]);
        }
      }

      if($validator->passes())
      {
        if($image)
        {  
          if(file_exists($brands->brand_image)){
            unlink($brands->brand_image);
            }
            /*$image_name=$required->product_id.$image->getClientOriginalExtension();
            $upload_path='public/image/';
            $image_url=$upload_path.$image_name;*/
            $image_name=str_random(20);
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='../img-file-manager/brand/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if($success){
              $brands->brand_image = $image_url;
             }
            $brands->brand_name = $request->brand_name;
            $brands->brand_description = $request->brand_description;
            $brands->publication_status = $request->publication_status;
            // $brands->timestamps = now();
            $is_saved = $brands->update();
            $tmessage = array('tmessage' => 'Brand Edited successfully');
            return response()->json($tmessage);             
        }
        else
        {
          $brands->brand_image = $request->image_update;       
          $brands->brand_name = $request->brand_name;
          $brands->brand_description = $request->brand_description;
          $brands->publication_status = $request->publication_status;
          // $brands->timestamps = now();
          $is_saved = $brands->update(); 
          $tmessage = array('tmessage' => 'Brand Updated successfully');
          return response()->json($tmessage);
        } 
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    { 
      $product = Product::where('brand_id' , $request->id)->first();
      if($product)
      {
        return response()->json(['errors' => 'Brand is added with products, can not delete']); 
      }
      else
      {
        $data = Brand::find($request->id);
        if(file_exists($data->brand_image))
        {
          unlink($data->brand_image);
          $data->delete();
          $tmessage = array('tmessage' => 'Brand deleted successfully');
          return response()->json($tmessage);
        }
      }
      
      
    }
    public function active($brand_id)
    {
      Brand::where('brand_id',$brand_id)->update(['publication_status' => 0]);
      $tmessage = array('tmessage' => 'Brand deactived successfully');
      return response()->json($tmessage);
    }
    public function deactive($brand_id)
    {      
      Brand::where('brand_id',$brand_id)->update(['publication_status' => 1]);
      $tmessage = array('tmessage' => 'Brand actived successfully');
      return response()->json($tmessage);  
    } 
}
