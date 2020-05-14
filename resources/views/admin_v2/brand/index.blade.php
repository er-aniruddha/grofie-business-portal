@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Brands')
@section('main_content')
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Brands</h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Brands
                    <button type="button" class="btn btn-primary btn-xs pull-right" name="add_brand" id="add_brand">Add Brand</button>              
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="brand_table">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Image</th>
                                    <th>Brand Name</th>
                                    <th>Brand Description</th>
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
@include('admin_v2.brand.brand_modal')
@include('admin_v2.layouts.modal')
<script>

$(document).ready(function(){
var img; /* This variable is used for show image*/
var confirmUrl; /* This variable is used for passsing */
var i;
/* Modal Close Button*/
$(document).on('click','#closBtn',function(){
  $('#brandform')[0].reset();
  $('.text-danger').hide();
  $('#show-img').removeAttr('src'); 
  $('#show-img').removeAttr('style');
  $('#add_brandBtn').show();
  $('#image').show();
  $('.status').show();
});
/* Show Brand Table Start */ 
 $('#brand_table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{
   url: "{{ route('brand.index') }}",
  },
  columns:[
   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
   {data: 'brand_image', name: 'brand_image', render: function(data, type, full, meta){
     return "<img src=http://grofie.in/" + data + " width='70' class='img-thumbnail' />";
     },orderable: false},
   {data: 'brand_name', name: 'brand_name' },
   {data: 'brand_description', name: 'brand_description'},
   {data: 'status', name: 'status', },
   {data: 'action', name: 'action', }, 
  ]});
/* Show Brand Table End */
/* Add Modal Start */
$(document).on('click','#add_brand',function(){  
  $('.modal-title').text("Add Brand");
  $('#brand_id').val("");
  $('#brandModal').modal('show');
  $('#add_brandBtn').show();
  $('#edit_brandBtn').hide();
 });
