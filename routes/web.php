<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
//abort(404, 'The resource you are looking for could not be found');
Route::get('/', 'WelcomeController@home');


Route::get('privacy', function () {
    $page = 'privacy';
    $title = 'Privacy Policy';
    return view('static', compact('page', 'title'));
});

Route::get('aboutus', function () {
    $page = 'about';
    $title = 'About Us';
    return view('static', compact('page', 'title'));
});

Route::get('terms', function () {
    $page = 'terms';
    $title = 'Terms And Condition';
    return view('static', compact('page', 'title'));
});


// Route::get('faq', function () {
//     $page = 'faq';
//     $title = 'FAQ';
//     return view('static', compact('page', 'title'));
// });


Route::get('contact', function () {
    $page = 'contact';
    $title = 'Contact Us';
    return view('static', compact('page', 'title'));
});

Route::get('help', function () {
    $page = 'help';
    $title = 'Help';
    return view('static', compact('page', 'title'));
});

Route::get('refund', function () {
    $page = 'refund';
    $title = 'Refund';
    return view('static', compact('page', 'title'));
});

Route::get('otherterms', function () {
    $page = 'otherterms';
    $title = 'Other Terms';
    return view('static', compact('page', 'title'));
});


/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/search','WelcomeController@search');
Route::get('/enquiry-delivery','UserController@delivery');
Route::post('/enquiry-delivery','UserController@delivery_store');


Route::get('auth/facebook', 'SocialLoginController@redirectToFaceBook');
Route::get('auth/facebook/callback', 'SocialLoginController@handleFacebookCallback');
Route::get('auth/google', 'SocialLoginController@redirectToGoogle');
Route::get('auth/google/callback', 'SocialLoginController@handleGoogleCallback');

Route::post('/social/login','SocialLoginController@loginWithSocial');

