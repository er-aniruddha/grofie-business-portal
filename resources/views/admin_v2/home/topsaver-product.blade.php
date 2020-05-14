@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Home/Top-Savers')
@section('main_content')
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Apps/Home/Page/Top/Savers</h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">            	
                <div class="panel-heading">
                    Apps/Home/Page/Top/Savers
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="pro-list">
                       <!-- <input type="text" placeholder="Search Your Product"><input type="submit" value="search"> -->
                    <form action="{{url('/admin/home/new/product/add')}}" method="POST">
            		@csrf
                        <select class="product-list" name="product_id" multiple="multiple">
                            <option value="AL">Select</option>
                            @foreach($products as $product)  
                            	@if($product->product_stat == 1 && $product->product_in_hand_stock > 1)     
			                		<option value="{{$product->product_id}}">{{$product->product_name}}</option>
			                	@endif
			                @endforeach
                        </select>
                        <button class="btn btn-success" type="submit">Add</button>
                    </form>
                    </div>    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="brand_table">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Product Name</th>
                                    <th>Sell Price</th>
                                    <th>Offers</th>
                                    <th>Offer Price</th>
                                    <th>In Hnad Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=1; ?>                
			                @foreach( $products as  $product)
				                @if($product->home_show_stat == 1) 
		                        	<tr>
		                        		<td>{{ $i++ }}</td>
						                <td>{{ $product->product_name}}</td>
						                <td>{{ $product->product_sell_price}}</td>
						                <td>{{ $product->product_offers}}</td>
						                <td>{{ $product->product_sell_price_after_offer}}</td>
						                <td>{{ $product->product_in_hand_stock}}</td>
						                <td>						               	
						                <a type="button" href="{{route('apps.home.page.new.product.del',$product->product_id)}}" class="btn btn-info">Remove
						                </a>
						                @if($product->product_stat == 1)
						                <button type="button" class="btn btn-success">Active</button>   
						                @else
						                <button type="button" class="btn btn-danger">Deactivate</button>   
						                @endif 
		                        	</tr>
								@endif            
              				@endforeach                           
                            </tbody>
                        </table>
                    </div>                          
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.row -->
</div>
@endsection