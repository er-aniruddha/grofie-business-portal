@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Users')
@section('main_content')
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Users</h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Users                             
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="user_table">
                            <thead>
                                <tr>
                                    <th width="1%">SL No</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php               
                              $i = 0;                       
                              @endphp
                              @foreach ($users as $user)                            
                            
                              <tr>
                                <td>{{ $i++}}</td>                           
                                <td>{{$user->f_name.' '.$user->s_name}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->email}}</td>
                                @if($user->isOnline())
                                <td><p class="text-success"><i class="fa fa-fw"></i>Online</p></td>
                                @else
                                <td><p class="text-danger"><i class="fa fa-fw"></i>Offline</p></td>   
                                @endif    
                                <td><button type="button" class="view btn btn-outline btn-info btn-sm">View</button></td>
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
<script>
$(document).ready(function(){
  $('#user_table').DataTable({
    responsive: true
  });
});
</script>
@endsection
