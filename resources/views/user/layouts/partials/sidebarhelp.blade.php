<div class="profile-left col-md-3 col-sm-12 col-xs-12">
    <ul class="nav nav-tabs payment-tabs" role="tablist">
        <li @if(Request::segment(1)=='orders') class="active"  @endif>
            <a href="{{url('')}}"><span><i class="mdi mdi-shopping"></i></span> Help With Orders</a>
        </li>
        <li @if(Request::segment(1)=='queries') class="active"  @endif>
            <a href="{{url('/queries')}}"><span><i class="mdi mdi-percent"></i></span>General Queries</a>
        </li>
        <li @if(Request::segment(1)=='legal') class="active"  @endif>
            <a href="{{url('/legal')}}"><span><i class="mdi mdi-heart"></i></span> Legal</a>
        </li>
        <li @if(Request::segment(1)=='faq') class="active"  @endif>
            <a href="{{url('/faq')}}"><span><i class="mdi mdi-credit-card"></i></span> FAQs</a>
        </li>
        <li @if(Request::segment(1)=='useraddress') class="active"  @endif>
            <a href="{{url('')}}"><span><i class="mdi mdi-map-marker-outline"></i></span> Conversation Archive</a>
        </li>
    </ul>
</div>