Route::get('/pushnotification', function () {
    $message = PushNotification::Message("Push Remote Rich Notifications",
        array(
            'badge' => 1,
            'sound' => 'example.aif',
            'content-available' => 1,
            'media-url' => 'https://i.imgur.com/t4WGJQx.jpg',
            'actionLocKey' => 'Action button title!',
            'locKey' => 'localized key',
            'locArgs' => array(
                'localized args',
                'localized args',
            ),
            'launchImage' => 'image.jpg',
            
            'custom' => array("custom data"=>array('we'=>1), "mutable-content" => 1,
                 "attachment-url"=> "https://raw.githubusercontent.com/Sweefties/iOS10-NewAPI-UserNotifications-Example/master/source/iOS10-NewAPI-UserNotifications-Example.jpg",
                "media-url" => "https://i.imgur.com/t4WGJQx.jpg" )
        )
    );   


    if(Request::has('andriod')){
    $test1 = \PushNotification::app('AndroidUser')
                ->to(Request::get('andriod'))
                ->send($message);
                dd($test1);
    }
    if(Request::has('iosuser')){
     $test = \PushNotification::app('IOSUser')
                ->to(Request::get('iosuser'))
                ->send($message);
                
                dd($test);
    }
    if(Request::has('iosprovider')){
    $test = \PushNotification::app('IOSProvider')
                ->to(Request::get('iosprovider'))
                ->send($message);
                dd($test);
    }
 });

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminAuth\LoginController@showLoginForm');
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout');

    Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'AdminAuth\RegisterController@register');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'shop'], function () {
    Route::get('/', 'ShopAuth\LoginController@showLoginForm');
    Route::get('/login', 'ShopAuth\LoginController@showLoginForm');
    Route::post('/login', 'ShopAuth\LoginController@login');
    Route::post('/logout', 'ShopAuth\LoginController@logout');

    Route::get('/register', 'ShopAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'ShopAuth\RegisterController@register');

    Route::post('/password/email', 'ShopAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'ShopAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'ShopAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'ShopAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'transporter'], function () {
    Route::get('/login', 'TransporterAuth\LoginController@showLoginForm');
    Route::post('/login', 'TransporterAuth\LoginController@login');
    Route::post('/userlogin', 'TransporterAuth\LoginController@UserLogin');
    Route::get('/otplogin', 'TransporterAuth\LoginController@OtpLogin');
    Route::post('/logout', 'TransporterAuth\LoginController@logout');

    Route::post('/otp', 'TransporterAuth\RegisterController@OTP');
    Route::post('/verifyotp', 'TransporterAuth\RegisterController@CheckOtp');

    Route::get('/register', 'TransporterAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'TransporterAuth\RegisterController@register');

    Route::post('/password/email', 'TransporterAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'TransporterAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'TransporterAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'TransporterAuth\ResetPasswordController@showResetForm');

    Route::get('/home', 'TransporterController@index');
});

    Auth::routes();
    Route::get('login',function(){
        return redirect('/');
    });
    Route::post('login', 'Auth\LoginController@login')->name('login');
    Route::get('register',function(){
        return redirect('/');
    });
    Route::get('/home', 'UserController@showhome');
    Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.request');
    Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/user/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');

    Route::post('register', 'Auth\RegisterController@register')->name('register');
    Route::post('shopreg', 'ShopController@register')->name('register');
    Route::post('newsletter', 'WelcomeController@newsletter')->name('newsletter');

    Route::post('/otp', 'Auth\RegisterController@OTP');
    Route::get('/dashboard', 'UserResource\OrderResource@orderprogress');
    Route::get('/profile', 'UserResource\ProfileController@index');
    Route::post('/profile', 'UserResource\ProfileController@update');
    Route::get('/changepassword', 'UserResource\ProfileController@changepassword');
    Route::post('/setpassword', 'UserResource\ProfileController@password');
    Route::resource('orders', 'UserResource\OrderResource');
    Route::resource('useraddress', 'UserResource\AddressResource');
    Route::get('/restaurants', 'UserResource\SearchResource@index');
    Route::get('/restaurant/details', 'UserResource\SearchResource@show');
    Route::post('mycart', 'UserResource\CartResource@addToCart');
    Route::post('addcart', 'UserResource\CartResource@store');
    Route::get('/clear/cart','UserResource\CartResource@clearCart');
    Route::get('/track/order/{id}','UserResource\SearchResource@ordertrack');
    Route::get('/product/details/{productid}/{cartId}/{shopname}/{productname}','UserResource\SearchResource@productDetails');
    // card
    Route::resource('card', 'Resource\CardResource');
    Route::get('payment', 'UserController@payment');
    Route::post('payment/confirm', 'PaymentController@payment');
    Route::any('cart/payment', 'UserController@order_payment');
    Route::get('wallet', 'UserController@wallet');
    Route::post('wallet', 'PaymentController@add_money');
    Route::post('/rating', 'UserResource\OrderResource@rate_review');
    Route::get('user/chat', 'UserResource\OrderResource@chatWithUser');
    Route::get('addons/{id}', 'Resource\ProductResource@show');
    Route::get('checkRipplePayment','PaymentController@checkRipplePayment');
    Route::get('checkEtherPayment','PaymentController@checkEtherPayment');
    // swiggy design
    Route::get('payments', 'UserController@payment');
    Route::resource('favourite', 'Resource\FavoriteResource');
    Route::get('offers', 'UserResource\SearchResource@offers');
    Route::get('legal', 'UserResource\SearchResource@legal');
    Route::get('faq', 'UserResource\SearchResource@faq');
    Route::get('queries', 'UserResource\SearchResource@queries');
    Route::post('wallet/promocode', 'UserResource\WalletResource@store');
    Route::post('/reorder', 'UserResource\OrderResource@reorder');
    
    //Route::get('/token','BraintreeTokenController@token');
    //Route::get('/payment','BraintreeTokenController@payment');
   // Route::post('/payment','BraintreeTokenController@do_payment');
  /*  Route::get('faq','WelcomeController@faq');
    Route::get('aboutus','WelcomeController@aboutus');
    Route::get('termcondition','WelcomeController@termcondition');*/
