
 @if(Auth::guest())
<!-- Login Sidebar Starts -->
    <div class="aside right-aside location" id="login-sidebar">
        <div class="aside-header">
            <span class="close" data-dismiss="aside"><i class="ion-close-round"></i></span>
        </div>
        <div class="aside-contents">
            <!-- Login Content Starts -->
            <div class="login-content">
                
                    <!-- Login Form Section Starts -->
                    <div class="login-form-sec">
                        <h5 class="login-tit">Login</h5>
                        <div class="social-login">
                           <a href="javascript::void(0);" onclick="FBLogin(2);"  class="social-login-item"><i class="ion-social-facebook"></i></a>
                            <a id="sign-in-or-out-button" data-id="login" href="javascript:void(0);" class="social-reg sign-in-or-out-button social-login-item"><i class="ion-social-google"></i></a>
                            <form  id="login_form" action="{{url('social/login')}}" method="post" >
                                {{ csrf_field() }}
                            <input type="hidden" id="login_by" value="" name="login_by" />
                            <input type="hidden" name="accessToken" value="" id="accessToken" />
                            <input type="hidden" name="login_type" value="" id="login_type" />
                            <input type="button" id="login_social_btn" style="display:none" value="submit" />

                    </form>
                        </div>
                        <div class="or">OR</div>
                        <form  role="form" method="POST" action="{{ route('login') }}" class="popup-form" id="myLogin">
                            <div id="login_form_error" class="print-error-msg"><ul class="alert-danger list-unstyled"></ul></div>
                        {{ csrf_field() }}
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control">
                                
                            </div>
                            <div class="print-error-msg alert-danger error_phone"></div> 
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="password" name="password"  class="form-control">
                            </div>
                            <div class="print-error-msg alert-danger error_password"></div> 
                            <a href="javascript:void(0);" class="theme-link forgot-link">Forgot Password</a>
                            <button type="button" class="login-btn login_btn">Login</button>
                         </form>
                    </div>
                    <!-- Login Form Section Ends -->
                    <!-- Forgot Form Section Starts -->
                    <div class="forgot-form-sec">
                       
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}
                            <h5 class="login-tit">Forgot Password</h5>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required class="form-control">
                            </div>
                            <button type="submit" class="login-btn forgot-btn ">Submit</button>
                        </form>
                         <button type="button" class="forgot-btn login-btn login-link">Login</button>
                    </div>
                    <!-- Forgot Form Section Ends -->
               
            </div>
            <!-- Login Content Ends -->
            
        </div>
    </div>
    <!-- Login Sidebar Ends -->
    <!-- Signup Sidebar Starts -->
     <!-- Signup Sidebar Starts -->
    <div class="aside right-aside location" id="signup-sidebar">
        <div class="aside-header">
            <span class="close" data-dismiss="aside"><i class="ion-close-round"></i></span>
        </div>
        <div class="aside-contents">
            <!-- Login Head Starts -->
            <div class="login-head row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h5 class="login-tit">Signup</h5>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                    <!-- <img src="img/login-icon.jpg" class="login-icon"> -->
                </div>
            </div>
            <!-- Login Head Ends -->
           
            <!-- Login Content Starts -->
            <div class="login-content">
                <form  class="popup-form" method="POST" id="register_form" action="{{ url('/register') }}">
                     
                     {{ csrf_field() }}
                    <div class="social-login">
                        <a href="javascript::void(0);" onclick="FBLogin(1);" class="social-login-item"><i class="ion-social-facebook"></i></a>
                        <a id="sign-in-or-out-button"  data-id="register" href="javascript:void(0);" class="social-reg sign-in-or-out-button social-login-item"><i class="ion-social-google"></i></a>
                    </div>
                    <div class="or">OR</div>
                    <div id="first_step">
                        <div class="print-error-msg common">
                            <ul class="alert-success list-unstyled"><li class="error_error"></li></ul>
                        </div>   
                        <input type="text" class="form-control form-white dm" placeholder="Name" id="dname" name="name" value="{{ old('name') }}">
                        <input type="email" class="form-control form-white dm" id="demail" name="email"  value="{{ old('email') }}" placeholder="Email">
                        <div class="form-group row">
                            <div class="col-xs-12">
                                <label>Phone Number</label>
                            </div>
                           
                            <div class="col-xs-3">
                                <input type="text" id="country_code" name="country_code" class="form-control" placeholder="+56">
                            </div>
                            <div class="col-xs-9 p-l-0">
                                <input type="number" min="0" class="form-control phone-number" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="Enter Phone Number" required>
                            </div> 
                                                
                        </div>
                        <div class="print-error-msg alert-danger error_phone"></div>  
                        <input type="hidden" id="login_by" value="" name="login_by" />
                        <input type="hidden" name="accessToken" value="" id="accessToken" />
                        <div class="form-group mobile_otp_verfication" style="display: none;">
                            <label>OTP</label>
                            <input type="text" class="form-control " placeholder="Otp" name="otp" id="otp" value="" >
                        </div>
                        <div class="print-error-msg alert-danger error_otp"></div> 
                        <button type="button" onclick="smsLogin();" class="login-btn mobile_verfication">Verify Phone Number</button>
                        <button type="button" class="login-btn mobile_otp_verfication" onclick="checkotp();" value="Verify Otp" style="display: none;">Verify OTP</button>
                    </div>
                    <div id="second_step" style="display: none;">
                        <input type="hidden" id="otp_ref"  name="otp_ref" value="" />
                        <input type="hidden" id="otp_phone"  name="phone" value="" />
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" >
                            <div class="print-error-msg alert-danger error_name"></div> 
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" id="email" name="email"  value="{{ old('email') }}" placeholder="">
                            <div class="print-error-msg alert-danger error_email"></div> 
                        </div>
                        <div class="form-group"  id="password1">
                            <label>Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="print-error-msg alert-danger error_password"></div> 
                        </div>
                         <div class="form-group" id="password2">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation"  name="password_confirmation">
                        </div>
                           <p class="signup-txt"> <input type="checkbox" checked  value="accept_2" id="check_2" name="check_2" />
                            By creating an account, I accept the Terms & Conditions</p>
                        <div class="print-error-msg alert-danger error_terms"></div> 
                        <button type="button" class="login-btn register_btn">Signup</button>
                        <br/><br/><br/>
                    </div>
                </form>
            </div>
            <!-- Login Content Ends -->
        </div>
    </div>
    <!-- Signup Sidebar Ends -->
 <script src="{{ asset('assets/user/js/jquery.easy-autocomplete.min.js') }}" type="text/javascript"></script>
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/user/css/easy-autocomplete.min.css')}}">
    <style type="text/css">
        .easy-autocomplete-container ul { max-height: 200px !important; overflow: auto !important; }
        .easy-autocomplete { width:200px!important; }
        .phone_fileds {
            margin-left: 0px !important;
            border-left: 1px solid #ccc !important;
            width: 100% !important
        }
        .no-pad{
            padding: 0px !important;
        }
    </style>
