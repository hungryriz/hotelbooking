<div class="profile-left col-md-3 col-sm-12 col-xs-12">
    <ul class="nav nav-tabs payment-tabs" role="tablist">
        <li @if(Request::segment(1)=='orders') class="active"  @endif>
            <a href="{{url('/orders')}}"><span><i class="mdi mdi-shopping"></i></span> Orders</a>
        </li>
        <li @if(Request::segment(1)=='offers') class="active"  @endif>
            <a href="{{url('/offers')}}"><span><i class="mdi mdi-percent"></i></span>Offers</a>
        </li>
        <li @if(Request::segment(1)=='favourite') class="active"  @endif>
            <a href="{{url('/favourite')}}"><span><i class="mdi mdi-heart"></i></span> Favourites</a>
        </li>
        <li @if(Request::segment(1)=='payments') class="active"  @endif>
            <a href="{{url('/payments')}}"><span><i class="mdi mdi-credit-card"></i></span> Payments</a>
        </li>
        <li @if(Request::segment(1)=='useraddress') class="active"  @endif>
            <a href="{{url('/useraddress')}}"><span><i class="mdi mdi-map-marker-outline"></i></span> Addresses</a>
        </li>
    </ul>
</div>