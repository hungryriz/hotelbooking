@extends('admin.layouts.auth')
@section('content')
<div class="login bg-img" style="background-image: url({{asset('assets/img/login-bg.jpg')}});">
        <div class="login-overlay"></div>
        <div class="login-content">
            
            <div class="login-content-inner">
                <div class="login-head">
                    <h1 class="">{{Setting::get('site_title')}}</h1>
                    <h3>Forgot Password</h3>
                    @include('include.alerts')
                </div>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/shop/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <button class="btn btn-primary btn-block">Submit</button>
                        <p class="log-txt">The verfication link will send to your Email Account</p>
                    </form>
               </div>
            
        </div>
    </div>
@endsection
