    <!DOCTYPE html>
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Gatoo</title>
    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">
    <!-- GOOGLE WEB FONT -->
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic,300,300italic' rel='stylesheet' type='text/css'> 
    <!-- BASE CSS -->
    <link href="css/base.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!--[if lte IE 8]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please upgrade your browser.</p>
    <![endif]-->
    <div id="preloader">
        <div class="sk-spinner sk-spinner-wave" id="status">
            <div class="sk-rect1"></div>
            <div class="sk-rect2"></div>
            <div class="sk-rect3"></div>
            <div class="sk-rect4"></div>
            <div class="sk-rect5"></div>
        </div>
    </div>
    <!-- End Preload -->
    <!-- Header ================================================== -->
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col--md-4 col-sm-4 col-xs-4">
                    <a href="#" id="logo">
                <img src="img/logo.png" height="50" alt="" data-retina="true" class="">
                </a>
                </div>
                <nav class="col--md-8 col-sm-8 col-xs-8">
                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                    <div class="main-menu">
                        <div id="header_menu">
                            <img src="img/logo.png" width="190" height="23" alt="" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_close"></i></a>
                        <ul>
                            <li class="submenu">
                                <a href="{{url('/')}}">Home</a>
                            </li>
                            <li class="submenu">
                                <a href="{{url('restaurants')}}">Grocery Shop</a>
                            </li>
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Faq</a></li>
                            <li><a href="#0" data-toggle="modal" data-target="#login_2">Login</a></li>
                            <li><a href="#0" data-toggle="modal" data-target="#register">Register</a></li>
                        </ul>
                    </div>
                    <!-- End main-menu -->
                </nav>
            </div>
            <!-- End row -->
        </div>
        <!-- End container -->
    </header>
    <!-- End Header =============================================== -->
    <!-- SubHeader =============================================== -->
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
            <!-- End sub_content -->
        </div>
        <!-- End subheader -->
        <div id="count" class="hidden-xs">
            <ul>
                <li><span class="number">2650</span> Shops</li>
                <li><span class="number">5350</span> Delivered</li>
                <li><span class="number">12350</span> Registered Users</li>
            </ul>
        </div>
    </section>
    <!-- End section -->
    <!-- End SubHeader ============================================ -->
    <!-- Content ================================================== -->
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
    <!-- End container -->
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
    <!-- End white_bg -->
    <div class="high_light">
        <div class="container">
            <h3>Choose from over 2,000 Grocery Shop</h3>
            <p>Ridiculus sociosqu cursus neque cursus curae ante scelerisque vehicula.</p>
            <a href="#">View all Grocery Shop</a>
        </div>
        <!-- End container -->
    </div>
    <!-- End hight_light -->
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
    <!-- End container -->
    <!-- Footer ================================================== -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-3">
                    <h3>Secure payments with</h3>
                    <p>
                        <img src="img/cards.png" alt="" class="img-responsive">
                    </p>
                </div>
                <div class="col-md-3 col-sm-3">
                    <h3>About</h3>
                    <ul>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Faq</a></li>
                        <li><a href="#">Contacts</a></li>
                        <li><a href="#0" data-toggle="modal" data-target="#login_2">Login</a></li>
                        <li><a href="#0" data-toggle="modal" data-target="#register">Register</a></li>
                        <li><a href="#0">Terms and conditions</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-3" id="newsletter">
                    <h3>Newsletter</h3>
                    <p>
                        Join our newsletter to keep be informed about offers and news.
                    </p>
                    <div id="message-newsletter_2">
                    </div>
                    <form method="post" action="assets/newsletter.php" name="newsletter_2" id="newsletter_2">
                        <div class="form-group">
                            <input name="email_newsletter_2" id="email_newsletter_2" type="email" value="" placeholder="Your mail" class="form-control">
                        </div>
                        <input type="submit" value="Subscribe" class="btn_1" id="submit-newsletter_2">
                    </form>
                </div>
                <div class="col-md-2 col-sm-3">
                    <h3>Settings</h3>
                                     <div class="styled-select">
                        <select class="form-control" name="lang" id="lang">
                            <option value="English" selected>English</option>
                            <option value="French">French</option>
                            <option value="Spanish">Spanish</option>
                            <option value="Russian">Russian</option>
                        </select>
                    </div>
                    <div class="styled-select">
                        <select class="form-control" name="currency" id="currency">
                            <option value="USD" selected>USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                            <option value="RUB">RUB</option>
                        </select>
                    </div> 

            </div>
            <!-- End row -->
            <div class="row">
                <div class="col-md-12">
                    <div id="social_footer">
                        <ul>
                            <li><a href="#0"><i class="icon-facebook"></i></a></li>
                            <li><a href="#0"><i class="icon-twitter"></i></a></li>
                            <li><a href="#0"><i class="icon-google"></i></a></li>
                            <li><a href="#0"><i class="icon-instagram"></i></a></li>
                            <li><a href="#0"><i class="icon-pinterest"></i></a></li>
                            <li><a href="#0"><i class="icon-vimeo"></i></a></li>
                            <li><a href="#0"><i class="icon-youtube-play"></i></a></li>
                        </ul>
                        <p>
                            © Gatoo 2017
                        </p>
                    </div>
                </div>
            </div>
            <!-- End row -->
        </div>
        <!-- End container -->
    </footer>
    <!-- End Footer =============================================== -->
    <div class="layer"></div>
    <!-- Mobile menu overlay mask -->
    
    @include('user.layouts.modals.auth')

    <!-- COMMON SCRIPTS -->
    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="js/common_scripts_min.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/validate.js"></script>

    <!-- PAGE SCRIPTS -->
    @yield('scripts')
</body>
</html>