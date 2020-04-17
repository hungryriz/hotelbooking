<?php

return array(

    'IOSUser'     => array(
        'environment' =>env('IOS_USER_ENV', 'development'),
        'certificate' => app_path().'/apns/user/orderarounddist.pem',
        'passPhrase'  => env('IOS_PUSH_PASS', 'appoets123$'),
        'service'     =>'apns'
    ),
    'IOSProvider' => array(
        'environment' => env('IOS_PROVIDER_ENV', 'development'),
        'certificate' => app_path().'/apns/provider/deliverarounddist.pem',
        'passPhrase'  => env('IOS_PROVIDER_PUSH_PASS', 'appoets123$'),
        'service'     => 'apns'
    ),
    'AndroidUser' => array(
        'environment' =>env('ANDROID_ENV', 'development'),
        'apiKey'      =>env('ANDROID_PUSH_KEY', 'yourAPIKey'),
        'service'     =>'gcm'
    )

);