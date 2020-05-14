@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Products')
@section('main_content')
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Products</h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Products
                    <button type="button" class="btn btn-primary btn-xs pull-right" name="add_product" id="add_product">Add Product</button>              
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="product_table">
                            <thead>
                                <tr>
                                    <th width="0.5%">SL</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Brand Name</th>
                                    <th>Buy Price</th>
                                    <th>% Offer</th>
                                    <th>Offer Price</th>
                                    <th>Sell/NRML Price</th>                                   
                                    <th>In Stock</th>
                                    <th width="2%">Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
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
@include('admin_v2.product.product_modal')
@include('admin_v2.layouts.modal')
<script>
$(document).ready(function(){
  var url;
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
/* Show Products Table Start */ 
 $('#product_table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{
   url: "{{ route('product.index') }}",
  },
  columns:[
   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
   {data: 'product_image_main', name: 'product_image_main', render: function(data, type, full, meta){
     return "<img src=http://grofie.in/" + data + " width='70' class='img-thumbnail' />";
     },orderable: false},
   {data: 'product_name', name: 'product_name' },
   {data: 'brand_name', name: 'brand_name'},
   {data: 'product_buy_price', name: 'product_buy_price'},
   {data: 'product_offers', name: 'product_offers'},
   {data: 'product_sell_price_after_offer', name: 'product_sell_price_after_offer'},
   {data: 'sell_price', name: 'sell_price'},
   {data: 'product_in_hand_stock', name: 'product_in_hand_stock'},
   {data: 'status', name: 'status', },
   {data: 'action', name: 'action', }, 
  ]});
/* Show Products Table End */
/* Add Modal Start */
$(document).on('click','#add_product',function(){  
  $('.modal-title').text("Add Product");
  $('#product_id').val("");
  $('#productModal').modal('show');
  $('#add_productBtn').show();
  $('#edit_productBtn').hide();
 });
/* Add Modal end */
/* Add Products Condition Start */
$('#productform').on('click','#add_productBtn', function(event){
  event.preventDefault()
  var postData = new FormData($("#productform")[0]);          
  $( '#name-error' ).html( "" );
  $( '#description-error' ).html( "" );
  $( '#image-error' ).html( "" );
  $( '#brand-error' ).html( "" );
  $( '#category-error' ).html( "" );
  $( '#sub-category-error' ).html( "" );
  $( '#unit-error' ).html( "" );
  $( '#buy-price-error' ).html( "" );
  $( '#buy-qty-error' ).html( "" );
  $( '#sell-price-error' ).html( "" );
  $( '#offer-error' ).html( "" );
  $( '#offer-price-error' ).html( "" );
  $( '#image1-error' ).html( "" );
  $( '#image2-error' ).html( "" );
  $( '#image3-error' ).html( "" );
  $( '#image4-error' ).html( "" );
  $( '#image5-error' ).html( "" );
  $( '#status-error' ).html( "" );
  $.ajax({
   type:'POST',
   url:"{{route('product.store')}}", 
   contentType: false,
   cache: false,
   processData: false,
   dataType:"json",
   data : postData,
      success:function(data) {
            console.log(data);
          if(data.errors) {
            $('.text-danger').show();
            if(data.errors.product_name){
                $( '#name-error' ).html( data.errors.product_name[0] );
            }
            if(data.errors.product_description){
                $( '#description-error' ).html( data.errors.product_description[0] );
            }   
            if(data.errors.image){
                $( '#image-error' ).html( data.errors.image[0] );
            }
            if(data.errors.brand_id){
                $( '#brand-error' ).html( data.errors.brand_id[0] );
            } 
            if(data.errors.category_id){
                $( '#category-error' ).html( data.errors.category_id[0] );
            } 
            if(data.errors.sub_cat_id){
                $( '#sub-category-error' ).html( data.errors.sub_cat_id[0] );
            }             
            if(data.errors.unit_id){
                $( '#unit-error' ).html( data.errors.unit_id[0] );
            }   
            if(data.errors.product_buy_price){
                $( '#buy-price-error' ).html( data.errors.product_buy_price[0] );
            } 
            if(data.errors.product_buy_qty){
                $( '#buy-qty-error' ).html( data.errors.product_buy_qty[0] );
            }
            if(data.errors.product_sell_price){
                $( '#sell-price-error' ).html( data.errors.product_sell_price[0] );
            } 
            if(data.errors.product_offers){
                $( '#offer-error' ).html( data.errors.product_offers[0] );
            } 
            // if(data.errors.product_sell_price_after_offer){
            //     $( '#offer-price-error' ).html( data.errors.product_sell_price_after_offer[0] );
            // }
            if(data.errors.image1){
                $( '#image1-error' ).html( data.errors.image1[0] );
            }
            if(data.errors.image2){
                $( '#image2-error' ).html( data.errors.image2[0] );
            }
            if(data.errors.image3){
                $( '#image3-error' ).html( data.errors.image3[0] );
            }
            if(data.errors.image4){
                $( '#image4-error' ).html( data.errors.image4[0] );
            } 
            if(data.errors.image5){
                $( '#image5-error' ).html( data.errors.image5[0] );
            }

             if(data.errors.product_stat){
                $( '#status-error' ).html( data.errors.product_stat[0] );
            }                
          }
          if(data.tmessage){  
             $('#productModal').modal('hide');
             $("#productform")[0].reset();               
             $('#show-img').removeAttr('src'); 
             $('#show-img').removeAttr('style');           
             // $("#dataTables-example").load(window.location + " #dataTables-example");  
             $('#product_table').DataTable().ajax.reload(); 
             toastr.options.progressBar = true;
             toastr.options.timeOut = 2000; 
             toastr.success(data.tmessage)
          }
        },
      }); 
});
/* Add Products Condition End */

/* Delete Product Table Start */
$(document).on('click', '.delete', function(event){
  event.preventDefault()  
  $('.modal-title').text($(this).data('name'));
  $('.text-danger').hide();
  url = $(this).data('url');
  $('#ok_button').text('YES');
  $('#confirmModal').modal('show');
});
$('#confirmModal').on('click', '#ok_button', function(event){
  event.preventDefault() 
  $( '#del-error' ).html( "" );
  $.ajax({
   type:'GET',
   url:url,
   processData: false,
   contentType: false,
   beforeSend:function(){
    $('#ok_button').text('Deleting...');
   },
    success:function(data) { 
    if(data.errors)
      {
        $('.text-danger').show();  
        $('#ok_button').text('YES');
        $('#del-error').html( data.errors);
      }     
      if(data.tmessage)
      {
        setTimeout(function(){   
          $('#confirmModal').modal('hide');
          $('#product_table').DataTable().ajax.reload(); 
          toastr.options.progressBar = true;
          toastr.options.timeOut = 2000; 
          toastr.error(data.tmessage)                                      
        }, 2000);  
      }      
    },   
  });   
});
/* Delete Product Table End */ 


});
</script>
@endsection