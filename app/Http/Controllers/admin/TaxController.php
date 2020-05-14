<?php

namespace Grofie\Http\Controllers\admin;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Grofie\Tax;
use Grofie\Product;
use Validator;
use Session;

class TaxController extends Controller
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

    public function index(Tax $tax)
    {
        $taxes = Tax::orderBy('tax_id','DESC')->get();
        return view('admin_v2.settings.tax.index', ['taxes' => $taxes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.settings.tax.index');
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
            'tax_id' => 'required|not_in:0',
            'tax_name' => 'required|max:255|unique:taxes,cgst_name|unique:taxes,sgst_name|unique:taxes,igst_name|unique:taxes,ugst_name',
            'tax_rate' => 'required|max:255|numeric',
        ],[
            'tax_id.not_in' =>'Please select a TAX category',
            'tax_rate.numeric' =>'Please insert a numeric value',
        ]);
        
        if ($validator->fails())
        {
          return response()->json(['errors' => $validator->errors()]);
        }
 
        if($request->tax_id == 1)
        {
           $taxes = new Tax;
           $taxes->cgst_name = 'CGST-'.$request->tax_name;
           $taxes->cgst_rate = $request->tax_rate;
           $is_saved = $taxes-> save();

           if($is_saved){
            $tmessage = array('tmessage' => 'Tax added successfully');
            return response()->json($tmessage); 
           }
        }
        if($request->tax_id == 2)
        {
           $taxes = new Tax;
           $taxes->sgst_name = 'SGST-'.$request->tax_name;
           $taxes->sgst_rate = $request->tax_rate;
           $is_saved = $taxes-> save();

           if($is_saved){
            $tmessage = array('tmessage' => 'Tax added successfully');
            return response()->json($tmessage); 
           }
        }
        if($request->tax_id == 3)
        {
           $taxes = new Tax;
           $taxes->igst_name = 'IGST-'.$request->tax_name;
           $taxes->igst_rate = $request->tax_rate;
           $is_saved = $taxes-> save();

           if($is_saved){
            $tmessage = array('tmessage' => 'Tax added successfully');
            return response()->json($tmessage); 
           }
        }
        if($request->tax_id == 4)
        {
           $taxes = new Tax;
           $taxes->ugst_name = 'UGST-'.$request->tax_name;
           $taxes->ugst_rate = $request->tax_rate;
           $is_saved = $taxes-> save();

           if($is_saved){
            $tmessage = array('tmessage' => 'Tax added successfully');
            return response()->json($tmessage); 
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
    public function edit(Tax $tax)
    {
         
         
        //  $tax = Tax::find($tax->tax_id);
        // return view('admin.settings.tax.edit', ['tax' => $tax]);
        //return view('admin.settings.tax.edit')->with(['modal' => $tax])->render();
        //return view('admin.tax.edit', ['tax' => $tax]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $tax_id)
    {
      $taxes = TAX::find($tax_id);

      if($taxes->cgst_name == 'CGST-'.$request->tax_name || $taxes->sgst_name == 'SGST-'.$request->tax_name || $taxes->igst_name == 'IGST-'.$request->tax_name || $taxes->ugst_name == 'UGST-'.$request->tax_name)
      {
        $validator = \Validator::make($request->all(), [   
            'tax_name' => 'required|max:255',
            'tax_rate' => 'required|max:255|numeric',
        ],[            
            'tax_rate.numeric' =>'Please insert a numeric value',
        ]);        
        if ($validator->fails())
        {
          return response()->json(['errors' => $validator->errors()]);
        }
      }
      else
      {
        $validator = \Validator::make($request->all(), [   
            'tax_name' => 'required|max:255|unique:taxes,cgst_name|unique:taxes,sgst_name|unique:taxes,igst_name|unique:taxes,ugst_name',
            'tax_rate' => 'required|max:255|numeric',
        ],[            
            'tax_rate.numeric' =>'Please insert a numeric value',
        ]);        
        if ($validator->fails())
        {
          return response()->json(['errors' => $validator->errors()]);
        }
      }

        if($request->tax_type_id == 1)
        {

           $taxes->cgst_name = $request->tax_name;
           $taxes->cgst_rate = $request->tax_rate;
           $is_saved = $taxes-> update();

           if($is_saved){
            $tmessage = array('tmessage' => 'Tax Updated successfully');
            return response()->json($tmessage); 
           }
        }
        if($request->tax_type_id == 2)
        {
         
           $taxes->sgst_name = $request->tax_name;
           $taxes->sgst_rate = $request->tax_rate;
           $is_saved = $taxes-> update();

           if($is_saved){
            $tmessage = array('tmessage' => 'Tax Updated successfully');
            return response()->json($tmessage); 
           }
        }
        if($request->tax_type_id == 3)
        {
         
           $taxes->igst_name = $request->tax_name;
           $taxes->igst_rate = $request->tax_rate;
           $is_saved = $taxes-> update();

           if($is_saved){
            $tmessage = array('tmessage' => 'Tax Updated successfully');
            return response()->json($tmessage); 
           }
        }
        if($request->tax_type_id == 4)
        {
          
           $taxes->ugst_name = $request->tax_name;
           $taxes->ugst_rate = $request->tax_rate;
           $is_saved = $taxes-> update();

           if($is_saved){
            $tmessage = array('tmessage' => 'Tax Updated successfully');
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
    public function destroy($tax_id)
    {      
      Tax::find($tax_id)->delete();
      $tmessage = array('tmessage' => 'Tax Deleted successfully');
      return response()->json($tmessage);         
    }

}
