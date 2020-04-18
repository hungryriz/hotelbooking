hello!,{{$order->name}}<br/>
Your Change Password Done Successfully .<br/>
@if($utype=='user')

<a href="{{url('/')}}" class="btn btn-primary" >Login</a><br/>
@elseif($utype=='admin')

<a href="{{url('/admin')}}" class="btn btn-primary" >Login</a><br/>
@elseif($utype=='dispute')

<a href="{{url('/admin')}}" class="btn btn-primary" >Login</a><br/>
@elseif($utype=='shop')
<a href="{{url('/shop')}}" class="btn btn-primary" >Login</a><br/>
@else
hello!,{{$transporter->name}}<br/>
Your Change Password Done Successfully .<br/>
@endif



Regards,<br/><br/>
Admin<br/>
Ninya.com<br/>