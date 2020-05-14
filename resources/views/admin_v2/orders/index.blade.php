@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Orders')
@section('main_content')
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Orders</h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Orders                             
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="order_table">
                            <thead>
                                <tr>
                                    <th width="1%">SL No</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Order ID</th>
                     
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php               
                              $i = 0;
                              $no = 1;
                              @endphp
                              @foreach ($orders as $order)                              
                              @if($i != $order->order_id)
                              @php
                                $i = $order->order_id;
                              @endphp 
                              <tr>
                                <td>{{ $no++}}</td>
                                <td>{{$order->order_date}}</td>
                                <td>{{$order->f_name.' '.$order->s_name}}</td>
                                <td>{{$order->phone}}</td>
                                <td><p><strong>{{$order->order_id}}</strong></p></td>
                  
                                <td>
                                <a class="btn btn-outline btn-info btn-sm" href="{{route('order.details',$order->order_id)}}" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> View">View</a>
                                </td>
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
<script>
$(document).ready(function(){

  $('#order_table').DataTable({
    responsive: true
  });


$('.btn').on('click', function() {
    var $this = $(this);
  $this.button('loading'); 
});

});
</script>
@endsection
