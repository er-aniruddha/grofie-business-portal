@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Products \ View')
@section('main_content')
<div id="page-wrapper" style="min-height: 626px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{$products->product_name}}</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$products->product_name}} Details
                         <a type="button" class="btn btn-outline btn-primary btn-xs pull-right" href="{{route('product.index')}}">Back</a>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">                               
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" value="{{$products->product_name}}">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="3">{{$products->product_description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <input class="form-control" value="{{$products->category_name}}">
                                </div>
                                <div class="form-group">
                                    <label>Sub-Category</label>
                                    <input class="form-control" value="{{$products->sub_cat_name}}">
                                </div>
                                <div class="form-group">
                                    <label>Brand Name</label>
                                    <input class="form-control" value="{{$products->brand_name}}">
                                </div>
                                <div class="form-group">
                                    <label>Unit</label>
                                    <input class="form-control" value="{{$products->unit_name_lm}}">
                                </div>  
                                <div class="form-group col-lg-4 has-success">
                                    <label class="control-label" for="inputSuccess">Last Buy Price</label>
                                    <input class="form-control" value="{{$products->product_buy_price}}">
                                </div> 
                                <div class="form-group col-lg-4 has-success">
                                    <label class="control-label" for="inputSuccess">Last Buy Date</label>
                                    <input class="form-control" value="{{$products->product_buy_date}}">
                                </div>    
                                <div class="form-group col-lg-3 has-success">
                                    <label class="control-label" for="inputSuccess">Last Buy Qty</label>
                                    <input class="form-control" value="{{$products->product_buy_qty}}">
                                </div>
                                <div class="form-group col-lg-4 has-warning">
                                    <label class="control-label" for="inputWarning">Sell/MRP Price</label>
                                    <input class="form-control" value="{{$products->product_sell_price}}">
                                </div> 
                                <div class="form-group col-lg-4 has-warning">
                                    <label class="control-label" for="inputWarning">% Offer</label>
                                    <input class="form-control" value="{{$products->product_offers}}">
                                </div>    
                                <div class="form-group col-lg-3 has-warning">
                                    <label class="control-label" for="inputWarning">Offer Price</label>
                                    <input class="form-control" value="{{$products->product_sell_price_after_offer}}">
                                </div>     
                            </div>
                            <!-- /.col-lg-6 (nested) -->
                            <div class="col-lg-6">
                                <div class="gallery">
                                  <a target="_blank" href="http://grofie.in/{{$products->product_image_main}}">
                                    <img src="http://grofie.in/{{$products->product_image_main}}">
                                  </a>
                                  <div class="desc">Main Image</div>
                                </div> 
                                <div class="gallery">
                                  <a target="_blank" href="http://grofie.in/{{$products->product_image1}}">
                                    <img src="http://grofie.in/{{$products->product_image1}}">
                                  </a>
                                  <div class="desc">Slide Image One</div>
                                </div>     
                                <div class="gallery">
                                  <a target="_blank" href="http://grofie.in/{{asset($products->product_image2)}}">
                                    <img src="http://grofie.in/{{asset($products->product_image2)}}">
                                  </a>
                                  <div class="desc">Slide Image Two</div>
                                </div>                              
                                <div class="gallery">
                                  <a target="_blank" href="http://grofie.in/{{asset($products->product_image3)}}">
                                    <img src="http://grofie.in/{{asset($products->product_image3)}}">
                                  </a>
                                  <div class="desc">Slide Image Three</div>
                                </div> 
                                <div class="gallery">
                                  <a target="_blank" href="http://grofie.in/{{$products->product_image4}}">
                                    <img  src="http://grofie.in/{{$products->product_image4}}">
                                  </a>
                                  <div class="desc">Slide Image Four</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if($products->cgst_rate>0)
                                        <div class="form-group col-lg-3 has-error">
                                            <label class="control-label" for="inputError">CGST Rate</label>
                                            <input class="form-control" value="{{$products->cgst_rate}}">
                                        </div>
                                        @endif
                                        @if($products->sgst_rate>0)
                                        <div class="form-group col-lg-3 has-error">
                                            <label class="control-label" for="inputError">SGST Rate</label>
                                            <input class="form-control" value="{{$products->sgst_rate}}">
                                        </div> 
                                        @endif 
                                        @if($products->igst_rate>0)
                                        <div class="form-group col-lg-3 has-error">
                                            <label class="control-label" for="inputError">IGST Rate</label>
                                            <input class="form-control" value="{{$products->igst_rate}}">
                                        </div>
                                        @endif
                                        @if($products->ugst_rate>0)
                                        <div class="form-group col-lg-3 has-error">
                                            <label class="control-label" for="inputError">UGST Rate</label>
                                            <input class="form-control" value="{{$products->ugst_rate}}">
                                        </div>
                                        @endif 
                                        @if($products->cgst_amount>0)
                                        <div class="form-group col-lg-4 has-error">
                                            <label class="control-label" for="inputError">CGST Amount</label>
                                            <input class="form-control" value="{{$products->cgst_amount}}">
                                        </div>
                                        @endif
                                        @if($products->sgst_amount>0)
                                        <div class="form-group col-lg-4 has-error">
                                            <label class="control-label" for="inputError">SGST Amount</label>
                                            <input class="form-control" value="{{$products->sgst_amount}}">
                                        </div> 
                                        @endif 
                                        @if($products->igst_amount>0)
                                        <div class="form-group col-lg-4 has-error">
                                            <label class="control-label" for="inputError">IGST Amount</label>
                                            <input class="form-control" value="{{$products->igst_amount}}">
                                        </div>
                                        @endif
                                        @if($products->ugst_amount>0)
                                        <div class="form-group col-lg-4 has-error">
                                            <label class="control-label" for="inputError">UGST Amount</label>
                                            <input class="form-control" value="{{$products->ugst_amount}}">
                                        </div>
                                        @endif
                                        <div class="form-group col-lg-4 has-error">
                                            <label class="control-label" for="inputError">Ex. GST Price</label>
                                            <input class="form-control" value="{{$products->product_sell_price_ex_gst}}">
                                        </div>
                                        <div class="form-group col-lg-5 has-error">
                                            <label class="control-label" for="inputError">Ex. GST Offer Price</label>
                                            <input class="form-control" value="{{$products->product_sell_price_after_offer_ex_gst}}">
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>Total Orders</label>
                                            <input class="form-control" value="{{$products->product_order_qty}}">
                                        </div> 
                                        <div class="form-group col-lg-4">
                                            <label>Total Delivered</label>
                                            <input class="form-control" value="{{$products->product_delivered_qty}}">
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>In Hand Stocks</label>
                                            <input class="form-control" value="{{$products->product_in_hand_stock}}">
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-lg-6 (nested) -->
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection