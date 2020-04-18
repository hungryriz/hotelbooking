<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/home', 'AdminController@index')->name('home');
Route::get('{id}/profile', 'Resource\DisputeUserResource@edit')->name('dispute-user.edit');

Route::resource('users', 'Resource\UserResource');
Route::resource('transporters', 'Resource\TransporterResource');
Route::resource('dispute-user', 'Resource\DisputeUserResource');
Route::resource('categories', 'Resource\CategoryResource');
Route::get('subcategory', 'Resource\CategoryResource@subcategory');
Route::resource('categories.products', 'Resource\ProductResource');
Route::resource('products', 'Resource\ProductResource');
Route::delete('productimage/{id}', 'Resource\ProductResource@imagedestroy')->name('productimage.destroy');
Route::resource('orders', 'Resource\OrderResource');
Route::resource('shops', 'Resource\ShopResource');
Route::resource('zones', 'Resource\ZoneResource');
Route::resource('cuisines', 'Resource\CuisineResource');
Route::resource('demoapp', 'ManageappController');
Route::resource('promocodes', 'Resource\PromocodeResource');
Route::resource('emailtemplate', 'Resource\EmailTemplateResource');
Route::resource('translation', 'Resource\TranslationResource');
Route::get('disputes/{name}', 'Resource\DisputeResource@index');
Route::resource('dispute', 'Resource\DisputeResource');
Route::resource('banner', 'Resource\ShopBannerResource');
Route::resource('notice', 'Resource\NoticeBoardResource');
Route::resource('disputehelp', 'Resource\DisputeHelpResource');
Route::get('/settings', 'AdminController@settings')->name('settings');;
Route::post('/settings', 'AdminController@settings_store')->name('settings.store');;
//Route::get('/accsetting', 'AdminController@account_setting')->name('accsetting');;
Route::post('/setting/add', 'AdminController@AccountSettingStore')->name('accsetting.store');;

Route::get('/send/push', 'AdminController@push')->name('push');
Route::post('/send/push', 'AdminController@send_push')->name('send.push');

Route::get('/chat','Resource\DisputeResource@chatWithUser');

Route::post('/pages', 'AdminController@pages')->name('pages.update');

//pages

Route::get('/privacy', 'AdminController@privacy')->name('privacy');
Route::get('/terms', 'AdminController@terms')->name('terms');
Route::get('/faq', 'AdminController@faq')->name('faq');
Route::get('/about', 'AdminController@about')->name('about');
Route::get('/help', 'AdminController@help')->name('help');
Route::get('/refund', 'AdminController@refund')->name('refund');
Route::get('/queries', 'AdminController@queries')->name('queries');
Route::get('/otherterms', 'AdminController@otherterms')->name('otherterms');
Route::get('/contact', 'AdminController@contact')->name('contact');

Route::get('/leadres', 'AdminController@restuarant_leads')->name('leadres');
Route::get('/newsletter', 'AdminController@newsletter_leads')->name('newsletter');
Route::get('/enquiry_delivery', 'AdminController@enquiry_delivery')->name('enquiry_delivery');


Route::resource('addons', 'Resource\AddonsResource');
Route::get('transporters-shift', 'Resource\TransporterResource@shiftdetails');
