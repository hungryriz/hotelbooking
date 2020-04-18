@extends('user.layouts.app')

@section('content')
 <!-- Content Wrapper Starts -->
        <div class="content-wrapper">
            <div class="profile blue-bg">
                <!-- Profile Head Starts -->
               @include('user.layouts.partials.user_common_support')
                <!-- Profile Head Ends -->
                <!-- Profile Content Starts -->
                <div class="profile-content">
                    <div class="container-fluid">
                        <!-- Profile Inner Starts -->
                        <div class="profile-inner row">
                            <!-- Profile Left Starts -->
                             @include('user.layouts.partials.sidebarhelp')
                            <!-- Profile Left Ends -->
                            <!-- Profile Right Starts -->
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="profile-right">
                                    <div class="profile-right-head">
                                        <h4>Legal</h4>
                                    </div>
                                    <div class="profile-coupons">
                                        <!-- Profile Coupons Block Starts -->
                                        <div class="profile-coupons-block row">
                                            <!-- Coupons Box Starts -->
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                            
                                                <!-- Coupon Box Starts -->
                                            <button class="accordion">Terms Of Use</button>
                                            <div class="helppanel">
                                                @if(Setting::get('terms'))
                                                <div class="short-content">{!!Setting::get('terms')!!}</div>
                                                <a href="{{url('/terms')}}"><p class="read">Read More</p></a>
                                                @else
                                                <p>No Content</p>
                                                @endif
                                            </div>

                                            <button class="accordion">Privacy Policy</button>
                                            <div class="helppanel">
                                                @if(Setting::get('privacy'))
                                                <p class="short-content">{!!Setting::get('privacy')!!}</p>
                                                <a href="{{url('/privacy')}}"><p class="read">Read More</p></a>
                                                @else
                                                <p>No Content</p>
                                                @endif
                                            </div>

                                            <button class="accordion">Cancellations and Refunds</button>
                                            <div class="helppanel">
                                                @if(Setting::get('refund'))
                                                <p class="short-content">{!!Setting::get('refund')!!}</p>
                                                <a href="{{url('/refund')}}"><p class="read">Read More</p></a>
                                                @else
                                                <p>No Content</p>
                                                @endif
                                            </div>

                                            <button class="accordion">Terms of Use for Foodie ON-TIME / Assured</button>
                                            <div class="helppanel">
                                                @if(Setting::get('otherterms'))
                                                <p>{!!Setting::get('otherterms')!!}</p>
                                                <a href="{{url('/otherterms')}}"><p class="read">Read More</p></a>
                                                @else
                                                <p>No Content</p>
                                                @endif
                                            </div>

                                                <!-- Coupon Box Ends` -->
                                            </div>
                                            <!-- Coupons Box Ends -->
                                            <!-- Coupons Box Starts -->
                                            
                                            <!-- Coupons Box Ends -->
                                        </div>
                                        <!-- Profile Coupons Block Ends -->
                                       
                                    </div>
                                </div>
                            </div>
                            <!-- Profile Right Ends -->
                        </div>
                        <!-- Profile Inner Ends -->
                    </div>
                </div>
                <!-- Profile Content Ends -->
            </div>
        </div>
<style>
.accordion {
    background-color: #fff;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border-bottom: 1px solid #d4d5d9;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}

.accactive, .accordion:hover {
    color:#fc8019;
/*    background-color: #ccc;*/
}

.accordion:after {
    font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
    content: '\e113';
    color: #777;
    font-weight: bold;
    float: right;
    margin-left: 5px;
}

.accactive:after {
    content: "\e114";
}
.read {
    color:#fc8019;
    margin-bottom: 2em;
}

.helppanel {
    border: 1px solid #d4d5d9;
    padding: 0 18px;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
}

.short-content {
    margin: 10px;
    max-height: 5.3em;
}
</style>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("accactive");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
</script>

        <!-- Content Wrapper Ends -->
    @include('user.layouts.partials.footer')     
@endsection

