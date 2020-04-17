<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\EnquiryTransporter;
use App\User;
use App\Order;
use Session;
use Setting;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('delivery','delivery_store');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //$Shop = Shop::take(4)->get();
        return view('user.home','Shop');
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {   
        $Shop = Shop::take(4)->get();
        $shop_total = Shop::count();
        $user_total = User::count();
        $order_total = Order::where('status','COMPLETED')->count();
        //dd($Shop);
        return view('welcome',compact('Shop','shop_total','user_total','order_total'));
    }
    public function showhome(){
        $Shop = Shop::take(4)->get();
        $shop_total = Shop::count();
        $user_total = User::count();
        $order_total = Order::where('status','COMPLETED')->count();
        //dd($Shop);
        return view('user.home',compact('Shop','shop_total','user_total','order_total'));
    }

    public function order_payment(request $request)
    {   
        //$Order = \App\Order::findOrFail($request->order_id);
        if($request->has('user_address_id')){
            Session::put('note',$request->note);
            Session::put('wallet',$request->wallet);
            Session::put('user_address_id',$request->user_address_id);
            Session::put('amount',$request->amount);
            if(Setting::get('SCHEDULE_ORDER')==1){
                Session::put('delivery_date',$request->delivery_date);
            } 
        }
        $eather_response ='';$ripple_response='';
        if($request->type == 'ripple'){
            $client = new \GuzzleHttp\Client();
            $request_ripple = $client->get('https://www.bitstamp.net/api/v2/ticker/xrpusd');
            $ripple_response = json_decode($request_ripple->getBody());
        }
         if($request->type == 'ether'){
            $client = new \GuzzleHttp\Client();
            $request_ether = $client->get('https://api.etherscan.io/api?module=stats&action=ethprice&apikey='.Setting::get('ETHER_KEY'));
            $ether_response = json_decode($request_ether->getBody());
        }

        $this->set_Braintree();
        $token = \Braintree_ClientToken::generate();
        $cards = (new Resource\CardResource)->index($request);
        return view('user.payment.order_payment',compact('cards','token','ripple_response','ether_response'));
    }

    public function payment(request $request)
    {    
        if(Setting::get('payment_mode')=='braintree'){
            $this->set_Braintree();
            $token = \Braintree_ClientToken::generate();
                $request->request->add([
                    'type' => "braintree"
                ]);
                        
        }else{ 
                $request->request->add([
                    'type' => "stripe"
                ]);
                $token = '';
        }   
        $cards = (new Resource\CardResource)->index($request);
        return view('user.payment.payment',compact('cards','token'));
    }

    public function delivery()
    {  // dd('jjjj');
        //$Shop = Shop::take(4)->get();
        //dd($Shop);
        return view('delivery_enquiry');
    }

    public function delivery_store(Request $request)
    {   
        $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required' 
            ]);
        try{
        EnquiryTransporter::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
            return back()->with('flash_success',trans('home.delivery_boy.created'));
        }catch(Exception $e){
            return back()->with('flash_error',trans('form.whoops'));
        }

        
    }
    public function set_Braintree(){

       \Braintree_Configuration::environment(Setting::get('BRAINTREE_ENV'));
        \Braintree_Configuration::merchantId(Setting::get('BRAINTREE_MERCHANT_ID'));
        \Braintree_Configuration::publicKey(Setting::get('BRAINTREE_PUBLIC_KEY'));
        \Braintree_Configuration::privateKey(Setting::get('BRAINTREE_PRIVATE_KEY'));
    }


    public function wallet(request $request)
    {       
        $this->set_Braintree();
        $token = \Braintree_ClientToken::generate();
        $type = $request->type?$request->type:'stripe';
        $request->request->add(['type' => $type]);
        $cards = (new Resource\CardResource)->index($request);
        return view('user.payment.wallet',compact('cards','token'));
    }
}
