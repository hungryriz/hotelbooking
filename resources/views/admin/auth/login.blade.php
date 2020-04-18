@extends('admin.layouts.auth')

@section('content')
<div class="login bg-img" style="background-image: url({{asset('assets/img/login-bg.jpg')}});">
        <div class="login-overlay"></div>
        <div class="login-content">
            
            <div class="login-content-inner">
                <div class="login-head">
                    <h1 class="">{{Setting::get('site_title')}}</h1>
                    <h3>Login to Your Account</h3>
                    @include('include.alerts')
                </div>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/login') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Email</label>
                         <input id="email" type="email" class="form-control" name="email" placeholder="E-Mail Address" value="{{ old('email') }}" autofocus>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input id="password" type="password" class="form-control" placeholder="Password" name="password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button class="btn btn-primary btn-block">Login</button>
                    <a href="{{ url('/admin/password/reset') }}" class="forgot-link">Forgot Password?</a>
                </form>
            </div>
            
        </div>
    </div>
@endsection