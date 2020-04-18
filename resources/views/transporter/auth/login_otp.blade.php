@extends('user.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @include('include.alerts')
            <div class="panel panel-default">
                <div class="panel-heading">Login Otp</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/transporter/userlogin') }}">
                        {{ csrf_field() }}

                         <div class="col-md-12" >
                            <input id="otp" type="text" class="form-control" placeholder="Enter OTP" name="otp" >
                            @if ($errors->has('otp'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('otp') }}</strong>
                                </span>
                            @endif 
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Verify</button> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