<script>

var options = {

  url: "{{asset('assets/user/js/countryCodes.json')}}",

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
 var my_otp='';
    function smsLogin(){
        var countryCode = document.getElementById("country_code").value;
        var phoneNumber = document.getElementById("phone_number").value;
        if(countryCode!=''){
        //var code = $('.selected-dial-code').html(); 
        //$('#country_code').val(code);
        var countryCode = document.getElementById("country_code").value;
        var phoneNumber = document.getElementById("phone_number").value;
        var accessToken = $("#register_form #accessToken").val();
        var login_by = $("#register_form #login_by").val();
        var phone;
        $('#otp_phone').val(countryCode+''+phoneNumber);
        var csrf = $("input[name='_token']").val();;
        if(phoneNumber!=''){
            phone = countryCode+''+phoneNumber;
        }else{
            phone = '';
        }
            $.ajax({
                url: "{{url('/otp')}}",
                type:'POST',
                data:{ phone :phone ,'_token':csrf ,'login_by':login_by,'accessToken':accessToken},
                success: function(data) { 
                    if($.isEmptyObject(data.error)){
                        my_otp=data.otp;
                        $('.mobile_otp_verfication').show();
                        $('.mobile_verfication').hide();
                        $('.mobile_verfication').html("<p class='helper'> Please Wait... </p>");
                        $('#phone_number').attr('readonly',true);
                        $('#country_code').attr('readonly',true);
                        $('#otp').val(data.otp);
                        $('#otp').attr('readonly',true);
                        $("#register_form .common").html('<ul class="list-unstyled"></ul>');
                        $(".alert-danger").css("display", "none");
                        $("#register_form .common").find('ul').removeClass('alert-danger').addClass('alert-success');
                        $("#register_form .common").find("ul").append('<li>'+data.message+'</li>');
                    }else{ 
                        printErrorMsg(data.error,'register_form');
                    }
                },
                error:function(jqXhr,status) { 
                    if(jqXhr.status === 422) {
                        $(".alert-danger").css("display", "block");
                        $("#register_form .print-error-msg").html('');
                        $("#register_form .common").html('<ul class="list-unstyled"><li class="error_error "></li></ul>');
                        $("#register_form .print-error-msg").show();
                        var errors = jqXhr.responseJSON;
                        $.each( errors , function( key, value ) { 
                            if(key=='error'){
                                $("#register_form .common").find('ul').removeClass('alert-success').addClass('alert-danger');
                            }
                            $("#register_form").find(".error_"+key).html(value);
                        }); 
                    } 
                }

            });
        }else{
            $(".alert-danger").css("display", "block");
            $("#register_form").find(".error_phone").html('');
            $("#register_form").find(".error_phone").html('Country code Required');

        }
    }
    function checkotp(){
        var otp = document.getElementById("otp").value;
        if(otp){
            if(my_otp == otp){
                if($('#register_form #login_by').val()!=''){ 
                    //$(".register_btn" ).trigger('click');
                }
                $("#register_form .print-error-msg").find("ul").html('');
                $('#mobile_otp_verfication').html("<p class='helper'> Please Wait... </p>");
                $('#phone_number').attr('readonly',true);
                $('#country_code').attr('readonly',true);
                $('.mobile_otp_verfication').hide();
                $('#second_step').fadeIn(400);
                $('.register_btn').show();
                $('.dm').hide();
                $('#mobile_verfication').show().html("<p class='helper'> * Phone Number Verified </p>");
                my_otp='';
            }else{
                $("#register_form .print-error-msg").html('');
                $("#register_form").find(".error_otp").html('Otp not Matched!');
            }
        }else{
            $("#register_form .print-error-msg").html('');
            $("#register_form").find(".error_otp").html('Otp field is required');
        }
    }
    $('#dname').on('blur',function(){
        $("#register_form #name").val($('#dname').val());
    });
    $('#demail').on('blur',function(){
        $("#register_form #email").val($('#demail').val());
    })
    function printErrorMsg (msg,form) { 
        $("#"+form+".common").find('ul').html('');
        $("#"+form+".common").css('display','block');
        $("#"+form+".common").show(); 
        if (typeof msg === 'string'){
            $("#"+form+".common").find('ul').removeClass('alert-success').addClass('alert-danger');
            $("#"+form+".common").find('ul').append('<li>'+msg+'</li>');
        }else{
            $.each( msg, function( key, value ) {
                $("#"+form+".print-error-msg").find('ul').append('<li>'+value+'</li>');
            });
        }
    }
    $('#pac-input').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
          {
            if($('#pac-input').val()==''){
                 $('#my_map_form_current').submit();
            }else{
                if($('#my_map_form #latitude').val()!='' && $('#my_map_form #longitude').val()!=''){
                    $('#my_map_form').submit();
                }else{
                  return false;  
                }
            }
            return false;
        }
    });   
    $('.findfood').on('click',function () {
         
        if($('#pac-input').val()==''){
             $('#my_map_form_current').submit();
        }else{
            $('#my_map_form').submit();
        }
           
    });  
    $('.signinform').on('click',function(){
        $("#myLogin .print-error-msg").html(''); 
        $("#myLogin #phone").val('');
        $("#myLogin #password").val('');
        $('#login-sidebar').asidebar('open');
        $('.login-link').trigger('click');
    });
    $('.signupform').on('click',function(){
        $("#register_form .print-error-msg").html('');
        $("#register_form #country_code").val('');
        $("#register_form #country_code").prop('readonly',false);
        $("#register_form #phone_number").val('');
        $("#register_form #phone_number").prop('readonly',false);
        $("#register_form #otp").val('');
        $("#register_form #otp").prop('readonly',false);
        $("#register_form #name").val('');
        $("#register_form #email").val('');
        $("#register_form #password").val('');
        $("#register_form #password_confirmation").val('');
        $('.mobile_otp_verfication').hide();
        $('.mobile_verfication').show();
         $('.mobile_verfication').html('Verify Phone Number');
        $('#second_step').hide();
        $('.dm').hide();
        $("#register_form #accessToken").val('');
        $("#register_form #login_by").val('');
        $('#signup-sidebar').asidebar('open');
    });
    $('.login_btn').on('click',function(){ 
        var password = document.getElementById("password").value;
        var phoneNumber = document.getElementById("phone").value;
        var csrf = $("input[name='_token']").val();;
        $.ajax({
            url: "{{url('/login')}}",
            type:'POST',
            data:{ phone : phoneNumber,password:password,'_token':csrf },
            success: function(data) { 
                if($('#latitude_cur').val()){
                        $('#my_map_form_current').submit();
                    }else{
                        location.reload();
                    }
            },
            error:function(jqXhr,status) { 
                if(jqXhr.status === 422) {
                    $("#myLogin .print-error-msg").html('');
                    $("#myLogin .print-error-msg").show();
                    var errors = jqXhr.responseJSON;
                    console.log(errors);
                    $.each( errors , function( key, value ) { 
                        $("#myLogin").find(".error_"+key).html(value);
                    }); 
                } 
            }
        });
    });
    $('.register_btn').on('click',function(){ 
        var csrf = $("input[name='_token']").val();;
        if($('#check_2').is(':checked')){
            $.ajax({
                url: "{{url('/register')}}",
                type:'POST',
                data:$('#register_form').serialize(),
                success: function(data) { 
                    if($('#latitude_cur').val()){
                        $('#my_map_form_current').submit();
                    }else{
                        location.reload();
                    }
                },
                error:function(jqXhr,status) { 
                    if(jqXhr.status === 422) {
                        $("#register_form .print-error-msg").html('');
                        $("#register_form .print-error-msg").show();
                        var errors = jqXhr.responseJSON;
                       
                        $.each( errors , function( key, value ) { 
                            $("#register_form").find(".error_"+key).html(value);
                        }); 
                    } 
                }
            });
        }else{
            $("#register_form .print-error-msg").html('');
            $("#register_form").find(".error_terms").html('Please Check Term & Condition'); 
        }
    });

     $('#login_social_btn').on('click',function(){ 
        var csrf = $("input[name='_token']").val();;
        
            $.ajax({
                url: "{{url('/social/login')}}",
                type:'POST',
                data:$('#login_form').serialize(),
                success: function(data) { 
                    if($('#latitude_cur').val()){
                        $('#my_map_form_current').submit();
                    }else{
                        location.reload();
                    }
                },
                error:function(jqXhr,status) { 
                    if(jqXhr.status === 422) {
                        $("#login_form_error").html('<ul class="alert-danger"></ul>');
                        $("#login_form_error").show();
                        var errors = jqXhr.responseJSON;
                        console.log(errors);
                        $.each( errors , function( key, value ) { 
                            //alert(value);
                            $("#login_form_error").find("ul").append('<li>'+value+'</li>');
                        }); 
                    } 
                }
            });
    });
