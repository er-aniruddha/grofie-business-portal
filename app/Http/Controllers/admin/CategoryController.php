<?php

namespace Grofie\Http\Controllers\admin;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Grofie\Category;
use Grofie\SubCategory;
use Grofie\Product;
use DB;
use Session;
use Validator;


class CategoryController extends Controller
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
        // $categories = Category::orderBy('category_id','DESC')->get();
        // return view('admin_v2.category.index', ['categories' => $categories]);
      if(request()->ajax())
        {
          return datatables()->of(Category::orderBy('category_id','DESC')->get())
                ->addColumn('action', function($data){
                  $button = '<button type="button" name="view" id="'.$data->category_id.'" data-name="'.$data->category_name.'" data-desc="'.$data->category_description.'" data-image="http://grofie.in/'.$data->image.'" data-status="'.$data->publication_status.'" class="view btn btn-outline btn-info btn-sm">View</button>';
                  $button .= '&nbsp;';
                  $button .= '<button type="button" name="edit" id="'.$data->category_id.'" data-name="'.$data->category_name.'" data-desc="'.$data->category_description.'" data-image="'.$data->image.'"
                    data-status="'.$data->publication_status.'" class="edit btn btn-outline btn-primary btn-sm">Edit</button>';
                  $button .= '&nbsp;';
                  $button .= '<button type="button" name="delete" data-id="'.$data->category_id.'" data-name="'.$data->category_name.'" data-url="' . route('category.delete') .'"  class="delete btn btn-outline btn-danger btn-sm">Del</button>';
                  return $button;
                })
                ->addColumn('status', function($data){
                  if( $data->publication_status == 1)
                  {
                     $status = '<button type="button" id="'.$data->category_id.'" data-url="' . route('category.active', $data->category_id) .'" class="active btn btn-success btn-xs">Active</button>';  
                  }
                  else
                  {
                    $status = '<button type="button" id="'.$data->category_id.'" data-url="' . route('category.deactive', $data->category_id) .'" class="deactive btn btn-danger btn-xs">Deactive</button type="button">';   
                  }
                  return $status;
                })
                ->addIndexColumn()
                ->rawColumns(['action' , 'status'])
                ->make(true);       
                    
        }        
        return view('admin_v2.category.index');
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
          'category_name' => 'required|max:255|unique:categories',
          'category_description' => 'required|max:255',
          'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048|image'
        ],[
          'image.required'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048',
          'image.uploaded'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        if ($validator->fails())
        {
          return response()->json(['errors' => $validator->errors()]);
        }
            
        $categories = new Category;
        $image = $request->file('image');
        if ($image){

          $image_name=str_random(20);
          $ext=strtolower($image->getClientOriginalExtension());
          $image_full_name=$image_name.'.'.$ext;
          $upload_path='../img-file-manager/category/';
          $image_url=$upload_path.$image_full_name;
          $success=$image->move($upload_path,$image_full_name);
          if($success){
            $categories->image=$image_url;
            $categories->category_name = $request->category_name;
           $categories->category_description = $request->category_description;
           $categories->publication_status = $request->publication_status;
         //  $categories->timestamps = now();
           $is_saved = $categories-> save();

           if($is_saved){
            $tmessage = array('tmessage' => 'Category created successfully');
            return response()->json($tmessage);  
    
           }
        }

       }
              
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
    public function edit(Category $category)
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
      $categories = Category::find($request->category_id);

      if($categories->category_name == $request->category_name)
      {
        $validator = \Validator::make($request->all(), [
          'category_name' => 'required|max:255',
          'category_description' => 'required|max:255',
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
          'category_name' => 'required|max:255|unique:categories',
          'category_description' => 'required|max:255',
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

        if($image){
          if(file_exists($categories->image)){
            unlink($categories->image);
            }
            /*$image_name=$required->product_id.$image->getClientOriginalExtension();
            $upload_path='public/image/';
            $image_url=$upload_path.$image_name;*/
            $image_name=str_random(20);
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='../img-file-manager/category/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if($success){
               $categories->image=$image_url;
             }
        }
        else{   
           $categories->image=$categories->image;
        }
           $categories->category_name = $request->category_name;
           $categories->category_description = $request->category_description;
           $categories->publication_status = $request->publication_status;
           $is_saved = $categories-> update();

          if($is_saved){
             $tmessage = array('tmessage' => 'Category Updated successfully');
            return response()->json($tmessage);  
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
      $product = Product::where('category_id' , $request->id)->first();
      $sub_cat = SubCategory::where('category_id' , $request->id)->first();
      if($product || $sub_cat)
      {
        return response()->json(['errors' => 'Category is added with products or sub-category, can not delete']); 
      }
      else
      {
        $data = Category::find($request->id);
        if(file_exists($data->image))
        {
          unlink($data->image);
          $data->delete();
          $tmessage = array('tmessage' => 'Category deleted successfully');
          return response()->json($tmessage);
        }
      }
      
    }

    public function active($category_id)
    {
      Category::where('category_id',$category_id)->update(['publication_status' => 0]);
      $tmessage = array('tmessage' => 'Category deactived successfully');
      return response()->json($tmessage);

    }

    public function deactive($category_id)
    {
      Category::where('category_id',$category_id)->update(['publication_status' => 1]);
      $tmessage = array('tmessage' => 'Category actived successfully');
      return response()->json($tmessage);     
      
    }
}
