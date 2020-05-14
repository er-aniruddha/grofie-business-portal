@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Taxes')
@section('main_content')
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Taxes</h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Taxes
                    <button type="button" class="btn btn-primary btn-xs pull-right" name="add_tax" id="add_tax">Add TAX</button>              
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tax_table">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Code</th>
                                    <th>Percentage</th>
                                	<th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@php $i=1; @endphp
                              	@foreach($taxes as $tax)
                            	<tr>
                            		@if($tax->cgst_name)
                            		<td>{{$i++}}</td>
                            		<td>{{$tax->cgst_name}}</td>
                            		<td>{{$tax->cgst_rate}}</td>
                            		<td>
                 					<button type="button" id="1" data-gstname="CGST" data-name="{{$tax->cgst_name}}" data-rate="{{$tax->cgst_rate}}" data-url="{{route('tax.modify', $tax->tax_id)}}" class="edit btn btn-outline btn-info btn-sm">Edit</button>
                 					<button type="button" id="1" data-gstname="CGST" data-name="{{$tax->cgst_name}}" data-rate="{{$tax->cgst_rate}}" data-url="{{route('tax.delete', $tax->tax_id)}}" class="del btn btn-outline btn-danger btn-sm">Del</button> 	
                            		</td>
                            		@endif

                            		@if($tax->sgst_name)
                            		<td>{{$i++}}</td>
                            		<td>{{$tax->sgst_name}}</td>
                            		<td>{{$tax->sgst_rate}}</td>
                            		<td>
                            		<button type="button" id="2" data-gstname="SGST" data-name="{{$tax->sgst_name}}" data-rate="{{$tax->sgst_rate}}" data-url="{{route('tax.modify', $tax->tax_id)}}" class="edit btn btn-outline btn-info btn-sm">Edit</button>
                 					<button type="button" id="2" data-gstname="SGST" data-name="{{$tax->sgst_name}}" data-rate="{{$tax->sgst_rate}}" data-url="{{route('tax.delete', $tax->tax_id)}}" class="del btn btn-outline btn-danger btn-sm">Del</button>	
                            		</td>
                            		@endif

                            		@if($tax->igst_name)
                            		<td>{{$i++}}</td>
                            		<td>{{$tax->igst_name}}</td>
                            		<td>{{$tax->igst_rate}}</td>
                            		<td>
                            		<button type="button" id="3" data-gstname="IGST" data-name="{{$tax->igst_name}}" data-rate="{{$tax->igst_rate}}" data-url="{{route('tax.modify', $tax->tax_id)}}" class="edit btn btn-outline btn-info btn-sm">Edit</button>
                 					<button type="button" id="3" data-gstname="IGST" data-name="{{$tax->igst_name}}" data-rate="{{$tax->igst_rate}}" data-url="{{route('tax.delete', $tax->tax_id)}}" class="del btn btn-outline btn-danger btn-sm">Del</button>	
                            		</td>
                            		@endif

                            		@if($tax->ugst_name)
                            		<td>{{$i++}}</td>
                            		<td>{{$tax->ugst_name}}</td>
                            		<td>{{$tax->ugst_rate}}</td>
                            		<td>
                            		<button type="button" id="4" data-gstname="UGST" data-name="{{$tax->ugst_name}}" data-rate="{{$tax->ugst_rate}}" data-url="{{route('tax.modify', $tax->tax_id)}}" class="edit btn btn-outline btn-info btn-sm">Edit</button>
                 					<button type="button" id="4" data-gstname="UGST" data-name="{{$tax->ugst_name}}" data-rate="{{$tax->ugst_rate}}" data-url="{{route('tax.delete', $tax->tax_id)}}" class="del btn btn-outline btn-danger btn-sm">Del</button></td>
                            		@endif
                            
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
@include('admin_v2.settings.tax.tax_modal')
@include('admin_v2.layouts.modal')
<script>
$(document).ready(function(){
var url;

$('#tax_table').DataTable({
    responsive: true
});

/* Add Modal Start */
$(document).on('click','#add_tax',function(){  
  $('.modal-title').text("Add TAX");
  $('#taxModal').modal('show');
  $('.select-tax').show();
  $('#add_taxBtn').show();
  $('#edit_taxBtn').hide();
 });
/* Add Modal end */
/* Add Tax Condition Start */
$('#taxForm').on('click','#add_taxBtn', function(event){
  event.preventDefault()
  var postData = new FormData($("#taxForm")[0]);   
  $( '#tax-select-error' ).html( "" );       
  $( '#name-error' ).html( "" );
  $( '#rate-error' ).html( "" );
  $.ajax({
   type:'POST',
   url:"{{ route ('tax.store')}}", 
   contentType: false,
   cache: false,
   processData: false,
   dataType:"json",
   data : postData,
      success:function(data) {  
         
          if(data.errors) {
          	 $('.text-danger').show();
            if(data.errors.tax_id){
                $('#tax-select-error').html( data.errors.tax_id[0] );
            }
            if(data.errors.tax_name){
                $('#name-error').html( data.errors.tax_name[0] );
            }   
             if(data.errors.tax_rate){
                $('#rate-error').html( data.errors.tax_rate[0] );
            }                
          }
          else {  
               $('#taxModal').modal('hide');
               $("#taxForm")[0].reset();         
               $("#tax_table").load(window.location + " #tax_table"); 
               toastr.options.progressBar = true;
               toastr.options.timeOut = 2000; 
               toastr.success(data.tmessage)
          }
        },
      }); 
});
/* Add Tax Condition End */
/* Edit Tax Condition Start */
//Show Modal 
$(document).on('click','.edit',function(event){
	event.preventDefault()  
  $('.modal-title').text("Edit " +$(this).data('gstname'));
  $('.select-tax').hide();
  $('#taxModal').modal('show');
  $('#add_taxBtn').hide();
  $('#edit_taxBtn').show();
  $('#tax_name').val($(this).data('name'));
  $('#tax_rate').val($(this).data('rate'));
  $('#tax_type_id').val($(this).attr('id'));
  url = $(this).data('url');
  console.log(url);

 });
$('#taxForm').on('click','#edit_taxBtn', function(event){
  event.preventDefault()
   console.log(url);
  var postData = new FormData($("#taxForm")[0]);         
  $( '#name-error' ).html( "" );
  $( '#rate-error' ).html( "" );
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
            if(data.errors.tax_name){
                $('#name-error').html( data.errors.tax_name[0] );
            }   
             if(data.errors.tax_rate){
                $('#rate-error').html( data.errors.tax_rate[0] );
            }                
          }
          else {  
               $('#taxModal').modal('hide');
               $("#taxForm")[0].reset();         
               $("#tax_table").load(window.location + " #tax_table"); 
               toastr.options.progressBar = true;
               toastr.options.timeOut = 2000; 
               toastr.success(data.tmessage)
          }
        },
      }); 
});
/* Edit Tax Condition End */
/* Delete Tax Table Start */
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
   type:'POST',
   url:url,
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
          $("#tax_table").load(window.location + " #tax_table");
          toastr.options.progressBar = true;
          toastr.options.timeOut = 2000; 
          toastr.error(data.tmessage)                                      
        }, 2000);  
      }      
    },   
  });   
});
/* Delete Tax Table End */ 
$(document).on('click','#closBtn',function(){
  $('#taxForm')[0].reset();
  $('.text-danger').hide();
});


});
</script>
@endsection