/*$('.login_btn').on('click',function(){ 
        var password = document.getElementById("password").value;
        var phoneNumber = document.getElementById("phone").value;
        var csrf = $("input[name='_token']").val();;
        $.ajax({
            url: "{{url('/login')}}",
            type:'POST',
            data:{ phone : phoneNumber,password:password,'_token':csrf },
            success: function(data) { 
                //window.location.href = "{{url('/home')}}";
                if($('#latitude_cur').val()){
                $('#my_map_form_current').submit();
                }else{
                    location.reload();
                }
            },
            error:function(jqXhr,status) { 
                if(jqXhr.status === 422) {
                    $("#login_form_error ").find("ul").html('');
                    $("#login_form_error").show();
                    var errors = jqXhr.responseJSON;
                    console.log(errors);
                    $.each( errors , function( key, value ) { 
                        $("#login_form_error").find("ul").append('<li>'+value+'</li>');
                    }); 
                } 
            }
        });
    });*/

$('.dm').hide();
  // This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {

  if (response.status === 'connected') {
      // Logged into your app and Facebook.
      // we need to hide FB login button
      $('#register_form #accessToken').val(response.authResponse.accessToken);
      $('#register_form #login_by').val('facebook');
      //fetch data from facebook
      getUserInfo();
  } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      $('#status').html('Please log into this app.');
  } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      $('#status').html('Please log into facebook');
  }
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

  window.fbAsyncInit = function() {
    FB.init({
      appId      : "{{Setting::get('FB_CLIENT_ID')}}",
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.5' // use version 2.3
    });

    /*FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });*/

  };

    // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

