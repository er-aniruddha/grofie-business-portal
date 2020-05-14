@include('admin_v2.layouts.header')
@section('menuTitle','Login')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">                    
                   	<form method="POST" action="{{ route('admin.login.submit') }}">
                     @csrf
                        <fieldset>
                            <div class="form-group">
                                <input id="email" type="email" class="form-control" name="email" placeholder="name@address.com">
                                @error('email')
					                <span style="color:red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>   
					            @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" class="form-control" name="password" autocomplete="current-password" placeholder="**********">
                                @error('password')
                                    <span style="color:red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>  
                                @enderror
                            </div>                            
                            <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin_v2.layouts.footer')