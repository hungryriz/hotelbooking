 <footer class="footer">
            <div class="container">
                <!-- Foot Top Starts -->
                <div class="foot-top row">
                    <!-- Foot Block Starts -->
                    <div class="foot-block col-md-3 col-sm-12 col-xs-12">
                        <h5 class="foot-tit">Company</h5>
                        <div>
                            <a href="{{url('/aboutus')}}" class="foot-item">About</a>
                            <a href="{{url('/')}}" class="foot-item">Team</a>
                            <a href="{{url('/')}}" class="foot-item">Carriers</a>
                            <a href="{{url('/')}}" class="foot-item">Foodie Blog</a>
                        </div>
                    </div>
                    <!-- Foot Block Ends -->
                    <!-- Foot Block Starts -->
                    <div class="foot-block col-md-3 col-sm-12 col-xs-12">
                        <h5 class="foot-tit">Contact</h5>
                        <div>
                            <a href="{{url('/')}}" class="foot-item">Help &amp; Support</a>
                            <a href="{{url('enquiry-delivery')}}" class="foot-item">Partner with us</a>
                        </div>
                    </div>
                    <!-- Foot Block Ends -->
                    <!-- Foot Block Starts -->
                    <div class="foot-block col-md-3 col-sm-12 col-xs-12">
                        <h5 class="foot-tit">LEGAL</h5>
                        <div>
                            <a href="{{url('terms')}}" class="foot-item">Terms &amp; Conditions</a>
                            <a href="{{url('/')}}" class="foot-item">Refund &amp; Cancellation</a>
                            <a href="{{url('/privacy')}}" class="foot-item">Privacy Policy</a>
                            <a href="{{url('/')}}" class="foot-item">Offer Terms</a>
                        </div>
                    </div>
                    <!-- Foot Block Ends -->
                    <!-- Foot Block Starts -->
                    <div class="foot-block col-md-3 col-sm-12 col-xs-12">
                        <div class="foot-download-img-sec">
                            <a href="{{Setting::get('IOS_APP_LINK')}}" class="foot-download-img"><img src="{{ asset('assets/user/img/ios-app.png')}}"></a>
                        </div>
                        <div class="foot-download-img">
                            <a href="{{Setting::get('ANDROID_APP_LINK')}}" class="foot-download-img"><img src="{{ asset('assets/user/img/android-app-trans.png')}}"></a>
                        </div>
                    </div>
                    <!-- Foot Block Ends -->
                </div>
                <!-- Foot Top Ends -->
                <!-- Foot Bottom Starts -->
                <div class="foot-btm row">
                    <div class="col-md-4">
                        <div class="foot-logo"><img src="{{ Setting::get('site_logo',asset('assets/user/img/logo.png'))}}"></div>
                    </div>
                    <div class="col-md-4 text-center">
                        <p class="copy-txt">{{Setting::get('site_copyright')}}</p>
                    </div>
                    <div class="foot-social col-md-4 text-right">
                        <a href="#" class="foot-social-item"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="foot-social-item"><i class="fa fa-pinterest-p"></i></a>
                        <a href="#" class="foot-social-item"><i class="fa fa-instagram"></i></a>
                        <a href="#" class="foot-social-item"><i class="fa fa-twitter"></i></a>
                    </div>
                </div>
                <!-- Foot Bottom Ends -->
            </div>
        </footer>