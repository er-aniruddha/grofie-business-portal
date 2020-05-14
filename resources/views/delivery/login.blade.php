@extends('delivery.main_layouts')
@section('pageTitle', 'Login')
@section('delivery_main_content')

  <div class="col-md-6">
    <div class="p-4">
      <div class="text-center mb-4">
        <img src="{{asset('public/delivery/assets/images/coworking.svg')}}" alt="">
      </div>
      <h1 class="head-title mb-3 text-center"></h1>
      <!-- Login Submit form -->
      <div class="phone-page">
        <form id="submitLoginForm" method="POST">
        @csrf 
        <div class="form-group mb-3">
          <label for="exampleInputEmail1">Mobile Number</label>
          <input type="text" class="form-control" name="phone" id="phone" maxlength="10" placeholder="Enter Phone Number">
          <div style="width: 100%; margin-top: .25rem; font-size: .8125rem;color: #e63757;" id="phone-error"></div>
        </div>
        <button type="submit" class="loginBtn btn btn-xl btn-block btn-primary mb-3">Login</button> 
          <button class="spinner-btn btn btn-xl btn-block btn-outline-primary mb-3" type="button" disabled="" style="display: none;">
            <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
          </button>     
        </form>
      </div> 
      <!-- Login PIN form -->
      <div class="conf-page" style="display: none;">
        <form id="loginConfirmForm" method="POST">
        @csrf 
        <!-- <form action="http://localhost:8080/console/delivery/login/confirm" method="POST"> -->
          <div class="form-group mb-3">
            <label for="exampleInputEmail1">PIN</label>
            <input type="password" class="form-control" name="pin" id="pin" maxlength="6" placeholder="Enter Six digit PIN">
            <div style="width: 100%; margin-top: .25rem; font-size: .8125rem;color: #e63757;" id="pin-error"></div>  
          </div>
          <button type="submit" class="confBtn btn btn-xl btn-block btn-primary mb-3">Continue</button>   
          <button class="spinner-btn btn btn-xl btn-block btn-primary mb-3" type="button" disabled="" style="display: none;">
          <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
          </button>     
        </form>
      </div>    
      <!-- Set PIN Number form  -->
      <div class="setpin-page" style="display: none;">
        <form id="setPinForm" method="POST">
        @csrf 
      <!--  <form action="http://localhost:8080/console/delivery/setpin" method="POST"> -->
        <div class="form-group mb-3">
          <label for="exampleInputEmail1">PIN</label>
          <input type="password" class="form-control" name="pin" id="pin" maxlength="6" placeholder="Enter Six digit PIN">
          <div style="width: 100%; margin-top: .25rem; font-size: .8125rem;color: #e63757;" id="setpin-error"></div>  
        </div>
        <div class="form-group mb-3">
          <label for="exampleInputEmail1">CONFIRM PIN</label>
          <input type="password" class="form-control" name="pin_confirmation" id="pin_confirmation" maxlength="6" placeholder="Confirm PIN">
          <div style="width: 100%; margin-top: .25rem; font-size: .8125rem;color: #e63757;" id="confpin-error"></div>  
        </div> 
        <button type="submit" class="setPinBtn btn btn-xl btn-block btn-primary mb-3">Continue</button>  
        <button class="spinner-btn btn btn-xl btn-block btn-primary mb-3" type="button" disabled="" style="display: none;">
          <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
        </button>     
      </form>
    </div>  
    <div class="forget-pin text-center">
      <a href="#"><p class="text-muted"><i class="fe fe-lock"> </i>Forgot PIN</p></a>  
        <small class="footer-page text-muted text-center">
          This is copy righted under MIT. <br>
          Author Boson Technologies.
        </small>
    </div>
  </div>
</div>


@include('delivery.script.login')
@endsection