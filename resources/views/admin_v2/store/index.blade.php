@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Stores')
@section('main_content')
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Stores</h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Stores
                    <button type="button" class="btn btn-primary btn-xs pull-right" name="store" id="store">Add Store</button>              
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="store_table">
                            <thead>
                                <tr>
                                  <th>Store Name</th>
                                  <th>City</th>
                                  <th>Address</th>
                                  <th>Latitude</th>
                                	<th>Longitude</th>
                                	<th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($stores as $store)
                              <tr>
                                <td>{{$store->store_name}}</td>
                                <td>{{$store->city}}</td>
                                <td>{{$store->address}}</td>
                                <td>{{$store->lat}}</td>
                                <td>{{$store->long}}</td>
                                <td>
                                  <button type="button" class="edit btn btn-outline btn-info btn-sm">Edit</button>
                                  <button type="button" data-url="{{route('store.delete',$store->store_id)}}" class="del btn btn-outline btn-danger btn-sm">Del</button> 
                                </td>
                              </tr>
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
@include('admin_v2.store.store_modal')
@include('admin_v2.layouts.modal')
<script>
$(document).ready(function(){
var url;

$('#store_table').DataTable({
    responsive: true
});

/* Add Modal Start */
$(document).on('click','#store',function(){  
  $('.modal-title').text("Add Store");
  $('#storeModal').modal('show');
  $('.select-tax').show();
  $('#add_storeBtn').show();
  $('#edit_storeBtn').hide();
 });
/* Add Modal end */
/* Add Store Condition Start */
$('#storeForm').on('click','#add_storeBtn', function(event){
  event.preventDefault()
  var postData = new FormData($("#storeForm")[0]);   
  $( '#name-error' ).html( "" );       
  $( '#city-error' ).html( "" );
  $( '#address-error' ).html( "" );
  $( '#lat-error' ).html( "" );
  $( '#long-error' ).html( "" );
  $.ajax({
   type:'POST',
   url:"{{ route ('store.create')}}", 
   contentType: false,
   cache: false,
   processData: false,
   dataType:"json",
   data : postData,
      success:function(data) {  
         
          if(data.errors) {
          	 $('.text-danger').show();
            if(data.errors.store_name){
                $('#name-error').html( data.errors.store_name[0] );
            }
            if(data.errors.city){
                $('#city-error').html( data.errors.city[0] );
            }   
            if(data.errors.address){
                $('#address-error').html( data.errors.address[0] );
            }
            if(data.errors.lat){
                $('#lat-error').html( data.errors.lat[0] );
            }
            if(data.errors.long){
                $('#long-error').html( data.errors.long[0] );
            }                
          }
          else {  
               $('#storeModal').modal('hide');
               $("#storeForm")[0].reset();         
               $("#store_table").load(window.location + " #store_table"); 
               toastr.options.progressBar = true;
               toastr.options.timeOut = 2000; 
               toastr.success(data.tmessage)
          }
        },
      }); 
});
/* Add Store Condition End */
/* Edit Store Condition Start */
//Show Modal 
// $(document).on('click','.edit',function(event){
// 	event.preventDefault()  
//   $('.modal-title').text("Edit " +$(this).data('gstname'));
//   $('.select-tax').hide();
//   $('#taxModal').modal('show');
//   $('#add_taxBtn').hide();
//   $('#edit_taxBtn').show();
//   $('#tax_name').val($(this).data('name'));
//   $('#tax_rate').val($(this).data('rate'));
//   $('#tax_type_id').val($(this).attr('id'));
//   url = $(this).data('url');
//   console.log(url);

//  });
// $('#taxForm').on('click','#edit_taxBtn', function(event){
//   event.preventDefault()
//    console.log(url);
//   var postData = new FormData($("#taxForm")[0]);         
//   $( '#name-error' ).html( "" );
//   $( '#rate-error' ).html( "" );
//   $.ajax({
//    type:'POST',
//    url:url, 
//    contentType: false,
//    cache: false,
//    processData: false,
//    dataType:"json",
//    data : postData,
//       success:function(data) {   
//       console.log(data);          
//           if(data.errors) {
//           	 $('.text-danger').show();          
//             if(data.errors.tax_name){
//                 $('#name-error').html( data.errors.tax_name[0] );
//             }   
//              if(data.errors.tax_rate){
//                 $('#rate-error').html( data.errors.tax_rate[0] );
//             }                
//           }
//           else {  
//                $('#taxModal').modal('hide');
//                $("#taxForm")[0].reset();         
//                $("#tax_table").load(window.location + " #tax_table"); 
//                toastr.options.progressBar = true;
//                toastr.options.timeOut = 2000; 
//                toastr.success(data.tmessage)
//           }
//         },
//       }); 
// });
/* Edit Store Condition End */
/* Delete Store Table Start */
$(document).on('click', '.del', function(event){
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
  var confirm = new FormData($("#confirmform")[0]);    
  $.ajax({
   type:'GET',
   url:url,
   processData: false,
   contentType: false,
   data : confirm,
   beforeSend:function(){
    $('#ok_button').text('Deleting...');
   },
    success:function(data) {
      console.log(data);
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
          $("#store_table").load(window.location + " #store_table");
          toastr.options.progressBar = true;
          toastr.options.timeOut = 2000; 
          toastr.error(data.tmessage)                                      
        }, 2000);  
      }      
    },   
  });   
});
/* Delete Store Table End */ 
$(document).on('click','#closBtn',function(){
  $('#taxForm')[0].reset();
  $('.text-danger').hide();
});


});
</script>
@endsection
