@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Sub-Category')
@section('main_content')
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Sub-Category</h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Sub-Category
                    <button type="button" class="btn btn-primary btn-xs pull-right" name="add_sub_cat" id="add_sub_cat">Add Sub-Category</button>              
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="sub_cat_table">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Assign Category</th>
                                    <th>Description</th>
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
@include('admin_v2.sub_category.sub-cat-modal')
@include('admin_v2.layouts.modal')
<script>

$(document).ready(function(){
var img; /* This variable is used for show image*/
var confirmUrl; /* This variable is used for passsing */
var i;
/* Modal Close Button*/
$(document).on('click','#closBtn',function(){
  $('#sub_catForm')[0].reset();
  $('.text-danger').hide();
  $('#show-img').removeAttr('src'); 
  $('#show-img').removeAttr('style');
  $('#add_sub_catBtn').show();
  $('#image').show();
  $('.status').show();
  $('._cat_name_show').hide();
  $('._cat_name_input').show();
});
/* Show Category Table Start */ 
 $('#sub_cat_table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{
   url: "{{ route('sub-category.index') }}",
  },
  columns:[
   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
   {data: 'sub_cat_image', name: 'sub_cat_image', render: function(data, type, full, meta){
     return "<img src=http://grofie.in/" + data + " width='70' class='img-thumbnail' />";
     },orderable: false},
   {data: 'sub_cat_name', name: 'sub_cat_name' },
   {data: 'category_name', name: 'category_name'},
   {data: 'sub_cat_description', name: 'sub_cat_description'},
   {data: 'status', name: 'status', },
   {data: 'action', name: 'action', }, 
  ]});
/* Show Category Table End */
/* Add Modal Start */
$(document).on('click','#add_sub_cat',function(){  
  $('.modal-title').text("Add Sub-Category");
  $('#sub_cat_id').val("");
  $('#sub_catModal').modal('show');
  $('#add_sub_catBtn').show();
  $('#edit_sub_catBtn').hide();
 });
/* Add Modal end */
/* Add Brand Condition Start */
$('#sub_catForm').on('click','#add_sub_catBtn', function(event){
  event.preventDefault()
  var postData = new FormData($("#sub_catForm")[0]);          
  $( '#name-error' ).html( "" );
  $( '#description-error' ).html( "" );
  $( '#image-error' ).html( "" );
  $( '#category-error' ).html( "" );
  $( '#status-error' ).html( "" );
  $.ajax({
   type:'POST',
   url:"{{route('sub-category.store')}}", 
   contentType: false,
   cache: false,
   processData: false,
   dataType:"json",
   data : postData,
      success:function(data) {             
          if(data.errors) {
            $('.text-danger').show();
            if(data.errors.category_name){
                $( '#name-error' ).html( data.errors.category_name[0] );
            }
            if(data.errors.category_description){
                $( '#description-error' ).html( data.errors.category_description[0] );
            }   
             if(data.errors.image){
                $( '#image-error' ).html( data.errors.image[0] );
            }
            if(data.errors.category_id){
                $( '#category-error' ).html( data.errors.category_id[0] );
            }  
             if(data.errors.publication_status){
                $( '#status-error' ).html( data.errors.publication_status[0] );
            }                
          }
          else {  
               $('#sub_catModal').modal('hide');
               $("#sub_catForm")[0].reset();               
               $('#show-img').removeAttr('src'); 
               $('#show-img').removeAttr('style');           
               // $("#dataTables-example").load(window.location + " #dataTables-example");  
               $('#sub_cat_table').DataTable().ajax.reload(); 
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
  $('.modal-title').text("Edit Sub-Category"); 
  $('#sub_cat_id').val($(this).attr('id'));
  $('#sub_cat_name').val($(this).data('name'));
  $('#sub_cat_description').val($(this).data('desc'));
  $('#category_name').val($(this).data('category'));
  $('#image-update').val($(this).data('image')); 
  $('#show-img').attr("src", "http://grofie.in/" +$(this).data('image'));    
  $('#add_sub_catBtn').hide();
  $('#edit_sub_catBtn').show();
  $('#image').show();
  $('#sub_catModal').modal('show');
  $('._cat_name_input').show();
  
});
/* Show modal for Edit End */
/* Edit Brand condition Start*/
$('#sub_catForm').on('click','#edit_sub_catBtn', function(event){
  event.preventDefault()   
    var postData = new FormData($("#sub_catForm")[0]);          
    $( '#name-error' ).html( "" );
    $( '#description-error' ).html( "" );
    $( '#image-error' ).html( "" );
    $( '#category-error' ).html( "" );
    $( '#status-error' ).html( "" );
    $.ajax({
     type:'POST',
     url: "{{route('sub.category.modify')}}",
     contentType: false,
     cache: false,
     processData: false,
     dataType:"json",
     data : postData,
      success:function(data) {
          console.log(data);               
          if(data.errors) {
            $('.text-danger').show();
            if(data.errors.category_name){
                $( '#name-error' ).html( data.errors.category_name[0] );
            }
            if(data.errors.category_description){
                $( '#description-error' ).html( data.errors.category_description[0] );
            }   
            if(data.errors.image){
                $( '#image-error' ).html( data.errors.image[0] );
            }
            if(data.errors.category_id){
                $( '#category-error' ).html( data.errors.category_id[0] );
            }   
            if(data.errors.publication_status){
                $( '#status-error' ).html( data.errors.publication_status[0] );
            }                
          }
          else {  
	           $('#sub_catModal').modal('hide');
	           $("#sub_catForm")[0].reset();               
	           $('#show-img').removeAttr('src'); 
	           $('#show-img').removeAttr('style');           
	           // $("#dataTables-example").load(window.location + " #dataTables-example");  
	           $('#sub_cat_table').DataTable().ajax.reload(); 
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
  $('.modal-title').text("Sub-Category Details");
  $('#sub_catModal').modal('show');
  $('#sub_cat_name').val($(this).data('name'));
  $('#sub_cat_description').val($(this).data('desc'));
  $('#show-img').attr("src", $(this).data('image'));  
  $('#category_name').val($(this).data('category'));
  $('._cat_name_show').show();
  $('._cat_name_input').hide();
  $('#sub_cat_name').val($(this).data('name'));
  $('#publication_status').val($(this).data('status'));
  $('#add_sub_catBtn').hide();
  $('#edit_sub_catBtn').hide();
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
          $('#sub_cat_table').DataTable().ajax.reload();
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
        $('#sub_cat_table').DataTable().ajax.reload(); 
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
          $('#sub_cat_table').DataTable().ajax.reload();
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