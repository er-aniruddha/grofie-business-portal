@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','SMS')
@section('main_content')
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">SMS</h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                   SMS      
                </div>
                <div class="panel-body">
                  <form action="{{ route('sms.api') }}" method="POST">
                @csrf
                <!-- /.panel-heading -->
                <div class="form-group">
                  <label>API Key</label>
                  @if($smsGateway)
                  <input class="form-control" name="api_key" value="{{$smsGateway->api}}" required="">
                  @else
                  <input type="text" class="form-control" name="api_key" placeholder="API Key" required="">
                  @endif
                  @error('api_key')
                    <div class="form-group has-error">
                      <span class="help-block">
                          <strong>{{ $message }}</strong>
                      </span>
                    </div>  
                  @enderror                  
                </div>
                 <div class="form-group">
                  <label for="exampleInputPassword1">API Secrety Key</label>
                  @if($smsGateway)
                  <input type="text" class="form-control" name="api_secret" value="{{$smsGateway->secret}}" required="">
                  @else
                  <input type="text" class="form-control" name="api_secret" placeholder="API Secret key" required="">
                  @endif
                  @error('api_secret')
                    <div class="form-group has-error">
                      <span class="help-block">
                          <strong>{{ $message }}</strong>
                      </span>
                    </div>  
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Email Id</label>
                  @if($smsGateway)
                  <input type="email" class="form-control" name="email" value="{{$smsGateway->email}}" required="">
                  @else
                  <input type="email" class="form-control" name="email" placeholder="Enter registered email id" required="">
                  @endif
                  @error('email')
                    <div class="form-group has-error">
                      <span class="help-block">
                          <strong>{{ $message }}</strong>
                      </span>
                    </div>  
                  @enderror
                </div>
            
              <!-- /.box-body -->
              @if($smsGateway)
              <input type="hidden" name="id" value="{{$smsGateway->id}}"> 
              @endif
              
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#sms-modal"> Check </button> 
        
              </form>
                  
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
<!-- Operation Modal Start -->
<div class="modal fade" id="sms-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">  
              <form action="{{route('sms.check')}}" method="POST">
                @csrf
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Check SMS Gateway</h4>
                </div>
                <div class="modal-body">
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Phone Number</label>
                    <input type="text" maxlength="10" minlength="10" class="form-control" name="phone" placeholder="Enter phone number" title="Please enter a valid phone number" pattern="[6-9]{1}[0-9]{9}" required="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Message</label>
                    <input type="text" class="form-control" name="message" placeholder="Messages" required="">
                  </div>   
                </div>
              <!-- /.box --> 
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-info">Continue</button>
                  <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Operation Modal End-->
@endsection