function getUserInfo() {
    FB.api('/me?fields=email,name,first_name,last_name', function(response) {
        $('#register_form #email').val(response.email);
        $('#register_form #name').val(response.name);
        $('#register_form #demail').val(response.email);
        $('#register_form #dname').val(response.name);
        $('#register_form #social_login_id').val(response.id);
        $('#register_form #password1').hide();
        $('#register_form #password2').hide();
        $('.dm').show();
    });
}
function FBLogin(id)
{

      FB.login(function(response) {
         if (response.authResponse) 
         {   
            //var access_token = response.session.access_token;
            if(id==1){
                $('#register_form #accessToken').val(response.authResponse.accessToken);
                $('#register_form #login_by').val('facebook');
                getUserInfo(); //Get User Information.
            }else if(id==2){
                $('#login_form #accessToken').val(response.authResponse.accessToken);
                $('#login_form #login_by').val('facebook');
                $('#login_form #login_type').val('2');
                $('#login_form #login_social_btn').trigger('click');
            }   
          } else
          {
           alert('Authorization failed.');
          }
       },{scope: 'public_profile,email'});
}
</script>
<script type="text/javascript">
    $('.sign-in-or-out-button').click(function() { 
        handleSignInClick(); 
        if($(this).data('id')=='login'){ 
            $('#login_type').val(2); 
            if($('#login_form #accessToken').val()==''){
                makeApiCall();
            $('#login_social_btn').trigger('click');
            }
            
        }else{
            $('#register_form #password1').hide();
            $('#register_form #password2').hide();
            $('#login_type').val(1);
            if($('#register_form #accessToken').val()==''){
                makeApiCall();
            }
            
            
        }
    });
    function handleClientLoad() {
        // Loads the client library and the auth2 library together for efficiency.
        // Loading the auth2 library is optional here since `gapi.client.init` function will load
        // it if not already loaded. Loading it upfront can save one network request.
        gapi.load('client:auth2', initClient);
    }
        var discoveryUrl = 'https://www.googleapis.com/discovery/v1/apis/drive/v3/rest';
        var SCOPE = 'https://www.googleapis.com/auth/drive.metadata.readonly';
    function initClient() {
        // Initialize the client with API key and People API, and initialize OAuth with an
        // OAuth 2.0 client ID and scopes (space delimited string) to request access.
        gapi.client.init({
            apiKey: "{{Setting::get('GOOGLE_API_KEY')}}",
            discoveryDocs: [discoveryUrl],
            clientId: "{{Setting::get('GOOGLE_CLIENT_ID')}}",
            scope: SCOPE
        }).then(function () {
          // Listen for sign-in state changes.
          gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);

          // Handle the initial sign-in state.
          //updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
        });
    }

    function updateSigninStatus(isSignedIn) { 
        // When signin status changes, this function is called.
        // If the signin status is changed to signedIn, we make an API call.
        if (isSignedIn) {
            setSigninStatus();
          //makeApiCall();
        }
    }

    function handleSignInClick(event) {
        // Ideally the button should only show up after gapi.client.init finishes, so that this
        // handler won't be called before OAuth is initialized.
        gapi.auth2.getAuthInstance().signIn();
    }

    function handleSignOutClick(event) {
        gapi.auth2.getAuthInstance().signOut();
    }

    function makeApiCall() {  
        var id = $('#login_type').val(); 
        var user = gapi.auth2.getAuthInstance().currentUser.get();
        var profile = gapi.auth2.getAuthInstance().currentUser.get().getBasicProfile();
        if(id==1){
                $('#register_form #accessToken').val(gapi.client.getToken().access_token);
                $('#register_form #login_by').val('google');
                $('#register_form #email').val(profile.getEmail());
                $('#register_form #name').val(profile.getName());
                 $('#register_form #demail').val(profile.getEmail());
                $('#register_form #dname').val(profile.getName());
                $('.dm').show();

        }else if(id==2){ 
             $('#login_form #accessToken').val(gapi.client.getToken().access_token);
             $('#login_form #login_by').val('google');
        }
        
    }

    function setSigninStatus(isSignedIn) { 
        var user = gapi.auth2.getAuthInstance().currentUser.get();
        var profile = gapi.auth2.getAuthInstance().currentUser.get().getBasicProfile();
        console.log(profile);
        var isAuthorized = user.hasGrantedScopes(SCOPE); 
        var id = $('#login_type').val(); 
        if (isAuthorized) {
            if(id==1){
                $('#register_form #accessToken').val(gapi.client.getToken().access_token);
                $('#register_form #login_by').val('google');
                $('#register_form #email').val(profile.getEmail());
                $('#register_form #name').val(profile.getName());
                $('#register_form #demail').val(profile.getEmail());
                $('#register_form #dname').val(profile.getName());
                $('.dm').show();

            }else if(id==2){ 
                $('#login_form #accessToken').val(gapi.client.getToken().access_token);
                $('#login_form #login_by').val('google');
                $('#login_social_btn').trigger('click');
            }
           
        } else {
          $('#register_form #accessToken').val('');
            $('#register_form #login_by').val('');
            $('#register_form #email').val('');
            $('#register_form #name').val('');
        }
    }
    </script>
    <script async defer src="https://apis.google.com/js/api.js"
      onload="this.onload=function(){};handleClientLoad()"
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>

