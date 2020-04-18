@extends('user.layouts.app')

@section('content')
<section class="parallax-window" id="home" data-parallax="scroll" data-image-src="img/sub_header_home.jpg">
    <div id="subheader">
        <div id="sub_content">
            <h1>Order Takeaway or Delivery Your Items</h1>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
            <form method="post" action="#">
                <div id="custom-search-input">
                    <div class="input-group ">
                        <input type="text" class=" search-query" placeholder="Your Address or postal code">
                        <span class="input-group-btn">
                    <input type="submit" class="btn_search" value="submit">
                    </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="count" class="hidden-xs">
        <ul>
            <li><span class="number">2650</span> Shops</li>
            <li><span class="number">5350</span> Delivered</li>
            <li><span class="number">12350</span> Registered Users</li>
        </ul>
    </div>
</section>
<div class="container margin_60">
    <div class="main_title">
        <h2 class="nomargin_top" style="padding-top:0">How it works</h2>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </p>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="box_home" id="one">
                <span>1</span>
                <h3>Search by address</h3>
                <p>
                    Find all grocery shops available in your zone.
                </p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box_home" id="two">
                <span>2</span>
                <h3>Choose a Grocery Shop</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                </p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box_home" id="three">
                <span>3</span>
                <h3>Pay by card or cash</h3>
                <p>
                    It's quick, easy and totally secure.
                </p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box_home" id="four">
                <span>4</span>
                <h3>Delivery or takeaway</h3>
                <p>
                    You are lazy? Are you backing home?
                </p>
            </div>
        </div>
    </div>
    <!-- End row -->
    <div id="delivery_time" class="hidden-xs">
        <strong><span>2</span><span>5</span></strong>
        <h4>The minutes that usually takes to deliver!</h4>
    </div>
