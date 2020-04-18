@extends('user.layouts.app')

@section('content')
  <div class="content-wrapper">
            <div class="profile blue-bg">
                <!-- Profile Head Starts -->
                 @include('user.layouts.partials.user_common')
                <!-- Profile Head Ends -->
                <!-- Profile Content Starts -->
                <div class="profile-content">
                    <div class="container-fluid">
                        <!-- Profile Inner Starts -->
                        <div class="profile-inner row">
                            <!-- Profile Left Starts -->
                            @include('user.layouts.partials.sidebar')
                            <!-- Profile Left Ends -->
                            <!-- Profile Right Starts -->
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="profile-right">
                                    <div class="profile-right-head">
                                        <h4>Favourites</h4>
                                    </div>
                                    <div class="favourites-section">
                                    @forelse($available as $item)
                                        <!-- Restaurant List Box Starts -->
                                        <a href="{{url('/restaurant/details')}}?name={{$item->shop->name}}" class="food-item-box col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="food-img bg-img" style="background-image: url({{$item->shop->avatar}});">
                                                <span class="heart"><i class="ion-ios-heart"></i></span>
                                            </div>
                                            <div class="food-details">
                                                <h6 class="food-det-tit">{{$item->shop->name}}</h6>
                                                <p class="food-det-txt">{{$item->shop->categories[0]->name}}</p>
                                                <div class="food-other-details row">
                                                    <div class="col-xs-3 p-r-0">
                                                        <span class="food-rating"><i class="ion-android-star"></i>{{$item->shop->rating}}</span>
                                                    </div>
                                                    <div class="col-xs-3 text-center">
                                                        <span class="food-deliver-time food-list-txt">30Mins</span>
                                                    </div>
                                                    <div class="col-xs-6 text-right">
                                                        <span class="food-quantity-price food-list-txt">$100 for two</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- Restaurant List Box Starts -->
                                        @empty
                                        <p>No Favourite !</p>
                                        @endforelse
                                        <!-- Restaurant List Box Starts -->
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
         @include('user.layouts.partials.footer')
@endsection
@section('styles')
<style>
    .pac-container {
        z-index: 100000000 !important;
    }
</style>
@endsection
