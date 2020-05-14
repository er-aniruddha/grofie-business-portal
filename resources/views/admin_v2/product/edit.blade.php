@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Products \ View')
@section('main_content')

<div id="page-wrapper" style="min-height: 626px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit : {{$products->product_name}}</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <form method="POST" action="{{route('product.update',$products->product_id)}}" enctype="multipart/form-data" name="productEditform">
        	@method('PATCH')
           @csrf 
        <div class="row">
            <div class="col-lg-12">   
                <div class="panel panel-default">
                    <div class="panel-heading">
                     {{$products->product_name}}
                         <a type="button" class="btn btn-outline btn-primary btn-xs pull-right" href="{{route('product.index')}}">Back</a>
                    </div>
                    <div class="panel-body">
                	<div class="row">
			       	<div class="col-lg-12">
			       		<div class="form-group">
			              <label for="product_name">Product Name</label>
			              <input type="text" class="form-control" name="product_name" value="{{$products->product_name}}">
			              <h6 class="text-danger">
			                <strong id="name-error"></strong>
			              </h6>
		               	@error('product_name')
			               	<h6 class="text-danger">
			                	<strong>{{ $message }}</strong>
			              	</h6>
		                @enderror
			            </div>
			            <div class="form-group">
		                  <label for="product_description">Product Description</label>                  
		                  <input type="text" class="form-control" name="product_description"  value="{{$products->product_description}}">
		                @error('product_name')
			               	<h6 class="text-danger">
			                	<strong>{{ $message }}</strong>
			              	</h6>
		                @enderror
			            </div>
			            <div class="loader"></div>
			         	<div class="gallery">
						  <a target="_blank" href="http://grofie.in/{{$products->product_image_main}}">
						    <img src="http://grofie.in/{{$products->product_image_main}}" id="img">
						  </a>
						  <div class="desc">Main Image One</div>
						  <input type="file" name="image" onchange="imagex(this);"/> 

						  <button type="button" class="del-img btn btn-danger btn-xs" data-url="{{route('product.image.delete',[ $products->product_id , 0])}}">Remove</button>
					
						@error('image')
			               	<h6 class="text-danger">
			                	<strong>{{ $message }}</strong>
			              	</h6>
		                @enderror
						</div> 
						<div class="gallery">
						  <a target="_blank" href="http://grofie.in/{{$products->product_image1}}">
						    <img src="http://grofie.in/{{$products->product_image1}}" id="img1">
						  </a>
						  <div class="desc">Slide Image One</div>
						  <input type="file" name="image1" onchange="imagex1(this);"/> 
						  <button type="button" class="del-img btn btn-danger btn-xs" data-url="{{route('product.image.delete',[ $products->product_id , 1])}}">Remove</button>
					
						  @error('image1')
			               	<h6 class="text-danger">
			                	<strong>{{ $message }}</strong>
			              	</h6>
		                @enderror
						</div>     
						<div class="gallery">
						  <a target="_blank" href="http://grofie.in/{{$products->product_image2}}">
						    <img src="http://grofie.in/{{$products->product_image2}}" id="img2">
						  </a>
						  <div class="desc">Slide Image Two</div>
						  <input type="file" name="image2" onchange="imagex2(this);"/>
						  <button type="button" class="del-img btn btn-danger btn-xs" data-url="{{route('product.image.delete',[ $products->product_id , 2])}}">Remove</button>
						  @error('image2')
			               	<h6 class="text-danger">
			                	<strong>{{ $message }}</strong>
			              	</h6>
		                @enderror 
						</div>                      		
						<div class="gallery">
						  <a target="_blank" href="http://grofie.in/{{$products->product_image3}}">
						    <img src="http://grofie.in/{{$products->product_image3}}" id="img3">
						  </a>
						  <div class="desc">Slide Image Three</div>
						  <input type="file" name="image3" onchange="imagex3(this);"/>
						  <button type="button" class="del-img btn btn-danger btn-xs" data-url="{{route('product.image.delete',[ $products->product_id , 3])}}">Remove</button>
						  @error('image3')
			               	<h6 class="text-danger">
			                	<strong>{{ $message }}</strong>
			              	</h6>
		                @enderror 
						</div> 
						<div class="gallery">
						  <a target="_blank" href="http://grofie.in/{{$products->product_image4}}">
						    <img  src="http://grofie.in/{{$products->product_image4}}" id="img4">
						  </a>
						  <div class="desc">Slide Image Four</div>	
						  <input type="file" name="image4" onchange="imagex4(this);"/>
						  <button type="button" class="del-img btn btn-danger btn-xs" data-url="{{route('product.image.delete',[ $products->product_id , 4])}}">Remove</button>
						  @error('image4')
			               	<h6 class="text-danger">
			                	<strong>{{ $message }}</strong>
			              	</h6>
		                @enderror 			  
						</div>
			       	</div>
			       </div>

				  <p class="text-danger">
	                <strong>Select</strong>
	              </p>

	              <div class="row">
	                <div class="col-lg-12">
	      				<div class="col-lg-6">
		      			  <div class="form-group">
		                    <label>Brands</label>
		                    <select class="form-control" name="brand_id" id="brand_id" style="width: 100%;">
		                      <option selected="selected" value="0">Select Brand</option>
		                        @if ( $brands)
		                          @foreach( $brands as  $brand)
		                            @if($brand->publication_status == 1)
		                              <option value="{{ $brand->brand_id}}">{{ $brand->brand_name}}</option>
		                            @else
		                              <option value="{{ $brand->brand_id}}" disabled="disabled">{{ $brand->brand_name}}</option>
		                            @endif
		                          @endforeach
		                        @endif
		                    </select>
		                    @error('brand_id')
			               	<h6 class="text-danger">
			                	<strong>{{ $message }}</strong>
			              	</h6>
		                	@enderror 
		                  </div>
		            
		                  <div class="form-group">
		                    <label>Category</label>
		                    <select class="form-control" name="category_id">
		                      <option selected="selected" value="0">Select Category</option>
		                      @if ( $categories)
		                      @foreach( $categories as  $category)
		                      @if($category->publication_status == 1)
		                      <option value="{{ $category->category_id}}" >{{ $category->category_name}}</option>
		                      @else
		                      <option value="{{ $category->category_id}}" disabled="disabled">
		                        {{ $category->category_name}}</option>
		                      @endif  
		                      @endforeach
		                      @endif
		                    </select>  
		                    @error('category_id')
			               	<h6 class="text-danger">
			                	<strong>{{ $message }}</strong>
			              	</h6>
		                	@enderror  
		                  </div>
	      				</div>
		      			<div class="col-lg-6">
		                    <div class="form-group">
		                      <label>Unit</label>
		                      <select class="form-control select2" name="unit_id">
		                        <option selected="selected" value="0">Select Unit</option>
		                        @if ( $unites)
		                        @foreach( $unites as  $unit)
		                        <option value="{{ $unit->unit_id}}" >{{ $unit->unit_name_lm}}</option>
		                        @endforeach
		                        @endif
		                      </select>
		                      @error('unit_id')
				               	<h6 class="text-danger">
				                	<strong>{{ $message }}</strong>
				              	</h6>
			                  @enderror  
		                    </div> 
			                 <div class="form-group">
			                    <label>Sub-Category</label>
			                    <select class="form-control" name="sub_cat_id">
			                      <option selected="selected" value="0">Select Sub-Category</option>
			                      @if ( $sub_categories)
			                      @foreach( $sub_categories as  $sub_category)
			                      @if($sub_category->publication_status == 1)
			                      <option value="{{ $sub_category->sub_cat_id}}" >{{ $sub_category->sub_cat_name}}</option>
			                      @else
			                      <option value="{{ $sub_category->sub_cat_id}}" disabled="disabled">
			                        {{ $sub_category->sub_cat_name}}</option>
			                      @endif  
			                      @endforeach
			                      @endif
			                    </select>  
			                    @error('sub_cat_id')
				               	<h6 class="text-danger">
				                	<strong>{{ $message }}</strong>
				              	</h6>
				              	@enderror  
			                  </div>
		                </div>  
		                	
	                </div>
	              
	              </div>
	              <p class="text-danger">
	                <strong>TAXES</strong>
	              </p>
	              <div class="row">
	                <div class="col-lg-6">                    
	                    <div class="form-group">
	                        <label>CGST</label>
	                      <select class="form-control" name="cgst_rate">
	                        <option selected="selected" value="0">Not Applicable</option>
	                        @if ( $taxes)
	                        @foreach( $taxes as  $tax)
	                        @if($tax->cgst_name)
	                        <option value="{{$tax->cgst_rate}}" >{{ $tax->cgst_name}}</option>
	                        @endif
	                        @endforeach
	                        @endif
	                      </select>                   
	                    </div>
	                     <div class="form-group">
	                      <label>SGST</label>
	                      <select class="form-control" name="sgst_rate">
	                        <option selected="selected" value="0">Not Applicable</option>
	                        @if ( $taxes)
	                        @foreach( $taxes as  $tax)
	                        @if($tax->sgst_name)
	                        <option value="{{ $tax->sgst_rate}}" >{{ $tax->sgst_name}}</option>
	                        @endif
	                        @endforeach
	                        @endif
	                      </select>
	                    </div>
	                </div>
	                <div class="col-lg-6">
	                     <div class="form-group">
	                      <label>IGST</label>
	                      <select class="form-control" name="igst_rate">
	                        <option selected="selected" value="0">Not Applicable</option>
	                        @if ( $taxes)
	                        @foreach( $taxes as  $tax)
	                        @if($tax->igst_name)
	                        <option value="{{ $tax->igst_rate}}" >{{ $tax->igst_name}}</option>
	                        @endif
	                        @endforeach
	                        @endif
	                      </select>
	                    </div>
	                     <div class="form-group">
	                      <label>UGST</label>
	                      <select class="form-control" name="ugst_rate">
	                        <option selected="selected" value="0">Not Applicable</option>
	                        @if ( $taxes)
	                        @foreach( $taxes as  $tax)
	                        @if($tax->ugst_name)
	                        <option value="{{ $tax->ugst_rate}}" >{{ $tax->ugst_name}}</option>
	                        @endif
	                        @endforeach
	                        @endif
	                      </select>
	                    </div>
	                </div>
	                
	              </div>                         
	              <div class="row">
	                <div class="col-lg-6">
	                  <div class="form-group">
	                    <label>Buy Price</label>
	                    <input class="form-control" type="number" min="1" name="product_buy_price" value="{{$products-> product_buy_price}}">
	                    @error('product_buy_price')
		               	<h6 class="text-danger">
		                	<strong>{{ $message }}</strong>
		              	</h6>
	                  	@enderror
	                  </div>
	                  <div class="form-group">
	                    <label>Buy Qty</label>
	                    <input class="form-control" type="number" min="0" name="product_buy_qty" value="0">
	                    @error('product_buy_qty')
		               	<h6 class="text-danger">
		                	<strong>{{ $message }}</strong>
		              	</h6>
	                  	@enderror
	                  </div>
	                   <div class="form-group">
	                    <label>Sell Price</label>
	                    <input class="form-control" type="number" min="1" name="product_sell_price" id="product_sell_price" value="{{$products->product_sell_price}}">
	                   @error('product_sell_price')
		               	<h6 class="text-danger">
		                	<strong>{{ $message }}</strong>
		              	</h6>
	                  	@enderror
	                  </div>
	                </div>
	                <div class="col-lg-6">
	                  <div class="form-group">
	                    <label>% Offer</label>
	                    <input class="form-control" type="number" min="0" name="product_offers" id="product_offers" value="{{$products->product_offers}}">
	                    @error('product_offers')
		               	<h6 class="text-danger">
		                	<strong>{{ $message }}</strong>
		              	</h6>
	                  	@enderror
	                  </div>
	                  <div class="form-group">
	                    <label>Offer Price</label>
	                    <input class="form-control" type="number" min="1" id="product_sell_price_after_offer" disabled="">
	                  </div>
	                  <div class="form-group status">
		                <label>Status</label><br>
		                @if($products->product_stat == 1)
		                <label class="radio-inline">
		                  <input type="radio" name="product_stat" id="product_stat" value="1" checked>Active
		                </label>
		                <label class="radio-inline">
		                  <input type="radio" name="product_stat" id="product_stat" value="2">Deactive
		                </label>
		                @else
		                <label class="radio-inline">
		                  <input type="radio" name="product_stat" id="product_stat" value="1">Active
		                </label>
		                <label class="radio-inline">
		                  <input type="radio" name="product_stat" id="product_stat" value="2" checked>Deactive
		                </label>
		                @endif
		                @error('product_stat')
		               	<h6 class="text-danger">
		                	<strong>{{ $message }}</strong>
		              	</h6>
	                  	@enderror              
		              </div>
	                </div>
	              </div>	              
		          <button type="submit" class="btn btn-success btn-lg btn-block">Update</button>
	          	  <a type="button" href="{{route('product.index')}}" class="btn btn-default btn-lg btn-block">Cancel</a>
	              
                           
                            <!-- /.col-lg-6 (nested) -->
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 11-->
         </form>   
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<script>
$(document).ready(function(){
$('.loader').hide();


document.forms['productEditform'].elements['brand_id'].value='{{ $products->brand_id }}'
document.forms['productEditform'].elements['category_id'].value='{{ $products->category_id }}'
document.forms['productEditform'].elements['sub_cat_id'].value='{{ $products->sub_cat_id }}'
document.forms['productEditform'].elements['unit_id'].value='{{ $products->unit_id }}'
document.forms['productEditform'].elements['cgst_rate'].value='{{ $products->cgst_rate }}'
document.forms['productEditform'].elements['sgst_rate'].value='{{ $products->sgst_rate }}'
document.forms['productEditform'].elements['igst_rate'].value='{{ $products->igst_rate }}'
document.forms['productEditform'].elements['ugst_rate'].value='{{ $products->ugst_rate }}'
document.forms['productEditform'].elements['product_stat'].value='{{ $products->product_stat }}'

$('#product_offers').keyup(function(){
	var product_offers = parseFloat($(this).val());
	var product_sell_price = parseFloat(document.getElementById('product_sell_price').value);
    document.getElementById('product_sell_price_after_offer').value = product_sell_price - (product_sell_price*product_offers)/100;
}); 
$('#product_sell_price').keyup(function(){
var product_sell_price = parseFloat($(this).val());
var product_offers = parseFloat(document.getElementById('product_offers').value);
    document.getElementById('product_sell_price_after_offer').value = product_sell_price - (product_sell_price*product_offers)/100;
});

$(document).on('click' , '.del-img' ,function(event){
	event.preventDefault()
	$('.gallery').hide();
	$('.loader').show();
	$.ajax({
		type :'GET',
		url : $(this).data('url'),
		dataType : 'json',
		success:function(data){
			console.log(data);
			if(data.success == 1)
			{
				 window.location.reload();
			}
		},
	});
});
});
</script>
<script>
function imagex(input) {
	if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    reader.onload = function (e) {
	        $('#img').attr('src', e.target.result);	            
	    };
	    reader.readAsDataURL(input.files[0]);
	}	
}
function imagex1(input) {
	if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    reader.onload = function (e) {
	        $('#img1').attr('src', e.target.result);	            
	    };
	    reader.readAsDataURL(input.files[0]);
	}	
}
function imagex2(input) {
	if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    reader.onload = function (e) {
	        $('#img2').attr('src', e.target.result);	            
	    };
	    reader.readAsDataURL(input.files[0]);
	}	
}
function imagex3(input) {
	if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    reader.onload = function (e) {
	        $('#img3').attr('src', e.target.result);	            
	    };
	    reader.readAsDataURL(input.files[0]);
	}	
}
function imagex4(input) {
	if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    reader.onload = function (e) {
	        $('#img4').attr('src', e.target.result);	            
	    };
	    reader.readAsDataURL(input.files[0]);
	}	
}   
</script>
@endsection