<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Card;
use Exception;
use Auth;
use Setting;
use Braintree_Customer;
use Braintree_ClientToken;
use Braintree_Transaction ;
use Braintree_PaymentMethodNonce;
use Braintree_Exception_NotFound;
use Braintree_PaymentMethod;
class CardResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        try{
            if($request->has('type')){ 
                $cards = Card::where('user_id',Auth::user()->id)->where('card_type',$request->type)->orderBy('created_at','desc')->get();
            }else{
               $cards = Card::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->get(); 
            }
            return $cards; 

        } catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('stripe_token')){
            $this->validate($request,[
                'stripe_token' => 'required'
            ]);
        }
        if($request->has('payment_method_nonce')){
            $this->validate($request,[
                'payment_method_nonce' => 'required'
            ]);
        }
        if($request->has('stripe_token')){
            try{

                $customer_id = $this->customer_id();
                $this->set_stripe();
                $customer = \Stripe\Customer::retrieve($customer_id);
                $card = $customer->sources->create(["source" => $request->stripe_token]);

                $exist = Card::where('user_id',Auth::user()->id)
                                ->where('last_four',$card['last4'])
                                ->where('brand',$card['brand'])
                                ->count();

                if($exist == 0){

                    $all_card = Card::where('user_id',Auth::user()->id)->update(['is_default'=>'0']);


                    $create_card = new Card;
                    $create_card->user_id = Auth::user()->id;
                    $create_card->card_type = 'stripe';
                    $create_card->card_id = $card['id'];
                    $create_card->last_four = $card['last4'];
                    $create_card->brand = $card['brand'];
                    $create_card->is_default = 1;
                    $create_card->save();

                }else{
                    if($request->ajax()){
                        return response()->json(['message' => 'Card Already Added']);
                    } 
                    return back()->with('flash_error','Card Already Added');
                }

                if($request->ajax()){
                    return response()->json(['message' => 'Card Added']); 
                }else{
                    return back()->with('flash_success','Card Added');
                }

            } catch(Exception $e){
                if($request->ajax()){
                    return response()->json(['error' => $e->getMessage()], 500);
                }else{
                    return back()->with('flash_error',$e->getMessage());
                }
            }
        }
        if($request->has('payment_method_nonce')){
            try{    
                    $this->set_Braintree();
                    $payment_method_nonce = $request->payment_method_nonce;
                    $customer_id = $this->braintree_customer_id(); //exit;
                    
                    $customer  = Braintree_Customer::find($customer_id);
                    $card_result = Braintree_PaymentMethod::create([
                        'customerId' => $customer_id,
                        'paymentMethodNonce' => $payment_method_nonce,
                        'options' => [
                            'verifyCard' => true
                        ]
                    ]);
                    $exist = 0;
                    if($card_result->success){
                    
                        $card =$card_result->paymentMethod;
                    
                        $exist = Card::where('user_id',Auth::user()->id)
                                    ->where('last_four',$card->last4)
                                    ->where('brand',$card->cardType)
                                    ->where('card_type','braintree')
                                    ->count();
                    
                        if($exist == 0){

                            $all_card = Card::where('user_id',Auth::user()->id)->where('card_type','braintree')->update(['is_default'=>'0']);


                            $create_card = new Card;
                            $create_card->user_id = Auth::user()->id;
                            $create_card->card_id = $card->token;
                            $create_card->last_four = $card->last4;
                            $create_card->brand = $card->cardType;
                            $create_card->card_type = 'braintree';
                            $create_card->is_default = 1;
                            $create_card->save();

                        }else{
                            if($request->ajax()){
                                return response()->json(['message' => 'Card Already Added']); 
                            }
                            return back()->with('flash_error','Card Already Added');
                        }
                    }else{
                        if($request->ajax()){
                            return response()->json(['error' => 'This is invalid card'], 422);
                        }else{
                            return back()->with('flash_error','This is invalid card');
                        }
                    }

                if($request->ajax()){
                    return response()->json(['message' => 'Card Added']); 
                }else{
                    return back()->with('flash_success','Card Added');
                }

            } catch(Exception $e){
                if($request->ajax()){
                    return response()->json(['error' => $e->getMessage()], 500);
                }else{
                    return back()->with('flash_error',$e->getMessage());
                }
            }
        } 
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {

        /*$this->validate($request,[
                'card_id' => 'required|exists:cards,card_id,user_id,'.Auth::user()->id,
            ]);*/

        try{


            $this->set_stripe();
            $card = Card::where('id',$id)->firstOrFail();
            $customer = \Stripe\Customer::retrieve(Auth::user()->stripe_cust_id);
            $customer->sources->retrieve($card->card_id)->delete();

            Card::where('card_id',$card->card_id)->delete();

            if($request->ajax()){
                return response()->json(['message' => 'Card Deleted']); 
            }else{
                return back()->with('flash_success','Card Deleted');
            }

        } catch(Exception $e){
            if($request->ajax()){
                return response()->json(['error' => $e->getMessage()], 500);
            }else{
                return back()->with('flash_error',$e->getMessage());
            }
        }
    }

    /**
     * setting stripe.
     *
     * @return \Illuminate\Http\Response
     */
    public function set_stripe(){
        return \Stripe\Stripe::setApiKey(Setting::get('stripe_secret_key'));
    }

    /**
     * Get a stripe customer id.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer_id()
    {
        if(Auth::user()->stripe_cust_id != null){

            return Auth::user()->stripe_cust_id;

        }else{

            try{

                $stripe = $this->set_stripe();

                $customer = \Stripe\Customer::create([
                    'email' => Auth::user()->email,
                ]);

                User::where('id',Auth::user()->id)->update(['stripe_cust_id' => $customer['id']]);
                return $customer['id'];

            } catch(Exception $e){
                return $e;
            }
        }
    }

    public function set_Braintree(){

       \Braintree_Configuration::environment(Setting::get('BRAINTREE_ENV'));
        \Braintree_Configuration::merchantId(Setting::get('BRAINTREE_MERCHANT_ID'));
        \Braintree_Configuration::publicKey(Setting::get('BRAINTREE_PUBLIC_KEY'));
        \Braintree_Configuration::privateKey(Setting::get('BRAINTREE_PRIVATE_KEY'));
    }

     /**
     * Get a stripe customer id.
     *
     * @return \Illuminate\Http\Response
     */
    public function braintree_customer_id()
    {
        if(Auth::user()->braintree_id != null){

            return Auth::user()->braintree_id;

        }else{
                $this->set_Braintree();
            try{ 
                $user = Auth::user();
                $customer = Braintree_Customer::create([
                    'firstName' => $user->name,
                    'lastName' => $user->name,
                    'company' => 'Tranxit',
                    'email' => Auth::user()->email,
                    'phone' => $user->phone,
                    //'fax' => '419.555.1235',
                    //'website' => 'http://example.com'
                ]);

                User::where('id',Auth::user()->id)->update(['braintree_id' => $customer->customer->id]);
                return $customer->customer->id;

            } catch(Exception $e){
                return $e;
            }
        }
    }

}
