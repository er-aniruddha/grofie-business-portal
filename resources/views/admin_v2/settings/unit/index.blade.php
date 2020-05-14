@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Unites')
@section('main_content')
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Unites</h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Unites
                    <button type="button" class="btn btn-primary btn-xs pull-right" name="add_unit" id="add_unit">Add Unit</button>              
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="unit_table">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                	<th>Unit</th>
                                	<th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@php $i=1; @endphp
                              	@foreach($unites as $unit)
                            	<tr>
                            		<td>{{$i++}}</td>
                            		<td>{{$unit->unit_name_lm}}</td>
                            		<td>{{$unit->unit_name_sm}}</td>
                            		<td>{{$unit->unit_unit}}</td>
                            		<td>
                 					<button type="button" data-name="{{$unit->unit_name_lm}}" data-code="{{$unit->unit_name_sm}}" data-unit="{{$unit->unit_unit}}" data-url="{{route('unit.modify', $unit->unit_id)}}" class="edit btn btn-outline btn-info btn-sm">Edit</button>
                 					<button type="button" data-name="{{$unit->unit_name_lm}}" data-code="{{$unit->unit_name_sm}}" data-url="{{route('unit.delete', $unit->unit_id)}}" class="del btn btn-outline btn-danger btn-sm">Del</button> 	
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
@include('admin_v2.settings.unit.unit_modal')
@include('admin_v2.layouts.modal')
<script>
$(document).ready(function(){
var url;

$('#unit_table').DataTable({
    responsive: true
});

/* Add Modal Start */
$(document).on('click','#add_unit',function(){  
  $('.modal-title').text("Add Unit");
  $('#unitModal').modal('show');
  $('#add_unitBtn').show();
  $('#edit_unitBtn').hide();
 });
/* Add Modal end */
/* Add unit Condition Start */
$('#unitForm').on('click','#add_unitBtn', function(event){
  event.preventDefault()   
    var postData = new FormData($("#unitForm")[0]);          
    $( '#name-error' ).html( "" );
    $( '#code-error' ).html( "" );
    $( '#unit-error' ).html( "" );

    $.ajax({
     type:'POST',
     url: "{{route('unit.store')}}",
     contentType: false,
     cache: false,
     processData: false,
     dataType:"json",
     data : postData,
      success:function(data) {
          if(data.errors) {
            $('.text-danger').show();
            if(data.errors.unit_name_lm){
                $( '#name-error' ).html( data.errors.unit_name_lm[0] );
            }
            if(data.errors.unit_name_sm){
                $( '#code-error' ).html( data.errors.unit_name_sm[0] );
            }
            if(data.errors.unit_unit){
                $( '#unit-error' ).html( data.errors.unit_unit[0] );
            }  
          }
          else {  
               $('#unitModal').modal('hide');
               $("#unitForm")[0].reset();
               $("#unit_table").load(window.location + " #unit_table");  
               toastr.options.progressBar = true;
               toastr.options.timeOut = 2000; 
               toastr.success(data.tmessage)
          }
        },
      });   
   
}); 
/* Add unit Condition End */
/* Edit unit Condition Start */
//Show Modal 
$(document).on('click','.edit',function(event){
	event.preventDefault()  
  $('.modal-title').text("Edit " +$(this).data('name'));
  $('#unitModal').modal('show');
  $('#add_unitBtn').hide();
  $('#edit_unitBtn').show();
  $('#unit_name_lm').val($(this).data('name'));
  $('#unit_name_sm').val($(this).data('code'));
  $('#unit_unit').val($(this).data('unit'));
  url = $(this).data('url');
  console.log(url);
 });
$('#unitForm').on('click','#edit_unitBtn', function(event){
  event.preventDefault()   
    var postData = new FormData($("#unitForm")[0]);          
    $( '#name-error' ).html( "" );
    $( '#code-error' ).html( "" );
    $( '#unit-error' ).html( "" );
    $.ajax({
     type:'POST',
     url:url,
     contentType: false,
     cache: false,
     processData: false,
     dataType:"json",
     data : postData,
      success:function(data) {
      	console.log(data);
          if(data.errors) {
            $('.text-danger').show();
            if(data.errors.unit_name_lm){
                $( '#name-error' ).html( data.errors.unit_name_lm[0] );
            }
            if(data.errors.unit_name_sm){
                $( '#code-error' ).html( data.errors.unit_name_sm[0] );
            }
            if(data.errors.unit_unit){
                $( '#unit-error' ).html( data.errors.unit_unit[0] );
            }  
          }
          else {  
               $('#unitModal').modal('hide');
               $("#unitForm")[0].reset();
               $("#unit_table").load(window.location + " #unit_table");  
               toastr.options.progressBar = true;
               toastr.options.timeOut = 2000; 
               toastr.success(data.tmessage)
          }
        },
      });   
   
}); 
/* Edit unit Condition End */
/* Delete unit Table Start */
$(document).on('click', '.del', function(event){
  event.preventDefault()  
  $('.modal-title').text($(this).data('name'));
  $('.text-danger').hide();
  url = $(this).data('url');
  $('#ok_button').text('YES');
  $('#confirmModal').modal('show');
  console.log(url);
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
          $("#unit_table").load(window.location + " #unit_table");
          toastr.options.progressBar = true;
          toastr.options.timeOut = 2000; 
          toastr.error(data.tmessage)                                      
        }, 2000);  
      }      
    },   
  });   
});
/* Delete unit Table End */ 
$(document).on('click','#closBtn',function(){
  $('#unitForm')[0].reset();
  $('.text-danger').hide();
});


});
</script>
@endsection
