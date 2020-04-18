@extends('user.layouts.app')

@section('content')
 <!-- Content Wrapper Starts -->
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
                                        <h4>Offers</h4>
                                    </div>
                                    <div class="profile-coupons">
                                        <!-- Profile Coupons Block Starts -->
                                        <div class="profile-coupons-block row">
                                            <!-- Coupons Box Starts -->
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            
                                                <!-- Coupon Box Starts -->
                                                @forelse($Promocodes as $promocode)
                                                <div class="coupon-box">
                                                    <p class="coupon-name">{{$promocode->promo_code}}</p>
                                                    <!-- <p class="coupon-txt">Pay via Visa Signature Cards &amp; get additional 10x Reward Points on every $150 spent. Use Code KIU10X</p> -->
                                                    <div class="coupon-details">
                                                        <div class="coupon-det-box row m-0">
                                                            <div class="col-xs-6 p-l-0">
                                                                <p class="coupon-det-txt coupon-det-txt1">Min cart amount</p>
                                                            </div>
                                                            <div class="col-xs-6 p-l-0">
                                                                <p class="coupon-det-txt coupon-det-txt2">{{currencydecimal($promocode->discount)}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="coupon-det-box row m-0">
                                                            <div class="col-xs-6 p-l-0">
                                                                <p class="coupon-det-txt coupon-det-txt1">Valid till</p>
                                                            </div>
                                                            <div class="col-xs-6 p-l-0">
                                                                <p class="coupon-det-txt coupon-det-txt2">Expires in {{date('d-m-Y',strtotime($promocode->expiration))}}</p>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="coupon-det-box row m-0">
                                                            <div class="col-xs-6 p-l-0">
                                                                <p class="coupon-det-txt coupon-det-txt1">Payment method</p>
                                                            </div>
                                                            <div class="col-xs-6 p-l-0">
                                                                <p class="coupon-det-txt coupon-det-txt2">Wallet</p>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                   <!--  <a href="#" class="apply-coupon">Apply Coupon</a> -->
                                                </div> 
                                                @empty
                                                <div>No offers </div>
                                                @endforelse
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
        <!-- Content Wrapper Ends -->
    @include('user.layouts.partials.footer')     
@endsection

