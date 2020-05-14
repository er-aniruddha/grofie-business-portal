@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Orders')
@section('main_content')
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row ordering">
        <div class="col-lg-12" >
        	<h1 class="page-header">Orders         		
        		@if($user_details->order_stat == 2)
        		<button type="button" class="btn btn-warning pull-right">Out for Delivery</button>
        		@elseif($user_details->order_stat == 3)	
        		<button type="button" class="btn btn-deactive pull-right">Delivered</button>        	
        		@else
        		<button type="button" class="dispatched btn btn-outline btn-info pull-right" id="{{$user_details->order_id}}">Dispatched</button>
        		@endif
        	</h1> 
        </div>
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Invoice       
                    @if($user_details->delivery_date)
                    <p class="pull-right text-default">
                        <em>Delivery Date : {{$user_details->delivery_date}}</em>
                    </p>  
                    @endif           
                </div>
                <div class="panel-body">
                	<div class="col-lg-8">
                	<address>
                        <strong>Full Name</strong>
                        <br>
                       	{{$user_details->f_name.' '.$user_details->s_name}}
                        <br>
                        <strong>Mobile No</strong>                      	
                        <br>
                        {{$user_details->phone}}	
                        <br>
                        {{$user_details->alt_phone}}
                    </address>
                	</div>
                	<div class="col-lg-4">
                    <address>
                        <strong>Address</strong>
                        <br>{{$user_details->place_name}}, {{$user_details->select_city}} 
                        <br>
                        Location : <em>{{$user_details->lat}},{{$user_details->long}}</em>
                        <br>
                        Distance : <em>{{round($user_details->distance/2000)}} km</em>
                        <br>
                        Duration : <em>{{round($user_details->duration/120)}} min</em>                        
                      <!--   <abbr title="Phone">Alt Phone :</abbr>{{$user_details->place_name}} -->
                    </address>
                	</div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->    
        </div>   
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Order Details
                    <p class="pull-right text-default">
                        <em>Order Date : {{$user_details->order_date}}</em>
                    </p>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="ordering_table">
                            <thead>
                                <tr>
                                    <th># Order ID</th>
                                    <th>Product Name</th>
                                    <th>Brand Name</th>
                                    <th>Qty</th>
                                    <th>Sell Price</th>
                                    <th>Offer Price</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php               
                             $i = 0;
                             $subtotal=0;
                            @endphp

                        	@foreach($order_details as $v_details)

                            @if($i != $v_details->order_id)
                            @php
                              $i = $v_details->order_id;
                              $delCharges = $v_details->delivery_charges;
                              $delKmCharges = $v_details->delivery_km_charges;
                            @endphp 
                            @endif
                           	<tr>
                                <td>#{{ $v_details->order_id }}</td>
                                <td>{{ $v_details->product_name }}</td>
                                <td>{{ $v_details->brand_name }}</td>
                                <td>{{ $v_details->qty }}</td>
                                <td>{{ $v_details->product_sell_price }}</td>
                                <!-- offer price condition -->
                                @if($v_details->product_sell_price_after_offer>0)
                                <td>{{ $v_details->product_sell_price_after_offer }}</td>
                                @else
                                <td>N/A</td>
                                @endif
                               <!--  has offer price then add condition -->
                                @if($v_details->product_sell_price_after_offer>0)
                                <td>{{ $v_details->product_sell_price_after_offer * $v_details->qty}}</td>
                                @else
                                <td>{{ $v_details->product_sell_price * $v_details->qty}}</td>
                                @endif
                                <!-- status check -->
                                @if($v_details->order_stat == 1)
                                <td>
                                <button type="button" class="btn btn-outline btn-success btn-xs">Active</button>
                                </td>
                                @elseif($v_details->order_stat == 0)
                                <td>
                                <button type="button" class="btn btn-outline btn-danger btn-xs">Cancel</button>
                                </td>
                                @elseif($v_details->order_stat == -1)
                                <td>
                                <button type="button" class="btn btn-outline btn-warning btn-xs">Return</button>
                                </td>
                                @elseif($v_details->order_stat == 2)
                                <td>
                                <button type="button" class="btn btn-outline btn-info btn-xs">Dispatched</button>
                                </td>
                                 @elseif($v_details->order_stat == 3)
                                <td>
                                <button type="button" class="btn btn-outline btn-deactive btn-xs">Delivered</button>
                                </td>
                                @endif
                            </tr>
                            <!-- Sub Total Calculation -->
                            @php
                            if($v_details->order_stat != 0  && $v_details->order_stat != -1)
                            {
                                if($v_details->offers > 0)
                                {
                                    $subtotal = $subtotal + ($v_details->product_sell_price_after_offer * $v_details->qty);
                                }
                                else
                                {
                                    $subtotal = $subtotal + ($v_details->product_sell_price * $v_details->qty);
                                }
                            
                            }                        	 	
                            @endphp

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>            
            </div>
        </div>  
        <div class="row">
            <div class="col-lg-12">
            <div class="col-lg-7">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                       Delivery Associates
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group-item">
                          <strong>Name : </strong>
                          @if($associate)
                          <span class="pull-right text-danger">{{$associate->f_name.' '.$associate->s_name}}</span>
                          @else
                          <span class="pull-right text-danger">Not Assign</span>
                          @endif
                        </div>
                           @if(!$user_details->delivery_associates_id) 
                        <div class="list-group-item">
                          <strong>Partner : </strong>
                          <select class="form-control" name="delivery" id="delivery" value="">
                            <option selected="selected" value="0">Select Associate</option>
                            @foreach($select_associates as $select_associate)
                                <option value="{{$select_associate->id}}">{{$select_associate->f_name.' '.$select_associate->s_name}}</option>
                            @endforeach
                            </select>
                        </div>
                            @endif
                    </div>
                </div>  
            </div>
            <div class="col-lg-5">
                <div class="panel panel-green">
                    <div class="panel-heading">
                       Total
                    </div>
                    <!-- /.panel-heading -->
                      <div class="panel-body">
                        <div class="list-group-item">
                          <strong> Subtotal : </strong>
                          <span class="pull-right text-danger">{{$subtotal}}</span>
                        </div>
                        <div class="list-group-item">
                          <strong> Delivery Charges on Amount : </strong>
                          @if( $subtotal == 0 )
                          <span class="pull-right text-success">Cancelled/Returned</span>
                          @else
                          <span class="pull-right text-success">{{$delCharges}}</span>
                          @endif
                        </div>
                        <div class="list-group-item">
                          <strong> Delivery Charges on KM : </strong>
                          @if( $subtotal != 0 )
                          <span class="pull-right text-success">{{$delKmCharges}}</span>
                          @endif
                        </div>
                        
                        <div class="list-group-item">
                          <strong> Total : </strong>
                          <span class="pull-right text-primary">{{$subtotal + $delCharges + $delKmCharges}}</span>
                        </div>
                    </div>
                </div>  
            </div>
       
        </div>
            
        </div>
        
    </div><!-- row -->
  </div>
</div>
<script> 
$(document).ready(function(){  
var associates_id;   
$('#delivery').on('change', function () {
    associates_id = $(this).val();        
});
$(document).on('click','.dispatched',function(event){
  event.preventDefault() 
  var url = "{{url('/')}}/admin/orders/dispatched/"+$(this).attr('id')+"/"+associates_id;   
  // console.log(url);
  $.ajax({
    type:'GET',
    url: url, 
    success:function(data) {   
        console.log(data)
        if(data.errors){ 
            toastr.error(data.errors); 
        }	
        if(data.tmessage)
        { 
          	// $(".ordering").load(" .ordering");             
            $(".ordering").load(window.location + " .ordering");  
            toastr.options.progressBar = true;
            toastr.options.timeOut = 2000; 
            toastr.success(data.tmessage); 
        }       
    }, 
  }); 
});
});
</script>
@endsection
