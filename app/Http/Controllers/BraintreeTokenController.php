<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*use Braintree_ClientToken;*/
class BraintreeTokenController extends Controller
{
   public function token()
    {
        return response()->json([
            'data' => [
                'token' => //Braintree_ClientToken::generate(),
            ]
        ]);
    }

    public function payment(Request $request)
    {
    	return view('user.payment');
 	}

 	public function do_payment(Request $request)
    {
    	//$request->user()->newSubscription('main', 1)->create($request->payment_method_nonce);
 	}
}
