<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();
        DB::table('settings')->insert([
            [
                'key' => 'site_title',
                'value' => 'Foodie'
            ],
            [
                'key' => 'site_logo',
                'value' => asset('logo-black.png'),
            ],
            [
                'key' => 'site_favicon',
                'value' => asset('logo-black.png'),
            ],
            [
                'key' => 'site_copyright',
                'value' => '&copy; '.date('Y').' Appoets'
            ],
            [
                'key' => 'delivery_charge',
                'value' => 20
            ],
            [
                'key' => 'resturant_response_time',
                'value' => 5
            ],
            [
                'key' => 'currency',
                'value' => '$'
            ],
            [
                'key' => 'currency_code',
                'value' => 'USD'
            ],
            [
                'key' => 'search_distance',
                'value' => 10
            ],
            [
                'key' => 'tax',
                'value' => 10
            ],
            [
                'key' => 'payment_mode',
                'value' => 'CASH'
            ],
            [
                'key' => 'manual_assign',
                'value' => '0'
            ],
            [
                'key' => 'transporter_response_time',
                'value' => '30'
            ],
            [
                'key' => 'GOOGLE_MAP_KEY',
                'value' => 'AIzaSyBDkKetQwosod2SZ7ZGCpxuJdxY3kxo5Po'
            ],
            [
                'key' => 'TWILIO_SID',
                'value' => ''
            ],
            [
                'key' => 'TWILIO_TOKEN',
                'value' => ''
            ],
            [
                'key' => 'TWILIO_FROM',
                'value' => ''
            ],
            [
                'key' => 'PUBNUB_PUB_KEY',
                'value' => ''
            ],
            [
                'key' => 'PUBNUB_SUB_KEY',
                'value' => ''
            ],
            [
                'key' => 'stripe_charge',
                'value' => '0'
            ],
            [
                'key' => 'stripe_publishable_key',
                'value' => 'pk_test_39kly6aEfUEfvMpRnN6BnxLb'
            ],
            [
                'key' => 'stripe_secret_key',
                'value' => 'sk_test_I1OGCnG8zVIXCC7sSImIJsOy'
            ],
            [
                'key' => 'FB_CLIENT_ID',
                'value' => '290984818086469'
            ],
            [
                'key' => 'FB_CLIENT_SECRET',
                'value' => '1f52cb4378e623bb819cd8469e408482'
            ],
            [
                'key' => 'FB_REDIRECT',
                'value' => url('/')
            ],
            [
                'key' => 'GOOGLE_CLIENT_ID',
                'value' => '299256700052-rts0nr0a49dutr831oin38aj7mjju2ua.apps.googleusercontent.com'
            ],
            [
                'key' => 'GOOGLE_CLIENT_SECRET',
                'value' => 'FL0YR5dw9RuV6OdI8IkkI9oS'
            ],
            [
                'key' => 'GOOGLE_REDIRECT',
                'value' => url('/')
            ],
            [
                'key' => 'GOOGLE_API_KEY',
                'value' => 'AIzaSyAKGFZT_5uhpOOkma-GBOPamDw_mRIB-p8'
            ],
            [
                'key' => 'ANDROID_ENV',
                'value' => 'development'
            ],
            [
                'key' => 'ANDROID_PUSH_KEY',
                'value' => 'AIzaSyBzvWOtvpuNXBKp6vxBBRMizNJj_1wIQVg'
            ],
            [
                'key' => 'IOS_USER_ENV',
                'value' => 'development'
            ],
            [
                'key' => 'IOS_PROVIDER_ENV',
                'value' => 'development'
            ],
            [
                'key' => 'DEMO_MODE',
                'value' => '1'
            ],
            [
                'key' => 'SUB_CATEGORY',
                'value' => '0'
            ],
            [
                'key' => 'SCHEDULE_ORDER',
                'value' => '0'
            ],
            [
                'key' => 'client_id',
                'value' => '2'
            ],
            [
                'key' => 'client_secret',
                'value' => '0'
            ],
            [
                'key' => 'PRODUCT_ADDONS',
                'value' => '0'
            ],
            [
                'key' => 'BRAINTREE_ENV',
                'value' => 'sandbox'
            ],
            [
                'key' => 'BRAINTREE_MERCHANT_ID',
                'value' => 'twbd779hfc859jxq'
            ],
            [
                'key' => 'BRAINTREE_PUBLIC_KEY',
                'value' => '7bn6hystx7vs2g8r'
            ],
            [
                'key' => 'BRAINTREE_PRIVATE_KEY',
                'value' => '721e48cc74fdf2dfaacc6c3410de2f27'
            ],
             [
                'key' => 'RIPPLE_KEY',
                'value' => 'rEsaDShsYPmMZopoG3nNjutWJCk1Zn9cbX'
            ],
            [
                'key' => 'RIPPLE_BARCODE',
                'value' => url('/images/ripple.png')
            ],
            [
                'key' => 'ETHER_ADMIN_KEY',
                'value' => '0x16abb22fd68c25286d72e77226ddaad87323cbb1'
            ],
            [
                'key' => 'ETHER_KEY',
                'value' => 'R92FW87ER1QZIDYX1UHTVBY625T8HCPKNR'
            ],
            [
                'key' => 'ETHER_BARCODE',
                'value' => url('/images/ether.jpeg')
            ],
            [
                'key' => 'CLIENT_AUTHORIZATION',
                'value' => 'sandbox_v5r97hvk_twbd779hfc859jxq'
            ],
            [
                'key' => 'SOCIAL_FACEBOOK_LINK',
                'value' => 'http://facebook.com'
            ],
            [
                'key' => 'SOCIAL_TWITTER_LINK',
                'value' => 'http://twitter.com'
            ],
            [
                'key' => 'SOCIAL_G-PLUS_LINK',
                'value' => 'http://google.com'
            ],
            [
                'key' => 'SOCIAL_INSTAGRAM_LINK',
                'value' => 'http://instagram.com'
            ],
            [
                'key' => 'SOCIAL_PINTEREST_LINK',
                'value' => 'http://pinterest.com'
            ],
            [
                'key' => 'SOCIAL_VIMEO_LINK',
                'value' => 'http://vimeo.com'
            ],
            [
                'key' => 'SOCIAL_YOUTUBE_LINK',
                'value' => 'http://youtube.com'
            ],
            [
                'key' => 'COMMISION_OVER_FOOD',
                'value' => '5'
            ],
            [
                'key' => 'COMMISION_OVER_DELIVERY_FEE',
                'value' => '10'
            ],
            [
                'key' => 'APP_STORE_LINK',
                'value' => 'https://itunes.apple.com/us/app/foodie-express-food-delivery/id1296870125?mt=8'
            ],
            [
                'key' => 'GOOGLE_PLAY_LINK',
                'value' => 'https://play.google.com/store/apps/details?id=com.foodie.app&hl=en'
            ],


            

        ]);
    }
}