@else
<!-- Edit Profile Starts -->
    <div class="aside right-aside location" id="edit-profile-sidebar">
        <div class="aside-header">
            <span class="close" data-dismiss="aside"><i class="ion-close-round"></i></span>
            <h5 class="aside-tit">Edit Profile</h5>
        </div>
        <div class="aside-contents">
            
                <!-- Edit Profile Box Starts -->
                <div class="edit-profile-box">
                     <form action="{{url('/profile')}}" class="edit-profile-section" method="POST" enctype= "multipart/form-data" >
                            {{csrf_field()}}
                    <!-- Edit Details Starts -->
                    <div class="edit-details">
                        <h6 class="edit-details-tit">Phone Number</h6>
                        <div class="row m-0">
                            <p class="pull-left edit-details-txt">{{Auth::user()->phone}}</p>
                            <a href="javascript:void(0);" class="edit-link theme-link pull-right">Change</a>
                        </div>
                    </div>
                    <!-- Edit Details Ends -->
                    <!-- Edit form Section Starts -->
                    <div class="edit-form-sec">
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control" value="{{Auth::user()->phone}}">
                        </div>
                        <button class="cmn-btn">Update</button>
                    </div>
                    </form>
                    <!-- Edit form Section Ends -->
                </div>
                <!-- Edit Profile Box Ends -->
                <!-- Edit Profile Box Starts -->
                <div class="edit-profile-box">
                    <!-- Edit Details Starts -->
                    <form action="{{url('/profile')}}" class="edit-profile-section" method="POST" enctype= "multipart/form-data" >
                            {{csrf_field()}}
                    
                    <div class="edit-details">
                        <h6 class="edit-details-tit">Email</h6>
                        <div class="row m-0">
                            <p class="pull-left edit-details-txt">{{Auth::user()->email}}</p>
                            <a href="javascript:void(0);" class="edit-link theme-link pull-right">Change</a>
                        </div>
                    </div>
                    <!-- Edit Details Ends -->
                    <!-- Edit form Section Starts -->
                    <div class="edit-form-sec">
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" value="{{Auth::user()->email}}">
                        </div>
                        <button class="cmn-btn">Update</button>
                    </div>
                    </form>
                    <!-- Edit form Section Ends -->
                </div>
                <!-- Edit Profile Box Ends -->
                <!-- Edit Profile Box Starts -->
                <div class="edit-profile-box">
                    <!-- Edit Details Starts -->
                     <form action="{{url('/profile')}}" class="edit-profile-section" method="POST" enctype= "multipart/form-data" >
                            {{csrf_field()}}
                    <div class="edit-details">
                        <h6 class="edit-details-tit">Password</h6>
                        <div class="row m-0">
                            <p class="pull-left edit-details-txt">********</p>
                            <a href="javascript:void(0);" class="edit-link theme-link pull-right">Change</a>
                        </div>
                    </div>
                    <!-- Edit Details Ends -->
                    <!-- Edit form Section Starts -->
                    <div class="edit-form-sec">
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" value="">
                        </div>
                        <button class="cmn-btn">Update</button>
                    </div>
                    </form>
                    <!-- Edit form Section Ends -->
                </div>
                <!-- Edit Profile Box Ends -->
            <!-- </form> -->
        </div>
    </div>
    <!-- Edit Profile Sidebar Ends -->
   
    
