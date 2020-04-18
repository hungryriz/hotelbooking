@extends('user.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                @include('include.alerts')
                <div class="panel-body">
                <div class="print-error-msg">
                    <ul>
                    </ul>
                </div>
                 <form role="form" method="POST" id="register_form" action="{{ url('/transporter/register') }}">

                        <div id="first_step">
                            <div class="col-md-4">
                                <input value="+91" type="text" placeholder="+1" id="country_code" name="country_code" />
                            </div> 
                            
                            <div class="col-md-8">
                                <input type="text" autofocus id="phone_number" class="form-control" placeholder="Enter Phone Number" name="phone_number" value="{{ old('phone_number') }}" />
                            </div>

                            <div class="col-md-8">
                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>

                             <div class="col-md-12 mobile_otp_verfication" style="display: none;">
                                <input type="text" class="form-control" placeholder="Otp" name="otp" id="otp" value="">

                                @if ($errors->has('otp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('otp') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <input type="hidden" id="otp_ref"  name="otp_ref" value="" />
                            <input type="hidden" id="otp_phone"  name="phone" value="" />

                            <div class="col-md-12" style="padding-bottom: 10px;" id="mobile_verfication">
                                <input type="button" class="log-teal-btn small" onclick="smsLogin();" value="Verify Phone Number"/>
                            </div>

                             <div class="col-md-12 mobile_otp_verfication" style="padding-bottom: 10px;display:none" id="mobile_otp_verfication">
                                <input type="button" class="log-teal-btn small" onclick="checkotp();" value="Verify Otp"/>
                            </div>

                        </div>

                        {{ csrf_field() }}

                        <div id="second_step" style="display: none;">

                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif                        
                            </div>
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password" placeholder="Password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <input type="password" placeholder="Re-type Password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="col-md-12">
                                <button class="log-teal-btn register_btn" type="submit">REGISTER</button>
                            </div>

                        </div>

                    </form> 
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    var my_otp='';
    function smsLogin()
    {
        var countryCode = document.getElementById("country_code").value;
        var phoneNumber = document.getElementById("phone_number").value;
        var csrf = $("input[name='_token']").val();;
        $('#otp_phone').val(countryCode+''+phoneNumber);
            $.ajax({
                url: "{{url('/transporter/otp')}}",
                type:'POST',
                data:{ phone : countryCode+''+phoneNumber,'_token':csrf },
                success: function(data) { 
                    if($.isEmptyObject(data.error)){
                        my_otp = data.otp;
                        $('.mobile_otp_verfication').show();
                        $('#mobile_verfication').hide();
                        $('#mobile_verfication').html("<p class='helper'> Please Wait... </p>");
                        $('#phone_number').attr('readonly',true);
                        $('#country_code').attr('readonly',true);
                        $(".print-error-msg").find("ul").html('');
                        $(".print-error-msg").find("ul").append('<li>'+data.message+'</li>');
                    }else{
                        printErrorMsg(data.error);
                    }
                },
                error:function(jqXhr,status){ 
                    if( jqXhr.status === 422 ) {
                        $(".print-error-msg").show();
                        var errors = jqXhr.responseJSON; 

                        $.each( errors , function( key, value ) { 
                            $(".print-error-msg").find("ul").append('<li>'+value[0]+'</li>');
                        });
                    } 
                }
            });
    }


    function checkotp()
    {
        var otp = document.getElementById("otp").value;
        if(otp){
            if(my_otp == otp){
                $(".print-error-msg").find("ul").html('');
                $('#mobile_otp_verfication').html("<p class='helper'> Please Wait... </p>");
                $('#phone_number').attr('readonly',true);
                $('#country_code').attr('readonly',true);
                $('.mobile_otp_verfication').hide();
                $('#second_step').fadeIn(400);
                $('#mobile_verfication').show().html("<p class='helper'> * Phone Number Verified </p>");
                my_otp='';
            }else{
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").find("ul").append('<li>Otp not Matched!</li>');
            }
        }
    }
    function printErrorMsg (msg)
    { 
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $(".print-error-msg").show();
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
</script>
@endsection

