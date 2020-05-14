<?php

namespace Grofie\Http\Controllers\admin;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Grofie\Unit;
use Grofie\Product;
use Validator;
use Session;
use DB;

class UnitController extends Controller
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
        $unites = Unit::orderBy('unit_id','DESC')->get();
        return view('admin_v2.settings.unit.index', ['unites' => $unites]);
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
            'unit_name_lm' => 'required|max:255|unique:units',
            'unit_name_sm' => 'required|max:255|unique:units',
            'unit_unit' => 'required'
        ]);
        
        if ($validator->fails())
        {
          return response()->json(['errors' => $validator->errors()]);
        }
     
       $unites = new unit;
       $unites->unit_name_lm = $request->unit_name_lm;
       $unites->unit_name_sm = $request->unit_name_sm;
       $unites->unit_unit = $request->unit_unit;
       $is_saved = $unites->save();

       if($is_saved){
        $tmessage = array('tmessage' => 'Tax added successfully');
        return response()->json($tmessage); 
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
    public function edit(Unit $unit)
    {
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $unit_id)
    {
        $unites = Unit::find($unit_id);

        if($unites->unit_name_lm == $request->unit_name_lm && $unites->unit_name_sm == $request->unit_name_sm)
        {
            $validator = \Validator::make($request->all(), [
                'unit_name_lm' => 'required|max:255',
                'unit_name_sm' => 'required|max:255',
                'unit_unit' => 'required'
            ]);
            if ($validator->fails())
            {
              return response()->json(['errors' => $validator->errors()]);
            }
        }
        else
        {
            $validator = \Validator::make($request->all(), [
                'unit_name_lm' => 'required|max:255|unique:units',
                'unit_name_sm' => 'required|max:255|unique:units',
                'unit_unit' => 'required'
            ]);
            if ($validator->fails())
            {
              return response()->json(['errors' => $validator->errors()]);
            } 
        }

       $unites->unit_name_lm = $request->unit_name_lm;
       $unites->unit_name_sm = $request->unit_name_sm;
       $unites->unit_unit = $request->unit_unit;
       $is_saved = $unites->update();

       if($is_saved){
        $tmessage = array('tmessage' => 'Units updated successfully');
        return response()->json($tmessage); 
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($unit_id)
    {
      $product_id = Product::where('unit_id' ,$unit_id)->first();
      if($product_id)
      {
        return response()->json(['errors' => 'Units is added with products, can not delete']); 
      }
      else
      {
        Unit::find($unit_id)->delete();
        $tmessage = array('tmessage' => 'Unit deleted successfully');
        return response()->json($tmessage);  
      }     
    }
}
