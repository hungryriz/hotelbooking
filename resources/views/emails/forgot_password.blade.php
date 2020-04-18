hello!,<br/>
You are receiving this email because we received a password reset request for your account.<br/>
@if($type=='user')
<a href="{{url('/').route('password.reset', $data['token'], false)}}" class="btn btn-primary" >Reset Password</a><br/>
@elseif($type=='admin')
<a href="{{url('/').route('admin.password.reset', $data['token'], false)}}" class="btn btn-primary" >Reset Password</a><br/>
@elseif($type=='shop')
<a href="{{url('/').route('shop.password.reset', $data['token'], false)}}" class="btn btn-primary" >Reset Password</a><br/>
@endif

If you did not request a password reset, no further action is required.<br/>

Regards,<br/><br/>
Admin<br/>
Foodskooter.com<br/>