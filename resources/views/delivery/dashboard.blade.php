@extends('delivery.main_layouts')
@section('pageTitle', 'Dashboard')
@section('delivery_main_content')
@include('delivery.sidebar')
<!-- Pre Loader Strat  -->
<div class='loadscreen' id="preloader">
    <div class="loader spinner-glow spinner-glow-dark">
    </div>
</div>
<!-- Pre Loader end  -->
<div class="main-content-wrap sidenav-open d-flex flex-column">
    <div class="main-content">
        <h1>Hi, {{$associate->f_name}}</h1>
         <div class="separator-breadcrumb border-top"></div>
        <section class="widget-card">
            <div class="row">
            @if($orderAssignCount == 0)
            <!-- If no oders is present -->
            <div class="col-md-6">
                <div class="card bg-dark text-white o-hidden mb-4">
                    <img class="card-img" src="{{asset('public/delivery/assets/images/photo-long-1.jpg')}}" alt="Card image">
                    <div class="card-img-overlay">
                        <div class="text-center pt-4">
                            <h5 class="card-title mb-2 text-white">No Orders</h5>
                            <div class="separator border-top mb-2"></div>
                            <p class="text-small font-italic">Have a nice day</p>
                        </div>                       
                    </div>
                </div>
            </div>
            @else
            <!-- Show Assign Orders -->
             @php               
             $i = 0;
             $no = 1;
             @endphp
             @foreach ($orderAssign as $d_order)                              
             @if($i != $d_order->order_id)
             @php
               $i = $d_order->order_id;
             @endphp 
                <div class="orders col-xl-6">
                    <div class="card mt-4 mb-4">
                        <div class="card-body">
                            <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                                <div>
                                    <h6><a href="#">#{{$no++}}. {{$d_order->f_name.' '.$d_order->s_name}}</a></h6>
                                    <p class="ul-task-manager__font-date text-muted">Address: <br>
                                        {{$d_order->place_name}}<br>
                                        {{$d_order->select_city}}<br>
                                    </p>
                                    <i class="ul-task-manager__fonts i-Telephone"></i> : 
                                    <a href="">{{$d_order->phone}}/{{$d_order->alt_phone}}</a>
                                </div>
                                <ul class="list list-unstyled mb-0 mt-3 mt-sm-0 ml-auto">
                                    <li><span class="ul-task-manager__font-date text-muted">Order Date : {{$d_order->order_date}}</span></li>
                                    <li class="dropdown">
                                        <span class="ul-task-manager__font-date text-muted">Status: &nbsp;</span>
                                        <p class="badge badge-warning">On Way</p>
                                    </li>
                                    <li class="dropdown">
                                        <span class="ul-task-manager__font-date text-muted">Location: &nbsp;</span>
                                        {{$d_order->lat}},{{$d_order->long}}
                                    </li>
                                    <li class="dropdown">
                                        <span class="ul-task-manager__font-date text-muted">Distance: &nbsp;</span>
                                        {{round($d_order->distance/2000 , 2)}} km
                                    </li>
                                    <li class="dropdown">
                                        <span class="ul-task-manager__font-date text-muted">Duration: &nbsp;</span>
                                        {{round($d_order->duration/120 , 2)}} min
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                   <!--  <span>Due: <span class="font-weight-semibold">18 hours</span></span> -->

                    <button type="button" class="orders-detailsBtn btn btn-outline-dark btn-sm mb-3 float-right" orderId="{{ $d_order->order_id}}" url="{{ route('delivery.order.details',$d_order->order_id) }}" data-name="{{$d_order->first_name.' '.$d_order->last_name}}" status="{{ $d_order->order_stat}}" order-date="{{ $d_order->order_date}}">{{$d_order->order_id}}
                    </button>
                    <button class="order-details-spinner-btn btn btn-outline-dark btn-sm mb-3" type="button" disabled="" style="display: none;">
                        <span class="spinner-border spinner-border-sm text-dark" role="status" aria-hidden="true"></span> {{$d_order->order_id}}
                    </button>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                @endif

@include('delivery.orders_details')
            </div><!-- row end-->
        </section>
    </div>
</div>
@include('delivery.script.orders-details')

@endsection