@endif


@if(Request::segment(1)=='restaurant' && Request::has('myaddress'))
 <!-- Location Sidebar Starts -->
     <div  class="aside location" id="location-sidebar">
        <div class="aside-header">
            <span class="close" data-dismiss="aside"><i class="ion-close-round"></i></span>
            <h5 class="aside-tit">Save Address</h5>
        </div>
        <div class="aside-contents">
            <form action="{{route('useraddress.store')}}" method="POST" id="comon-form" class="common-form">
                 {{ csrf_field() }}
                <div class="" id="my_map" style="width: 100%; height: 200px;"></div>
                <div class="input-section">
                    <div class="form-group">
                        <label>Address</label>
                        <input class="form-control addr-mapaddrs" id="pac-input" name="map_address" type="text" value="{{Session::get('search_loc')}}">
                <input type="hidden" id="latitude" name="latitude" value="{{ Session::get('latitude') }}" readonly required>
                <input type="hidden" id="longitude" name="longitude" value="{{ Session::get('longitude') }}" readonly required>
                    </div>
                    <div class="form-group">
                        <label>Door / Flat no.</label>
                        <input class="form-control addr-building" name="building" type="text" value="">
                    </div>
                    <div class="form-group">
                        <label>Landmark</label>
                        <input class="form-control addr-landmark" name="landmark" type="text">
                    </div>
                    <div class="form-group">
                        <label>Address Type</label>

                    </div>
                </div>
                <button class="add-address-btn">Save &amp; Proceed</button>
            </form>
        </div>
    </div>
    <!-- Location Sidebar Ends -->
    @endif
