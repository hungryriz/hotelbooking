<?php

return [

    /*
    |--------------------------------------------------------------------------
    | All Form Elements
    |--------------------------------------------------------------------------
    */

    'name' => 'Name',
    'first_name' => 'First Name',
    'last_name' => 'Last Name',
    'email' => 'E-Mail Address',
    'parent' => 'Parent',
    'phone' => 'Phone',
    'password' => 'Password',
    'confirm_password' => 'Confirm Password',
    'location' => 'Location',
    'address' => 'Address',
    'logout_success'=>'LogOut Successfully',
    'hours_opening' => 'Shop Opens',
    'hours_closing' => 'Shop Closes',
    'Min_Amount' => 'Min Amount',
    'offer_percent' => 'Offer in Percentage',
    'estimated_delivery_time' => 'Max Delivery Time',
    'cuisine' => 'Cuisine',
    'everyday' => 'Everyday',
    'status' => 'Status',
    'description' => 'Description',
    'pure_veg' => 'Is Pure Veg ?',
    'no_data_found' => 'No Data Found !',
    'socialuser_exist' => 'Social user already exist',
    'socialuser_notexist' => 'Social user not exist. please Register',
    'mobile_exist' => 'Mobile Number already exist',
    'already_favorite' => 'This resturant already in Favorite List',
    'rating' => [
        'rating_success' => 'Successfully Review Rating Done'
    ],
    'resource' => [
        'created' => 'Created successfully',
        'updated' => 'Updated successfully',
        'deleted' => 'Deleted successfully',    
    ],
    'profile' => [
        'updated'=>'Password updated successfully'
    ],
    'shift' => [
        'shift_end_error'=> 'Cannot end a shift on Break Or on Continue Order',
        'shift_start_error' => 'Cannot take a break before completing an order'
    ],
    'order' => [
        'cart_empty' => 'Nothing in cart!',
        'not_paid' => 'Payment Not Completed Yet',
        'insufficient_balance' => 'Insufficient Balance'
    ],
    'promocode' => [
        'expired' => 'Promocode Expired',
        'applied' => 'Promocode Applied',
        'already_in_use' => 'Promocode Already in Use',
        'message' => 'wallet Credited  Using Promocode :promocode'
    ],
     'invoice' => [
        'message' => ':price Debited in Your Wallet Against Order Id :order_id',
    ],
    'dispute' => [

        'messages' => [
            'status' => 'Order :order_id Change Status CREATED To RESOLVED',
            'price'  => ':price Credited in Your Wallet Against Order Id :order_id',
            'order_status' => 'Order :order_id  Status Updated To :status'
        ],
        'price' =>' :price  Added In Your Wallets' ,
        'created' => 'Dispute Created Successfully',
        'updated' => 'Dispute Status Updated Successfully',
    ],

    'not_found' => 'The requested resource was not found!',
    'whoops' => 'Whoops! Looks like something went wrong. Please try again later!',

    'favorite' => [
            'favorite' => 'Successfully Do As Favorite',
            'un_favorite' => 'Successfully Do As UnFavorite'
    ],
    'push' => [
        'added_money_to_wallet' => 'Money added In Your Wallet',
    ],
    'lang' => [
        'site_title' => 'Site Title',
        'site_logo' => 'Site Logo',
        'site_favicon' => 'Site Favicon',
        'site_copyright' => 'Site CopyRight',
        'delivery_charge' => 'Delivery Charge',
        'resturant_response_time' => 'Resturant Response Time',
        'currency' => 'Currency',
        'manual_assign' => 'Order Assign',
        'search_distance' => 'Search Distance',
        'tax' => 'Tax',
        'transporter_response_time' => 'Delivery People Response Time',
        'currency_code' => 'Currency Code',
        'GOOGLE_MAP_KEY' => 'GOOGLE MAP KEY',
        'payment_mode' => 'Payment Mode'
    ]

    
];