/* Add Modal end */
/* Add Brand Condition Start */
$('#brandform').on('click','#add_brandBtn', function(event){
  event.preventDefault()
  var postData = new FormData($("#brandform")[0]);          
  $( '#name-error' ).html( "" );
  $( '#description-error' ).html( "" );
  $( '#image-error' ).html( "" );
  $( '#status-error' ).html( "" );
  $.ajax({
   type:'POST',
   url:"{{ route ('brand.store')}}", 
   contentType: false,
   cache: false,
   processData: false,
   dataType:"json",
   data : postData,
      success:function(data) {             
          if(data.errors) {
            $('.text-danger').show();
            if(data.errors.brand_name){
                $( '#name-error' ).html( data.errors.brand_name[0] );
            }
            if(data.errors.brand_description){
                $( '#description-error' ).html( data.errors.brand_description[0] );
            }   
             if(data.errors.image){
                $( '#image-error' ).html( data.errors.image[0] );
            }  
             if(data.errors.publication_status){
                $( '#status-error' ).html( data.errors.publication_status[0] );
            }                
          }
          else {  
               $('#brandModal').modal('hide');
               $("#brandform")[0].reset();               
               $('#show-img').removeAttr('src'); 
               $('#show-img').removeAttr('style');           
               // $("#dataTables-example").load(window.location + " #dataTables-example");  
               $('#brand_table').DataTable().ajax.reload(); 
               toastr.options.progressBar = true;
               toastr.options.timeOut = 2000; 
               toastr.success(data.tmessage)
          }
        },
      }); 
});
/* Add Brand Condition End */
/* Show modal for Edit Start */
$(document).on('click', '.edit', function(){  
  $('.modal-title').text("Edit Brand"); 
  $('#brand_id').val($(this).attr('id'));
  $('#brand_name').val($(this).data('name'));
  $('#brand_description').val($(this).data('desc'));
  $('#image-update').val($(this).data('image')); 
  $('#show-img').attr("src", "http://grofie.in/" +$(this).data('image'));    
  $('#add_brandBtn').hide();
  $('#edit_brandBtn').show();
  $('#image').show();
  $('#brandModal').modal('show');
  var i = $(this).attr('id');
  confirmUrl = "{{url('/')}}"+'/brand/'+i;   
});
/* Show modal for Edit End */
/* Edit Brand condition Start*/
$('#brandform').on('click','#edit_brandBtn', function(event){
  event.preventDefault()   
    var postData = new FormData($("#brandform")[0]);          
    $( '#name-error' ).html( "" );
    $( '#description-error' ).html( "" );
    $( '#image-error' ).html( "" );
    $( '#status-error' ).html( "" );
    $.ajax({
     type:'POST',
     url: "{{route('brand.modify')}}",
     contentType: false,
     cache: false,
     processData: false,
     dataType:"json",
     data : postData,
      success:function(data) {
          console.log(data);               
          if(data.errors) {
            $('.text-danger').show();
            if(data.errors.brand_name){
                $( '#name-error' ).html( data.errors.brand_name[0] );
            }
            if(data.errors.brand_description){
                $( '#description-error' ).html( data.errors.brand_description[0] );
            }   
             if(data.errors.image){
                $( '#image-error' ).html( data.errors.image[0] );
            }  
             if(data.errors.publication_status){
                $( '#status-error' ).html( data.errors.publication_status[0] );
            }                
          }
          else {  
               $('#brandModal').modal('hide');
               $("#brandform")[0].reset();               
               $('#show-img').removeAttr('src'); 
               $('#show-img').removeAttr('style');
               // $("#dataTables-example").load(window.location + " #dataTables-example");  
               $('#brand_table').DataTable().ajax.reload(); 
               toastr.options.progressBar = true;
               toastr.options.timeOut = 2000; 
               toastr.success(data.tmessage)
          }
        },
      });   
   
});  
/* Edit Brand condition End*/
/* Show Brand Details Start */
$(document).on('click','.view', function(){
  $('.modal-title').text("Brand Details");
  $('#brandModal').modal('show');
  $('#brand_name').val($(this).data('name'));
  $('#brand_description').val($(this).data('desc'));
  $('#show-img').attr("src", $(this).data('image'));  
  $('#publication_status').val($(this).data('status'));
  $('#add_brandBtn').hide();
  $('#edit_brandBtn').hide();
  $('#image').hide();
  $('.status').hide();
});
/* Show Brand Details Start */
/* Status Update Strat*/
$(document).on('click','.active',function(event){
  event.preventDefault() 
  $.ajax({
    type:'GET',
    url: $(this).data("url"), 
    success:function(data) {        
        if(data.tmessage){
          $('#brand_table').DataTable().ajax.reload();
          toastr.options.progressBar = true;
          toastr.options.timeOut = 2000; 
          toastr.error(data.tmessage);
        }                 
      }, 
    }); 
});
$(document).on('click','.deactive',function(event){
  event.preventDefault() 
  $.ajax({
    type:'GET',
    url: $(this).data("url"), 
    success:function(data) {
      if(data.tmessage)
      { 
        $('#brand_table').DataTable().ajax.reload(); 
        toastr.options.progressBar = true;
        toastr.options.timeOut = 2000; 
        toastr.success(data.tmessage); 
      }  
    }, 
  }); 
});
/* Status Update End*/
/* Delete Brand Table Start */
$(document).on('click', '.delete', function(){
  $('#id').val($(this).data('id'));
  $('.modal-title').text($(this).data('name'));
  confirmUrl = $(this).data('url');
  $('#ok_button').text('YES');
  $('#confirmModal').modal('show');
});
$('#confirmModal').on('click', '#ok_button', function(event){
  event.preventDefault() 
  var confirm = new FormData($("#confirmform")[0]);    
  $.ajax({
   type:'POST',
   url:confirmUrl,
   processData: false,
   contentType: false,
   data : confirm,
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
          $('#brand_table').DataTable().ajax.reload();
          toastr.options.progressBar = true;
          toastr.options.timeOut = 2000; 
          toastr.error(data.tmessage)                                      
        }, 2000);  
      }      
    },   
  });   
});
/* Delete Brand Table End */ 
});
</script>
@endsection