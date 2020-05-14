@extends('admin_v2.layouts.main_layouts')
@section('menuTitle','Delivery\Charges')
@section('main_content')
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Delivery Charges</h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Delivery Charges for Mini-Mum Amount
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                    	<form action="{{route('order.delivery.charges')}}" method="POST" name="chargesForm">
                    		@csrf
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Minimum Order Amount</label>
                                        @if($delCharges)                                
                                        <input class="form-control" name="min_ordr_amount" type="number" min="0" value="{{$delCharges->min_ordr_amount}}">
                                        <input type="hidden" name="del_id" value="{{$delCharges->id}}">
                                        @else
                                        <input class="form-control" name="min_ordr_amount" type="number" min="0" required="">
                                        @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Delivery Charges</label>
                                        @if($delCharges)                                
                                        <input class="form-control" name="delivery_charges" type="number" min="0" value="{{$delCharges->delivery_charges}}">
                                        @else
                                        <input class="form-control" name="delivery_charges" type="number" min="0" required="">
                                        @endif
                                </div>
                            </div>
                    <div>
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
      <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Delivery Charges for KM 
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Delivery Area</label>
                                        @if($delCharges)                                
                                        <input class="form-control" name="delivery_area" type="number" min="0" value="{{$delCharges->delivery_area}}">
                                        @else
                                        <input class="form-control" name="delivery_area" type="number" min="0" required="">
                                        @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Delivery Charges Per KM</label>
                                        @if($delCharges)                                
                                        <input class="form-control" name="km_charges" type="number" min="0" value="{{$delCharges->km_charges}}">
                                        @else
                                        <input class="form-control" name="km_charges" type="number" min="0" required="">
                                        @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="form-group">
                                    <label>Free Delivery in KM</label>
                                        @if($delCharges)                                
                                        <input class="form-control" name="delivery_free_area" type="number" min="0" value="{{$delCharges->delivery_free_area}}">
                                        @else
                                        <input class="form-control" name="delivery_free_area" type="number" min="0" required="">
                                        @endif
                                </div>                                   
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">Save</button>
                            </div>
                             
                        </form>
                    <div>
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
</div>

@endsection
