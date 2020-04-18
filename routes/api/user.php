<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', 'Auth\RegisterController@apiregister');
Route::post('/social/login','SocialLoginController@loginWithSocial');
Route::post('/otp', 'Auth\RegisterController@OTP');
Route::post('/forgot/password','Auth\ForgotPasswordController@forgot_password');
Route::post('/reset/password', 'Auth\ResetPasswordController@reset_password');

Route::get('/cuisines', 'Resource\CuisineResource@index');
Route::get('/cuisines/{cuisine}', 'Resource\CuisineResource@show');
Route::get('/shops', 'Resource\ShopResource@index');
Route::get('/shops/{shop}', 'Resource\ShopResource@show');
// for demo 
Route::post('/demoapp', 'ManageappController@details');
Route::get('/initsetup', 'ManageappController@setting');

Route::get('banner', 'AdminController@manageBanner');
// Categories List
Route::get('/categories', 'Resource\CategoryResource@index');
Route::resource('products', 'Resource\ProductResource');
// Product List
Route::get('/categories/{category}', 'Resource\CategoryResource@show');
// Search
Route::get('search', 'UserResource\SearchResource@index');

Route::group(['middleware' => ['auth:api']], function() {
	
	Route::group(['prefix' => 'profile'], function() {
		Route::get('/', 'UserResource\ProfileController@index');
		Route::post('/', 'UserResource\ProfileController@update');
		
		Route::post('/password', 'UserResource\ProfileController@password');
	});
	Route::get('/logout', 'UserResource\ProfileController@logout');
	Route::resource('address', 'UserResource\AddressResource');
	Route::resource('cart', 'UserResource\CartResource');
	Route::resource('order', 'UserResource\OrderResource');
	Route::get('/ongoing/order', 'UserResource\OrderResource@orderprogress');
	Route::post('/reorder', 'UserResource\OrderResource@reorder');
	Route::resource('dispute', 'Resource\DisputeResource');
	Route::post('/rating', 'UserResource\OrderResource@rate_review');
	Route::resource('favorite', 'Resource\FavoriteResource');
	// wallet
	Route::get('wallet', 'UserResource\WalletResource@index');
	Route::get('wallet/promocode', 'UserResource\WalletResource@promocode');
	Route::post('wallet/promocode', 'UserResource\WalletResource@store');
	Route::get('/notification', 'UserResource\ProfileController@notifications');
	Route::get('/disputehelp','Resource\DisputeHelpResource@index');
	Route::get('/clear/cart','UserResource\CartResource@clearCart');
	Route::resource('card', 'Resource\CardResource');
	Route::post('/payment' , 	'PaymentController@payment');
	Route::post('/add/money' , 	'PaymentController@add_money');
});