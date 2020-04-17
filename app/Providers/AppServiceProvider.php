<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Setting;
use Config;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        if(Schema::hasTable('settings')){
            Config::set([
                'services' => [
                    'google' => 
                        [
                        'client_id' => Setting::get('GOOGLE_CLIENT_ID'),
                        'client_secret' => Setting::get('GOOGLE_CLIENT_SECRET'),
                        'redirect' => Setting::get('GOOGLE_REDIRECT'),
                        ],
                    'facebook' => 
                        [
                        'client_id' => Setting::get('FB_CLIENT_ID'),
                        'client_secret' => Setting::get('FB_CLIENT_SECRET'),
                        'redirect' => Setting::get('FB_REDIRECT'),
                        ]
                    ]
                    ]);
            Config::set([
                'push-notification' => [
                        'IOSUser' => [
                            'environment' => Setting::get('IOS_USER_ENV'),
                            'certificate' => app_path().'/apns/user/foodieexpressdev.pem',
                            'passPhrase'  => env('IOS_PUSH_PASS', 'appoets123$'),
                            'service'     =>'apns'
                        ],
                        'IOSProvider' => [
                            'environment' => Setting::get('IOS_PROVIDER_ENV'),
                            'certificate' => app_path().'/apns/provider/Certificates_APNS_DEV.pem',
                            'passPhrase'  => env('IOS_PROVIDER_PUSH_PASS', 'appoets123$'),
                            'service'     => 'apns'
                        ],
                        'AndroidUser' => [
                            'environment' => Setting::get('ANDROID_ENV'),
                            'apiKey' => Setting::get('ANDROID_PUSH_KEY'),
                            'service' => 'gcm'
                        ]                     
                ]      
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Hesto\MultiAuth\MultiAuthServiceProvider');
        }
    }
}
