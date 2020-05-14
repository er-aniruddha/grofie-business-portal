@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Delivery Associates')
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
                    Delivery Associates
                    <button type="button" class="btn btn-primary btn-xs pull-right" name="add_associates" id="add_associates">Add Associates</button>              
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="associates_table">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                   <!--  <th width="2%">Status</th> -->
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
@include('admin_v2.delivery.associates_modal')
@include('admin_v2.layouts.modal')
<script>
$(document).ready(function(){
var confirmUrl; /* This variable is used for passsing */
/* Show Delivery Associates Table Start */ 
 $('#associates_table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{
   url: "{{ route('delivery.index') }}",
  },
  columns:[
   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
   {data: 'name' ,name: 'name' },
   {data: 'phone', name: 'phone'},
   // {data: 'status', name: 'status', },
   {data: 'action', name: 'action', }, 
  ]});
/* Show Delivery Associates Table End */
/* Add Modal Start */
 $(document).on('click','#add_associates',function(){
  $('.modal-title').text("Add Associates");
  $('#id').val("");
  $('#associateModal').modal('show');
  $('#add_del_asso_btn').show();
  $('#edit_del_asso_btn').hide();
  $('.verify').hide();
 });
/* Add Modal end */
/* Add Delivery Associates Condition Start */
$('#associateForm').on('click','#add_del_asso_btn', function(event){
  event.preventDefault()
  var postData = new FormData($("#associateForm")[0]);          
  $( '#fname-error' ).html( "" );
  $( '#sname-error' ).html( "" );
  $( '#phone-error' ).html( "" );
  $( '#email-error' ).html( "" );
  $.ajax({
   type:'POST',
   url:"{{ route ('delivery.associates.store')}}", 
   contentType: false,
   cache: false,
   processData: false,
   dataType:"json",
   data : postData,
      success:function(data) {
          console.log(data);               
          if(data.errors) {
            $('.text-danger').show();
            if(data.errors.f_name){
                $( '#fname-error' ).html( data.errors.f_name[0] );
            }
            if(data.errors.s_name){
                $( '#sname-error' ).html( data.errors.s_name[0] );
            }   
             if(data.errors.phone){
                $( '#phone-error' ).html( data.errors.phone[0] );
            }  
             if(data.errors.email){
                $( '#email-error' ).html( data.errors.email[0] );
            }                
          }
          else {  
               $('#associateModal').modal('hide');
               $("#associateForm")[0].reset();            
               // $("#dataTables-example").load(window.location + " #dataTables-example");  
               $('#associates_table').DataTable().ajax.reload(); 
               toastr.options.progressBar = true;
               toastr.options.timeOut = 2000; 
               toastr.success(data.tmessage)
          }
        },
      }); 
});
/* Add Delivery Associates Condition End */
/* Show modal for Edit Start */
$(document).on('click', '.edit', function(){  
  $('.modal-title').text("Edit Associates"); 
  $('#del_asso_id').val($(this).attr('id'));
  $('#f_name').val($(this).data('fname'));
  $('#s_name').val($(this).data('sname'));
  $('#phone').val($(this).data('phone')); 
  $('#email').val($(this).data('email')); 
  $('#add_del_asso_btn').hide();
  $('#edit_del_asso_btn').show();
  $('#associateModal').modal('show'); 
  confirmUrl =  $(this).data('url');
});
/* Show modal for Edit End */
/* Edit Delivery Associates condition Start*/
$('#associateForm').on('click','#edit_del_asso_btn', function(event){
  event.preventDefault()  
    var postData = new FormData($("#associateForm")[0]);          
    $( '#name-error' ).html( "" );
    $( '#description-error' ).html( "" );
    $( '#image-error' ).html( "" );
    $( '#status-error' ).html( "" );
    $.ajax({
     type:'POST',
     url: confirmUrl,
     contentType: false,
     cache: false,
     processData: false,
     dataType:"json",
     data : postData,
      success:function(data) {   
        console.log(data);          
          if(data.errors) {
            $('.text-danger').show();
            if(data.errors.f_name){
                $( '#fname-error' ).html( data.errors.f_name[0] );
            }
            if(data.errors.s_name){
                $( '#sname-error' ).html( data.errors.s_name[0] );
            }   
             if(data.errors.phone){
                $( '#phone-error' ).html( data.errors.phone[0] );
            }  
             if(data.errors.email){
                $( '#email-error' ).html( data.errors.email[0] );
            }                      
          }
          else {
            if(data.tmessage)
            {
              $('#associateModal').modal('hide');
              $("#associateForm")[0].reset();            
               // $("#dataTables-example").load(window.location + " #dataTables-example");  
              $('#associates_table').DataTable().ajax.reload(); 
              toastr.options.progressBar = true;
              toastr.options.timeOut = 2000; 
              toastr.success(data.tmessage)
            }  
          }
        },
      });   
   
});  
/* Edit Delivery Associates condition End*/
/* Show Delivery Associates Details Start */
$(document).on('click','.view', function(event){
  event.preventDefault()
  $('.modal-title').text("Associates Details");
  $('#associateModal').modal('show');
  $('#f_name').val($(this).data('fname'));
  $('#s_name').val($(this).data('sname'));
  $('#phone').val($(this).data('phone')); 
  $('#email').val($(this).data('email')); 
  if(!($(this).data('verify')))
  {
    $('#verify-active').hide();
    $('#verify-deactive').show();
  }
  else
  {
    $('#verify-active').show();
    $('#verify-deactive').hide();
  } 
  $('.verify').show();
  $('#add_btn').hide();
  $('#edit_btn').hide();
});
/* Show Delivery Associates Details Start */
/* Delete Brand Table Start */
$(document).on('click', '.delete', function(){
  $('#id').val($(this).data('id'));
  $('.modal-title').text($(this).data('fname'));
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
      if(data.tmessage)
      {
        setTimeout(function(){   
          $('#confirmModal').modal('hide');
          $('#associates_table').DataTable().ajax.reload();
          toastr.options.progressBar = true;
          toastr.options.timeOut = 2000; 
          toastr.error(data.tmessage)                                      
        }, 2000);  
      }      
    },   
  });   
});
/* Delete Brand Table End */ 
/* Modal Close Button*/
$(document).on('click','#closBtn',function(){
  $('#associateForm')[0].reset();
  $('.text-danger').hide();
  $('#add_btn').show();
});

});
</script>

@endsection

