@extends('admin.layouts.auth')

@section('content')
<div class="login bg-img" style="background-image: url({{asset('assets/img/login-bg.jpg')}});">
        <div class="login-overlay"></div>
        <div class="login-content">
            
            <div class="login-content-inner">
                <div class="login-head">
                    <h1 class="">{{Setting::get('site_title')}}</h1>
                    <h3>Reset Password</h3>
                    @include('include.alerts')
                </div>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/shop/password/reset') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                           
                        </div>
                        <button type="submit" class="btn btn-primary">
                                    Reset Password
                        </button>
                            
                    </form>
                </div>
            
        </div>
    </div>
@endsection
