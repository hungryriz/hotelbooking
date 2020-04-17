<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SendPushNotification;

use Stripe\Charge;
use Stripe\Stripe;
use Stripe\StripeInvalidRequestError;

use Auth;
use Setting;
use Exception;

use App\Card;
use App\User;
use App\WalletPassbook;
use App\Order;
use App\OrderInvoice;
use Braintree_Customer;
use Braintree_ClientToken;
use Braintree_Transaction ;
use Braintree_PaymentMethodNonce;
use Braintree_Exception_NotFound;
use Braintree_PaymentMethod;

class PaymentController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

       /**
     * payment for user.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        /*$this->validate($request, [
                'order_id' => 'required|exists:order_invoices,id,paid,0|exists:orders,id,user_id,'.Auth::user()->id
            ]);*/
        if($request->payment_mode == 'stripe') {
            $StripeCharge = $request->payable *100 ;  //exit;
            try {
                if($request->card_id){
                    $Card = Card::where('user_id',Auth::user()->id)->where('id',$request->card_id)->first();
                }else{
                    $Card = Card::where('user_id',Auth::user()->id)->where('is_default',1)->first();
                }
                Stripe::setApiKey(Setting::get('stripe_secret_key'));
                $Charge = Charge::create(array(
                      "amount" => $StripeCharge,
                      "currency" => strtolower(Setting::get('currency_code')),
                      "customer" => Auth::user()->stripe_cust_id,
                      "card" => $Card->card_id,
                      "description" => "Payment Charge for ".Auth::user()->email,
                      "receipt_email" => Auth::user()->email
                ));
                return $Charge;

            } catch(StripeInvalidRequestError $e){
                return $e->getMessage();
            } catch(Exception $e) {
                return $e->getMessage();
            }
        }
        if($request->payment_mode == 'braintree') {
            $StripeCharge = $request->payable ;
            try {
                $this->set_Braintree();
              if($request->has('payment_method_nonce')){
                  if($request->payment_card=='PayPalAccount'){
                      $result = Braintree_Transaction::sale([
                        "amount" => $StripeCharge,
                        "paymentMethodNonce" => $request->payment_method_nonce,
                        "orderId" => uniqid(),
                        "merchantAccountId" => Setting::get('BRAINTREE_MERCHANT_ACCOUNT_ID'),
                        "options" => [
                          "paypal" => [
                            "customField" => '',
                            "description" => '',
                          ],
                        ],
                      ]);
                      dd($result);
                  }
                  // any card other than your
                  if($request->payment_card=='CreditCard'){
                      $result = Braintree_Transaction::sale([
                          'amount' => $StripeCharge,
                          'paymentMethodNonce' => $request->payment_method_nonce,
                          "merchantAccountId" => Setting::get('BRAINTREE_MERCHANT_ACCOUNT_ID')
                          /*'options' => [
                              'threeDSecure' => [
                                  'required' => true
                              ]
                          ]*/
                      ]);
                  }
              }else{
                // your card 
                    if($request->card_id){
                        $Card = Card::where('user_id',Auth::user()->id) ->where('card_type','braintree')->where('id',$request->card_id)->first();
                    }else{
                        $Card = Card::where('user_id',Auth::user()->id) ->where('card_type','braintree')->where('is_default',1)->first();
                    }
                    
                    // payment using card
                        $result = Braintree_Transaction::sale([
                          'amount' => $StripeCharge,
                          'paymentMethodToken' => $Card->card_id,
                          "merchantAccountId" => Setting::get('BRAINTREE_MERCHANT_ACCOUNT_ID')
                        ]);
                }
                if ($result->success) {
                    return $result->transaction;
                } 

            } catch(Braintree_Exception_NotFound $e){
                    return $e->getMessage();
            } catch(Exception $e) {
                    return $e->getMessage();   
            }
        }
    }


    /**
     * add wallet money for user.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_money(Request $request){

        $this->validate($request, [
                'amount' => 'required|integer',
                'card_id' => 'required|exists:cards,id,user_id,'.Auth::user()->id
            ]);

        try{
            if(Setting::get('payment_mode')=='braintree'){

            }else{
            $StripeWalletCharge = $request->amount * 100;

            Stripe::setApiKey(Setting::get('stripe_secret_key'));
            $card =Card::where('id',$request->card_id)->first();
            $Charge = Charge::create(array(
                  "amount" => $StripeWalletCharge,
                  "currency" => "usd",
                  "customer" => Auth::user()->stripe_cust_id,
                  "card" => $card->card_id,
                  "description" => "Adding Money for ".Auth::user()->email,
                  "receipt_email" => Auth::user()->email
                ));

            $update_user = User::find(Auth::user()->id);
            $update_user->wallet_balance += $request->amount;
            $update_user->save();
            $update_user->currency = Setting::get('currency');
            $update_user->payment_mode = Setting::get('payment_mode');

            WalletPassbook::create([
              'user_id' => Auth::user()->id,
              'amount' => $request->amount,
              'message' => 'Adding Money form card '.$request->card_id,
              'status' => 'CREDITED',
              'via' => 'CARD',
            ]);

            Card::where('user_id',Auth::user()->id)->update(['is_default' => 0]);
            Card::where('id',$request->card_id)->update(['is_default' => 1]);
          }
            //sending push on adding wallet money
            (new SendPushNotification)->WalletMoney(Auth::user()->id,currencydecimal($request->amount));

            if($request->ajax()){
                  return  $update_user;
                /*return response()->json(['message' => Setting::get('currency').$request->amount.'  '.trans('order.payment.added_to_your_wallet'), 'user' => $update_user]); */
            } else {
                return back()->with('flash_success',$request->amount.trans('order.payment.added_to_your_wallet'));
            }

        } catch(StripeInvalidRequestError $e) {
            if($request->ajax()){
                 return response()->json(['error' => $e->getMessage()], 500);
            }else{
                return back()->with('flash_error',$e->getMessage());
            }
        } catch(Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        }
    }


    public function set_Braintree(){

       \Braintree_Configuration::environment(Setting::get('BRAINTREE_ENV'));
        \Braintree_Configuration::merchantId(Setting::get('BRAINTREE_MERCHANT_ID'));
        \Braintree_Configuration::publicKey(Setting::get('BRAINTREE_PUBLIC_KEY'));
        \Braintree_Configuration::privateKey(Setting::get('BRAINTREE_PRIVATE_KEY'));
    }

    public function checkRipplePayment(Request $request){

        $this->validate($request, [
                'payment_id' => 'required|unique:order_invoices',
                'amount' => 'required'
            ],[
              'payment_id.unique' => 'The Transaction Id has already been used.',
            ]);

      $transaction_id = $request->payment_id;
      $ripple_id = Setting::get('RIPPLE_KEY');
      $amount_ripple = $request->amount;

       try{ 
        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://data.ripple.com/v2/transactions/'.$transaction_id.'?binary=false');
        $response = json_decode($request->getBody());

        if($response->result == 'success'){ 
            //echo $response->transaction->meta->delivered_amount;exit;
            if($response->transaction->tx->Destination==$ripple_id ){
             // echo $response->transaction->tx->Amount/1000000; echo '<br/>';
             // echo $amount_ripple; echo '<br/>';
              //echo ($response->transaction->tx->Amount/1000000 - $amount_ripple); echo '<br/>';
                if(($response->transaction->tx->Amount/1000000 - $amount_ripple) > -0.5){
                  return response()->json(['success' => 'Ok'], 200);
                }else{
                    return response()->json(['success' => 'Ok'], 200);
                  return response()->json(['error' => 'price_not_match'], 200);
                }
            }else{
              return response()->json(['error' => 'Failed'], 200);
            }
        }else{
          return response()->json(['error' => 'Failed'], 200);
        }

      }catch(Exception $e){
        return response()->json(['error' => 'id_not_valid'], 200);
      }
    }

    public function checkEtherPayment(Request $request){

        $this->validate($request, [
                'payment_id' => 'required|unique:order_invoices',
                'amount' => 'required'
            ],[
              'payment_id.unique' => 'The Transaction Id has already been used.',
            ]);

      $transaction_id = $request->payment_id;
      $ether_id = Setting::get('ETHER_KEY');
      $ether_admin_id = Setting::get('ETHER_ADMIN_KEY');
      $amount_ether = $request->amount;

       try{ 
        $client = new \GuzzleHttp\Client();
        $request = $client->get('http://api.etherscan.io/api?module=account&action=txlist&address='.Setting::get('ETHER_ADMIN_KEY').'&startblock=0&endblock=99999999&sort=asc&apikey='.Setting::get('ETHER_KEY'));
        $response = json_decode($request->getBody());
        $ether_data = '';
        if($response->message == 'OK'){ 
          foreach($response->result  as $ether){
            if($ether->blockHash==$transaction_id){ 
              $ether_data = $ether;
            }
          }
            //echo $response->transaction->meta->delivered_amount;exit;
            if($ether_data!=''){
                if($ether_data->to==$ether_admin_id){ 
                    if(($ether->value/1000000000000000000 - $amount_ether) > -0.005){
                      return response()->json(['success' => 'Ok'], 200);
                    }else{
                      return response()->json(['error' => 'price_not_match'], 200);
                    }
                }else{
                  return response()->json(['error' => 'Failed'], 200);
                }
            }else{
              return response()->json(['error' => 'id_not_valid'], 200);
            }
         
        }else{
          return response()->json(['error' => 'id_not_valid'], 200);
        }

      }catch(Exception $e){
        return response()->json(['error' => 'id_not_valid'], 200);
      }
    }
}
