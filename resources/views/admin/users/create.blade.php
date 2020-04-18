@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add User</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form class="form-horizontal" role="form" method="POST" id="user_form"  action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group col-xs-12 mb-2">
                     <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Name" autofocus>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif  
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <input id="password" type="password" class="form-control" name="password" required  placeholder="Password">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-2">
                     <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <input type="file" accept="image/*" name="avatar" class="dropify form-control" id="avatar" aria-describedby="fileHelp"  required >
                    @if ($errors->has('avatar'))
                        <span class="help-block">
                            <strong>{{ $errors->first('avatar') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-2 contact-repeater">
                    <div data-repeater-list="repeater-group">
                        <div class="input-group" data-repeater-item>
                        <div class="col-md-2 no-pad">
                                <!-- <input type="tel" id="country_code" class="form-control country_div" value="{{ old('country_code') }}" name="country_code" > -->
                                <input id="country_code" class="form-control country_div"  name="country_code" autocomplete="off" style="padding: 10px;" type="tel" value="{{ old('country_code') }}" required placeholder="@lang('transporter.create.country_code')">
                                </div>
                                
                                 <div class="col-md-10  no-pad">
                                <input id="phone1" type="text" class="form-control phone-number phone_fileds" name="phone_number" value="{{ old('phone_number') }}" placeholder="@lang('transporter.create.phone')" required autofocus>
                                 <input id="phone" type="hidden"  name="phone" value="{{ old('phone') }}"  >
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                            </div>
                            <!-- <span class="input-group-btn" id="button-addon2">
                                <button class="btn btn-danger" type="button" data-repeater-delete><i class="ft-x"></i></button>
                            </span> -->
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 mb-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-warning mr-1">
                        <i class="ft-x"></i> Cancel
                    </a>
                     <button type="button" onclick="return usercreate();"  class="btn btn-primary">
                        <i class="fa fa-check-square-o"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/dropify/dist/css/dropify.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/easy-autocomplete.min.css')}}">
<style type="text/css">
    .easy-autocomplete-container ul { max-height: 200px !important; overflow: auto !important; }
    .phone_fileds {
        margin-left: 0px !important;
        border-left: 1px solid #ccc !important;
        width: 100% !important
    }
    .no-pad{
        padding: 0px !important;
    }
</style>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/admin/plugins/dropify/dist/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.easy-autocomplete.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('.dropify').dropify();
    function usercreate(){
            var phone = $('#country_code').val()+$('#phone1').val();
            $('#phone').val(phone);
        $('#user_form').submit();
    }
    var options = {

      url: "{{asset('assets/js/countryCodes.json')}}",

      getValue: "name",

      list: {
        match: {
          enabled: true
        },
        onClickEvent: function() {
                var value = $("#country_code").getSelectedItemData().dial_code;

                $("#country_code").val(value).trigger("change");
            },
        maxNumberOfElements: 1000
      },

      template: {
        type: "custom",
        method: function(value, item) {
          return "<span class='flag flag-" + (item.dial_code).toLowerCase() + "' ></span>" +value+"("+item.dial_code+")";
        }
      },

      theme: "round"
    };
    $("#country_code").easyAutocomplete(options);
</script>
@endsection