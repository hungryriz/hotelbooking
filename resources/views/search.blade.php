@extends('user.layouts.app')

@section('content')

 <!-- Content Wrapper Starts -->
        <div class="content-wrapper">
            <!-- Search Section Starts -->
            <div class="search-section">
                <div class="container">
                    <!-- Search Head Starts -->
                    <div class="search-head row">
                        <!-- Search Head Left Starts -->
                        <div class="search-head-left col-xs-10">
                            <form class="search-form">
                                <div class="input-group">
                                    <span class="input-group-addon"><button class="search-icon"><i class="ion-ios-search-strong"></i></button></span>
                                    <input type="text" name="q" value="{{Request::get('q')}}" class="form-control" placeholder="Search">
                                </div>
                            </form>
                        </div>
                        <!-- Search Head Left Ends -->
                        <!-- Search Head Right  Starts -->
                        <div class="search-head-right col-xs-2">
                            <a href="{{url(@Session::get('search_return_url'))}}" class="search-esc"><i class="ion-android-close"></i><br> <span></span> ESC</a>
                        </div>
                        <!-- Search Head Right Starts -->
                    </div>
                    <!-- Search Head Starts -->
                    @if(count($Shops)>0)
                    <!-- Search Content Starts -->
                    <div class="search-content">
                        <div>
                            <p class="related-txt">Related to <span>"{{Request::get('q')}}"</span></p>
                        </div>
                        <!-- Restaurant List Starts -->
                        <div class="restaurant-list row">
                        	@forelse($Shops as $Shop)

                            <!-- Restaurant List Box Starts -->
                                    @if($Shop->shopstatus=='OPEN')
                                    <a href="{{url('/restaurant/details')}}?name={{$Shop->name}}" class="food-item-box col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                    @else
                                    <a href="#" class="food-item-box col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                    @endif
                                <div class="food-img bg-img" style="background-image: url({{$Shop->avatar}});"></div>
                                <div class="food-details">
                                    <h6 class="food-det-tit">{{$Shop->name}}</h6>
                                    <p class="food-det-txt">{{$Shop->description}}</p>
                                    <div class="food-other-details row">
                                        <div class="col-xs-3 p-r-0">
                                            <span class="food-rating"><i class="ion-android-star"></i> {{$Shop->rating}}</span>
                                        </div>
                                        <div class="col-xs-6 text-center">
                                            <span class="food-deliver-time food-list-txt">{{$Shop->estimated_delivery_time}} Mins</span>
                                        </div>
                                        <!-- <div class="col-xs-6 text-right">
                                            <span class="food-quantity-price food-list-txt">$100 for two</span>
                                        </div> -->
                                    </div>
                                </div>
                                       @if($Shop->shopstatus=='CLOSED')
                                        <div class="red centered"><div class="text"> Closed</div><div class="opentext"> ({{$Shop->shopopenstatus}})</div></div>
                                        @endif
                            </a>
                          
                            <!-- Restaurant List Box Starts -->
                            @empty
                            @endforelse
                            
                        </div>
                        <!-- Restaurant List Ends -->
                    </div>
                    @else
                    	@if(Request::has('q'))
	                    <div class="search-content">
	                    No Data Found!
	                    </div>
	                    @endif
                    @endif
                    <!-- Search Content Ends -->
                </div>
            </div>
            <!-- Search Section Ends -->
        </div>
        <!-- Content Wrapper Ends -->
<script>
document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        window.location.href = "{{url(@Session::get('search_return_url'))}}";
    }
};

</script>
<style type="text/css">
    .red{
        position: absolute;
        /*//text-indent: -9999px;*/
        top: -5px;
        left: -5px;
        background-color: rgba(0,0,0,0.5);
        width: 100%;
        height: 100%;
        z-index: 3;
        opacity: 0.5;
        color: black;
        background-color: red 1px solid;
    }
    .text{
        position: absolute;
        top: 45%;
        left: 50%;
        font-size: 50px;
        color: white;
        transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
    }
    .opentext{
        position: absolute;
        top: 55%;
        line-height: 35px;
        left: 50%;
        font-size: 14px;
        color: white;
        transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
    }
    </style>
@endsection