</div>
<div class="white_bg">
    <div class="container margin_60">
        <div class="main_title">
            <h2 class="nomargin_top">Choose from Most Popular</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            </p>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="strip_list">
                    <div class="ribbon_1">Popular</div>
                    <div class="desc">
                        <div class="thumb_strip">
                            <img src="img/shop-logo/thumb-grocery-1.png" alt="">
                        </div>
                        <div class="rating">
                            <i class="icon_star voted"></i>
                            <i class="icon_star voted"></i>
                            <i class="icon_star voted"></i>
                            <i class="icon_star voted"></i>
                            <i class="icon_star"></i>
                        </div>
                        <h3>Grocerscarte</h3>
                        <div class="type">
                            Grocery / Fruits
                        </div>
                        <div class="location">
                            135 Newtownards Road, Belfast, BT4. <span class="opening">Opens at <span>7:00AM</span> to <span> 9:00PM</span></span>
                        </div>
                        <ul>
                            <li>Delivery<i class="icon_check_alt2 ok"></i></li>
                        </ul>
                    </div>
                    <!-- End desc-->
                </a>
                <!-- End strip_list-->
                <a href="#" class="strip_list">
                    <div class="ribbon_1">Popular</div>
                    <div class="desc">
                        <div class="thumb_strip">
                            <img src="img/shop-logo/thumb-grocery-2.jpg" alt="">
                        </div>
                        <div class="rating">
                            <i class="icon_star voted"></i>
                            <i class="icon_star voted"></i>
                            <i class="icon_star voted"></i>
                            <i class="icon_star voted"></i>
                            <i class="icon_star"></i>
                        </div>
                        <h3>Fresh Market</h3>
                        <div class="type">
                            Grocery / Fruits
                        </div>
                        <div class="location">
                            135 Newtownards Road, Belfast, BT4. <span class="opening">Opens at <span>7:00AM</span> to <span> 9:00PM</span></span>
                        </div>
                        <ul>
                            <li>Delivery<i class="icon_check_alt2 ok"></i></li>
                        </ul>
                    </div>
                    <!-- End desc-->
                </a>
                <!-- End strip_list-->
                <a href="#" class="strip_list">
                    <div class="ribbon_1">Popular</div>
                    <div class="desc">
                        <div class="thumb_strip">
                            <img src="img/shop-logo/thumb-grocery-3.jpg" alt="">
                        </div>
                        <div class="rating">
                            <i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
                        </div>
                        <h3>Pantry</h3>
                        <div class="type">
                            Grocery / Fruits
                        </div>
                        <div class="location">
                            135 Newtownards Road, Belfast, BT4. <span class="opening">Opens at <span>7:00AM</span> to <span> 9:00PM</span></span>
                        </div>
                        <ul>
                            <li>Delivery<i class="icon_check_alt2 ok"></i></li>
                        </ul>
                    </div>
                    <!-- End desc-->
                </a>
                <!-- End strip_list-->
            </div>
            <!-- End col-md-6-->
            <div class="col-md-6">
                <a href="#" class="strip_list">
                    <div class="ribbon_1">Popular</div>
                    <div class="desc">
                        <div class="thumb_strip">
                            <img src="img/shop-logo/thumb-grocery-4.jpg" alt="">
                        </div>
                        <div class="rating">
                            <i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
                        </div>
                        <h3>Fresh &amp; Easy</h3>
                        <div class="type">
                            Grocery / Fruits
                        </div>
                        <div class="location">
                            135 Newtownards Road, Belfast, BT4. <span class="opening">Opens at <span>7:00AM</span> to <span> 9:00PM</span></span>
                        </div>
                        <ul>
                            <li>Delivery<i class="icon_close_alt2 no"></i></li>
                        </ul>
                    </div>
                    <!-- End desc-->
                </a>
                <!-- End strip_list-->
                <a href="#" class="strip_list">
                    <div class="ribbon_1">Popular</div>
                    <div class="desc">
                        <div class="thumb_strip">
                            <img src="img/shop-logo/thumb-grocery-5.jpg" alt="">
                        </div>
                        <div class="rating">
                            <i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
                        </div>
                        <h3>Get Basket</h3>
                        <div class="type">
                            Grocery / Fruits / Vegetables
                        </div>
                        <div class="location">
                            135 Newtownards Road, Belfast, BT4. <span class="opening">Opens at <span>7:00AM</span> to <span> 9:00PM</span></span>
                        </div>
                        <ul>
                            <li>Delivery<i class="icon_check_alt2 ok"></i></li>
                        </ul>
                    </div>
                    <!-- End desc-->
                </a>
                <!-- End strip_list-->
                <a href="#" class="strip_list">
                    <div class="ribbon_1">Popular</div>
                    <div class="desc">
                        <div class="thumb_strip">
                            <img src="img/shop-logo/thumb-grocery-6.jpg" alt="">
                        </div>
                        <div class="rating">
                            <i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
                        </div>
                        <h3>Grocery Express</h3>
                        <div class="type">
                            Grocery / Fruits
                        </div>
                        <div class="location">
                            135 Newtownards Road, Belfast, BT4. <span class="opening">Opens at <span>7:00AM</span> to <span> 9:00PM</span></span>
                        </div>
                        <ul>
                            <li>Delivery<i class="icon_check_alt2 ok"></i></li>
                        </ul>
                    </div>
                    <!-- End desc-->
                </a>
                <!-- End strip_list-->
            </div>
        </div>
        <!-- End row -->
    </div>
    <!-- End container -->
</div>
<div class="high_light">
    <div class="container">
        <h3>Choose from over 2,000 Grocery Shop</h3>
        <p>Ridiculus sociosqu cursus neque cursus curae ante scelerisque vehicula.</p>
        <a href="#">View all Grocery Shop</a>
    </div>
    <!-- End container -->
</div>
<div class="container margin_60">
    <div class="main_title margin_mobile">
        <h2 class="nomargin_top">Work with Us</h2>
        <p>
            Cum doctus civibus efficiantur in imperdiet deterruisset.
        </p>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <a class="box_work" href="#">
            <img src="img/submit_grocery.jpg" width="848" height="480" alt="" class="img-responsive">
            <h3>Submit your Shop Details<span>Start to earn customers</span></h3>
            <p>Lorem ipsum dolor sit amet, ut virtute fabellas vix, no pri falli eloquentiam adversarium. Ea legere labore eam. Et eum sumo ocurreret, eos ei saepe oratio omittantur, legere eligendi partiendo pro te.</p>
            <div class="btn_1">Read more</div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="box_work" href="#">
            <img src="img/delivery.jpg" width="848" height="480" alt="" class="img-responsive">
            <h3>We are looking for a Delivery Boy<span>Start to earn money</span></h3>
            <p>Lorem ipsum dolor sit amet, ut virtute fabellas vix, no pri falli eloquentiam adversarium. Ea legere labore eam. Et eum sumo ocurreret, eos ei saepe oratio omittantur, legere eligendi partiendo pro te.</p>
            <div class="btn_1">Read more</div>
            </a>
        </div>
    </div>
    <!-- End row -->
</div>
@endsection