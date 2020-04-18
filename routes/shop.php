<?php

/*
|--------------------------------------------------------------------------
| Shop Routes
|--------------------------------------------------------------------------
*/

Route::get('/home', 'ShopController@index')->name('home');
//Route::resource('shops', 'Resource\ShopResource');

Route::resource('transporters', 'Resource\TransporterResource');
Route::resource('categories', 'ShopResource\CategoryResource');
Route::get('subcategory', 'ShopResource\CategoryResource@subcategory');
Route::resource('products', 'ShopResource\ProductResource');
Route::delete('productimage/{id}', 'Resource\ProductResource@imagedestroy')->name('productimage.destroy');
Route::resource('/profile', 'ShopResource\ProfileController');
Route::resource('/orders', 'ShopResource\OrderResource');
Route::get('/incomingord', 'ShopResource\OrderResource@totalIncoming');
Route::resource('dispute', 'Resource\DisputeResource');
Route::resource('/banner', 'ShopResource\ShopBannerResource');
Route::resource('addons', 'ShopResource\AddonsResource');