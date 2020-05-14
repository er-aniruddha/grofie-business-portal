<?php

namespace Grofie\Http\Controllers\admin;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Grofie\Category;
use Grofie\Product;
use Grofie\SubCategory;


class SubCategoryController extends Controller
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
        $categories = Category::orderBy('category_id','ASC')->get();
        $sub_cat = SubCategory::join('categories','sub_categories.category_id','=','categories.category_id')
                                ->select(array('sub_categories.sub_cat_id','sub_categories.publication_status','sub_categories.sub_cat_name','sub_categories.sub_cat_description','sub_categories.sub_cat_image','categories.category_id','categories.category_name'))
                                ->orderBy('sub_cat_id','DESC')->get();
        if(request()->ajax())
        {
          return datatables()->of($sub_cat)
                ->addColumn('action', function($data){
                  $button = '<button type="button" name="view" id="'.$data->sub_cat_id.'" data-name="'.$data->sub_cat_name.'" data-desc="'.$data->sub_cat_description.'" data-image="'.asset($data->sub_cat_image).'" data-category="'.$data->category_name.'" data-status="'.$data->publication_status.'" class="view btn btn-outline btn-info btn-sm">View</button>';
                  $button .= '&nbsp;';
                  $button .= '<button type="button" name="edit" id="'.$data->sub_cat_id.'" data-name="'.$data->sub_cat_name.'" data-desc="'.$data->sub_cat_description.'" data-category="'.$data->category_name.'" data-image="'.$data->sub_cat_image.'"
                    data-status="'.$data->publication_status.'" class="edit btn btn-outline btn-primary btn-sm">Edit</button>';
                  $button .= '&nbsp;';
                  $button .= '<button type="button" name="delete" data-id="'.$data->sub_cat_id.'" data-name="'.$data->sub_cat_name.'" data-url="' . route('sub.category.delete') .'"  class="delete btn btn-outline btn-danger btn-sm">Del</button>';
                  return $button;
                })
                ->addColumn('status', function($data){
                  if( $data->publication_status == 1)
                  {
                     $status = '<button type="button" id="'.$data->sub_cat_id.'" data-url="' . route('sub.category.active', $data->sub_cat_id) .'" class="active btn btn-success btn-xs">Active</button>';  
                  }
                  else
                  {
                    $status = '<button type="button" id="'.$data->sub_cat_id.'" data-url="' . route('sub.category.deactive', $data->sub_cat_id) .'" class="deactive btn btn-danger btn-xs">Deactive</button type="button">';   
                  }
                  return $status;
                })
                ->addIndexColumn()
                ->rawColumns(['action' , 'status'])
                ->make(true);       
                    
        }        
        return view('admin_v2.sub_category.index',['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
          'sub_cat_name' => 'required|max:255|unique:sub_categories',
          'sub_cat_description' => 'required|max:255',
          'category_id' => 'required|not_in:0',     
          'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048|image'
        ],[

          'category_id.not_in'=>'Category not selected.',
          'image.required'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048',
          'image.uploaded'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        if ($validator->fails())
        {
          return response()->json(['errors' => $validator->errors()]);
        }
            
        $sub_categories = new SubCategory;
        $image = $request->file('image');
        if ($image){

          $image_name=str_random(20);
          $ext=strtolower($image->getClientOriginalExtension());
          $image_full_name=$image_name.'.'.$ext;
          $upload_path='../img-file-manager/sub_category/';
          $image_url=$upload_path.$image_full_name;
          $success=$image->move($upload_path,$image_full_name);
          if($success){
            $sub_categories->sub_cat_image=$image_url;
            $sub_categories->sub_cat_name = $request->sub_cat_name;
           $sub_categories->sub_cat_description = $request->sub_cat_description;
           $sub_categories->category_id = $request->category_id;
           $sub_categories->publication_status = $request->publication_status;
         //  $categories->timestamps = now();
           $is_saved = $sub_categories-> save();

           if($is_saved){
            $tmessage = array('tmessage' => 'Sub-Category created successfully');
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
    public function edit($id)
    {
        //
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
      $sub_categories = SubCategory::find($request->sub_cat_id);

      if($sub_categories->sub_cat_name == $request->sub_cat_name)
      {
        $validator = \Validator::make($request->all(), [
          'sub_cat_name' => 'required|max:255',
          'sub_cat_description' => 'required|max:255',
          'category_id' => 'required|not_in:0', 
          'publication_status' => 'required' 
        ],[

          'category_id.not_in'=>'Category not selected.',
        ]);
        if ($validator->fails())
        {          
          return response()->json(['errors' => $validator->errors()]);
        }
      }
      else
      {
        $validator = \Validator::make($request->all(), [
          'sub_cat_name' => 'required|max:255|unique:sub_categories',
          'sub_cat_description' => 'required|max:255',
          'category_id' => 'required|not_in:0',    
          'publication_status' => 'required'
          ],[
          'category_id.not_in'=>'Category not selected.',
        ]);
        if ($validator->fails())
        {          
          return response()->json(['errors' => $validator->errors()]);
        }
      }  

      if($image)
      {
        $validator = \Validator::make($request->all(), [          
          'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048|image',      
          ],
          [
          'image.required'=>'Image format should be in jpeg,png,jpg,gif,svg',
          'image.uploaded'=>'Image format should be in jpeg,png,jpg,gif,svg|max:2048', 
        ]); 
        if ($validator->fails())
        {          
          return response()->json(['errors' => $validator->errors()]);
        }
      } 

        if($image){
          if(file_exists($sub_categories->sub_cat_image)){
            unlink($sub_categories->sub_cat_image);
            }
            /*$image_name=$required->product_id.$image->getClientOriginalExtension();
            $upload_path='public/image/';
            $image_url=$upload_path.$image_name;*/
            $image_name=str_random(20);
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='../img-file-manager/sub_category/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if($success){
               $sub_categories->sub_cat_image=$image_url;
             }
        }
        else{   
           $sub_categories->sub_cat_image=$sub_categories->sub_cat_image;
        }
           $sub_categories->sub_cat_name = $request->sub_cat_name;
           $sub_categories->sub_cat_description = $request->sub_cat_description;
           $sub_categories->category_id = $request->category_id;
           $sub_categories->publication_status = $request->publication_status;
           $is_saved = $sub_categories-> update();

          if($is_saved){
             $tmessage = array('tmessage' => 'Sub-Category Updated successfully');
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
          $product = Product::where('sub_cat_id' , $request->id)->first();
          if($product)
          {
            return response()->json(['errors' => 'Sub-Category is added with products, can not delete']); 
          }
          else
          {
            $data = SubCategory::find($request->id);
            if(file_exists($data->sub_cat_image))
            {
              unlink($data->sub_cat_image);
              $data->delete();
              $tmessage = array('tmessage' => 'Sub-Category deleted successfully');
              return response()->json($tmessage);
            }
          }
    }
    public function active($sub_cat_id)
    {
      SubCategory::where('sub_cat_id',$sub_cat_id)->update(['publication_status' => 0]);
      $tmessage = array('tmessage' => 'Sub-Category deactived successfully');
      return response()->json($tmessage);

    }

    public function deactive($sub_cat_id)
    {
      SubCategory::where('sub_cat_id',$sub_cat_id)->update(['publication_status' => 1]);
      $tmessage = array('tmessage' => 'Sub-Category actived successfully');
      return response()->json($tmessage);     
      
    }
}
