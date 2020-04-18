<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::post('/shoplogin', 'ShopAuth\LoginController@shopApiLogin');
Route::post('/register', 'ShopAuth\RegisterController@apiregister');
Route::post('/forgot/password','ShopAuth\ForgotPasswordController@forgot_password');
//Route::post('/password/email','ShopAuth\ForgotPasswordController@forgot_password');
Route::post('/verifyotp','ShopAuth\ForgotPasswordController@CHECK_OTP');
Route::post('/reset/password', 'ShopAuth\ResetPasswordController@reset_password');
Route::resource('cuisines', 'Resource\CuisineResource');
Route::group(['middleware' => ['auth:shopapi']], function() {
	Route::group(['prefix' => 'profile'], function() {
		Route::get('/', 'ShopResource\ProfileController@index');
		Route::post('/{id}', 'ShopResource\ProfileController@update');
	});
	Route::post('/password', 'ShopResource\ProfileController@password');
	Route::post('/location', 'ShopResource\ProfileController@location');
	Route::get('/logout', 'ShopResource\ProfileController@logout');
	Route::get('revenue', 'ShopController@index');
	Route::resource('order', 'ShopResource\OrderResource');
	Route::get('transporterlist','ShopResource\OrderResource@transporterlist');
	Route::get('history', 'ShopResource\OrderResource@history');
	Route::resource('addons', 'ShopResource\AddonsResource');
	Route::resource('categories', 'ShopResource\CategoryResource');
	Route::resource('products', 'ShopResource\ProductResource');
	Route::any('remove/{id}', 'Resource\ShopResource@destroy');
});