@if(Request::segment(1)=='restaurants' || Request::segment(1)=='restaurant') 
  <!-- Nav Location Sidebar Starts -->
    <div class="aside location" id="nav-location-sidebar">
        <div class="aside-header">
            <span class="close" data-dismiss="aside"><i class="ion-close-round"></i></span>
            <h5 class="aside-tit">Search Location</h5>
        </div>
        <div class="aside-contents">
            <div class="aside-content-head">
                <form  action="{{url('restaurants')}}" id="my_map_form" >
                <input type="text" id="pac-input" class="form-control search-loc-form pac-input" placeholder="Search for area,street name..." value="{{Session::get('search_loc')}}" name="search_loc">
                <input type="hidden" id="latitude" name="latitude" value="{{ Session::get('latitude') }}" readonly >
                <input type="hidden" id="longitude" name="longitude" value="{{ Session::get('longitude') }}" readonly >
                <div id="my_map"   style="height:500px;width:500px;display: none" ></div>
                <div id="map"   style="height:500px;width:500px;display: none" ></div>
                </form>
            </div> 
            <form  action="{{url('restaurants')}}" id="my_map_form_current" >
                <input type="hidden" id="pac-input_cur" class="form-control search-loc-form" placeholder="Search for area,street name..." name="search_loc" value="{{ old('latitude') }}" >
                <input type="hidden" id="latitude_cur" name="latitude" value="{{ old('latitude') }}" readonly >
                <input type="hidden" id="longitude_cur" name="longitude" value="{{ old('longitude') }}" readonly >
                
                </form>
            <a href="#" class="gps row m-0 my_map_form_current">
                <div class="gps-left pull-left">
                    <i class="ion-pinpoint"></i>
                </div>
                <div class="gps-right">
                    <h6 class="gps-tit">GPS Location</h6>
                    <p class="gps-txt">Using GPS</p>
                </div> 
            </a>
           <!--  <div class="saved-address">
                <h6 class="avail-coupon-tit">Saved Address</h6>
                <a href="#" class="saved-address-box row m-0">
                    <div class="save-add-left pull-left">
                        <i class="ion-ios-location-outline save-add-icon"></i>
                    </div>
                    <div class="save-add-right">
                        <h6 class="save-add-tit">Work</h6>
                        <p class="save-add-txt">Dry Hollow Rd, Cokeville, WY 83114, USA</p>
                    </div>
                </a>
                <a href="#" class="saved-address-box row m-0">
                    <div class="save-add-left pull-left">
                        <i class="ion-ios-location-outline save-add-icon"></i>
                    </div>
                    <div class="save-add-right">
                        <h6 class="save-add-tit">Others</h6>
                        <p class="save-add-txt">Dry Hollow Rd, Cokeville, WY 83114, USA</p>
                    </div>
                </a>
                <a href="#" class="saved-address-box row m-0">
                    <div class="save-add-left pull-left">
                        <i class="ion-ios-location-outline save-add-icon"></i>
                    </div>
                    <div class="save-add-right">
                        <h6 class="save-add-tit">Work</h6>
                        <p class="save-add-txt">Dry Hollow Rd, Cokeville, WY 83114, USA</p>
                    </div>
                </a>
            </div> -->
        </div>
    </div>
    @endif
    <!-- Nav Location Sidebar Ends -->
    <div class="aside-backdrop"></div>
