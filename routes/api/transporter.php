<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


//Login
Route::post('/login', 'TransporterAuth\LoginController@login');
Route::post('/verify/otp', 'TransporterAuth\LoginController@UserLogin');

Route::group(['middleware' => ['auth:transporterapi']], function() {
	
	Route::group(['prefix' => 'profile'], function() {
		Route::get('/', 'TransporterResource\ProfileController@index');
		Route::post('/', 'TransporterResource\ProfileController@update');
		
		Route::post('/password', 'TransporterResource\ProfileController@password');
		Route::post('/location', 'TransporterResource\ProfileController@location');
	});
	Route::get('/logout', 'TransporterResource\ProfileController@logout');
	Route::get('/vehicles', 'TransporterResource\ShiftResource@vehicles');

	Route::resource('order', 'TransporterResource\OrderResource');
	Route::get('history', 'TransporterResource\OrderResource@history');
	Route::resource('shift', 'TransporterResource\ShiftResource');
	Route::resource('shift/timing', 'TransporterResource\ShifttimingResource');
	Route::resource('dispute', 'Resource\DisputeResource');
	Route::post('/rating', 'TransporterResource\OrderResource@rate_review');
	Route::get('/notice', 'Resource\NoticeBoardResource@TransporterNotice');
	Route::get('/disputehelp','Resource\DisputeHelpResource@index');
	Route::post('/request/order', 'TransporterResource\OrderResource@providerRequest');
});