@if(Request::segment(1)=='' || Request::segment(1)=='restaurants' || Request::segment(1)=='useraddress' || Request::segment(1)=='orders' || Request::get('myaddress') || Request::segment(1)=='restaurant')
<script>
    var map;
    var input = document.getElementById('pac-input');
    var latitude = document.getElementById('latitude');
    var longitude = document.getElementById('longitude');
    var input_cur = document.getElementById('pac-input_cur');
    var latitude_cur = document.getElementById('latitude_cur');
    var longitude_cur = document.getElementById('longitude_cur');
    var address = document.getElementById('address');

    function initMap() { 

        var userLocation = new google.maps.LatLng(
                13.066239,
                80.274816
            );
        
        map = new google.maps.Map(document.getElementById('my_map'), {
            center: userLocation,
            zoom: 15
        });

        var service = new google.maps.places.PlacesService(map);
        var autocomplete = new google.maps.places.Autocomplete(input);
        var infowindow = new google.maps.InfoWindow();

        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow({
            content: "Shop Location",
        });

        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            anchorPoint: new google.maps.Point(0, -29)
        });

        marker.setVisible(true);
        marker.setPosition(userLocation);
        infowindow.open(map, marker);

        if (navigator.geolocation) { 
            navigator.geolocation.getCurrentPosition(function(location) { console.log(location);
                var userLocation = new google.maps.LatLng(
                    location.coords.latitude,
                    location.coords.longitude
                );
               
                latitude_cur.value = location.coords.latitude;
                longitude_cur.value = location.coords.longitude;
                
                
                //var latLngvar = location.coords.latitude+' '+location.coords.longitude+"   ";
                var latlng = {lat: parseFloat(location.coords.latitude), lng: parseFloat(location.coords.longitude)};
                getcustomaddress(latlng);
                marker.setPosition(userLocation);
                map.setCenter(userLocation);
                map.setZoom(13);
            });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }

        google.maps.event.addListener(map, 'click', updateMarker);
        google.maps.event.addListener(marker, 'dragend', updateMarker);

        function getcustomaddress(latLngvar){
            var geocoder = new google.maps.Geocoder();
            console.log(latLngvar);
            geocoder.geocode({'latLng': latLngvar}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    //console.log(results[0]);
                    if (results[0]) {
                        
                        input_cur.value = results[0].formatted_address;
                         
                        //updateForm(event.latLng.lat(), event.latLng.lng(), results[0].formatted_address);
                    } else {
                        alert('No Address Found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
        }

        function updateMarker(event) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': event.latLng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        input.value = results[0].formatted_address;
                        updateForm(event.latLng.lat(), event.latLng.lng(), results[0].formatted_address);
                    } else {
                        alert('No Address Found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });

            marker.setPosition(event.latLng);
            map.setCenter(event.latLng);
        }

        autocomplete.addListener('place_changed', function(event) {
            marker.setVisible(false);
            var place = autocomplete.getPlace();

            if (place.hasOwnProperty('place_id')) {
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }
                updateLocation(place.geometry.location);
            } else {
                service.textSearch({
                    query: place.name
                }, function(results, status) {
                    if (status == google.maps.places.PlacesServiceStatus.OK) {
                        updateLocation(results[0].geometry.location, results[0].formatted_address);
                        input.value = results[0].formatted_address;

                    }
                });
            }
        });

        function updateLocation(location) {
            map.setCenter(location);
            marker.setPosition(location);
            marker.setVisible(true);
            infowindow.open(map, marker);
            updateForm(location.lat(), location.lng(), input.value);
        }

        function updateForm(lat, lng, addr) {
            console.log(lat,lng, addr);
            latitude.value = lat;
            longitude.value = lng;
            @if(Request::get('search_loc'))
             $('#my_map_form').submit();
            @endif
        }
    }
    $('.my_map_form_current').on('click',function(){
        $('#my_map_form_current').submit();
    })

    /*$('.pac-input').on('blur',function(){
        if($('#latitude').val()!=''){
            $('#my_map_form').submit();
        }
    })*/

</script>
    
    
    
@endif
<script src="https://maps.googleapis.com/maps/api/js?key={{Setting::get('GOOGLE_MAP_KEY')}}&libraries=places&callback=initMap" async defer></script>