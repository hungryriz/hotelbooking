<?php

namespace App\Http\Controllers\UserResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\UserResource\CartResource;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Auth;
use App\Shop;
use App\Order;
use App\UserCart;
use App\CartAddon;
use App\ProductPrice;
use App\OrderInvoice;
use App\UserAddress;
use App\OrderTiming;
use App\OrderRating;
use Setting;
use App\Product;
use Carbon\Carbon;
use App\WalletPassbook;
use App\Http\Controllers\SendPushNotification;
use App\Http\Controllers\PaymentController;
use App\Card;
use App\Promocode;
class OrderResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        try{
            $Order = Order::orderBy('id','DESC');;
            $Order->where('orders.user_id',$request->user()->id);
            if($request->type == 'today') {

                $Order->where('created_at', '>=', Carbon::today());

            } elseif($request->type == 'weekly') {
                $monday = Carbon::now()->startOfWeek();
                $sunday = Carbon::now()->endOfWeek();
                $Order->whereBetween('created_at',[$monday,$sunday]);
                //$Order->where('created_at', '>=', Carbon::now()->weekOfYear);

            } elseif($request->type == 'monthly') {
                $startmonth = Carbon::now()->startOfMonth();
                $endmonth = Carbon::now();
                $Order->whereBetween('created_at',[$startmonth,$endmonth]);
                //$Order->where('created_at', '>=', Carbon::now()->month);
            }
            $Orders = $Order->pastorders();
            $Ongoing = $Order->ongoing();
            if($request->ajax()){
                return $Orders;
            }
            if($request->segment(1)=='payments'){
                return view('user.orders.payments',compact('Orders','Ongoing'));
            }else{

                return view('user.orders.index',compact('Orders','Ongoing'));
            }
        } catch (Exception $e) {    
            return response()->json(['error' => trans('form.whoops')], 500);  
        }
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderprogress(Request $request)
    {   
        try{
            $Orders = Order::where('user_id',$request->user()->id)->orderBy('updated_at','DESC')->progress();
            if($request->ajax()){
                return $Orders;
            }
            return view('user.home',compact('Orders')); 
        }catch (Exception $e) {    
            return response()->json(['error' => trans('form.whoops')], 500);  
        }
       
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reorder(Request $request)
    {   
        $this->validate($request, [
                'order_id' => 'required'
            ]);
        try{  
            $order = Order::findOrFail($request->order_id);
            (new CartResource)->clearCart($request);
            $usercart = UserCart::with('cart_addons')->withTrashed()->where('order_id',$request->order_id)->get();
                foreach($usercart as $item){
                    $request->request->add(['product_id' => $item->product_id]);
                    $request->request->add(['quantity' => $item->quantity]);
                    $CartProduct = UserCart::create([
                        'user_id' => $request->user()->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'note' => $item->note
                    ]); 
                    if(count($item->cart_addons)>0){
                        foreach ($item->cart_addons as $key => $value) {
                            CartAddon::create([
                                'addon_product_id' => $value->addon_product_id,
                                'user_cart_id' => $CartProduct->id,
                                'quantity' => $value->quantity,
                            ]); 
                         }
                     }
                }
            if($request->has('user_address_id')){
                if((new CartResource)->index($request)){
                    return redirect('restaurant/details?name='.$order->shop->name.'&myaddress=home')->with('flash_success',trans('order.reorder_created'));
                }
            }else{
            return (new CartResource)->index($request);
            }
        } catch (ModelNotFoundException $e) { 
            return response()->json(['error' => trans('order.invalid')], 422); 
        } catch (Exception $e) {    
            return response()->json(['error' => trans('form.whoops')], 500);  
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
        $this->validate($request, [
                'user_address_id' => 'required|exists:user_addresses,id,deleted_at,NULL',
                //'payment_mode' => 'required'
            ]);

        $User = $request->user()->id;
        $CartItems = UserCart::with('cart_addons')->where('user_id', $User)->get();
        $payment_status = 'pending';
        $tot_qty = 0; $tot_price = 0; $tax = 0; $discount = 0; $net = 0;$total_pay_user = 0;
        $ripple_price = 0;$DestinationTag='';
        if(!$CartItems->isEmpty()) {
            try {
                // Shop finding logic goes here.
                $Shop_id = Product::findOrFail($CartItems[0]->product_id)->shop_id;
                  
                    $Useraddress = UserAddress::findOrFail($request->user_address_id);
                    $longitude = $Useraddress->longitude;
                    $latitude = $Useraddress->latitude;
                    $distance = Setting::get('search_distance');
                    if(Setting::get('search_distance')>0){
                        $Shop = Shop::select('shops.*')
                        ->selectRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance")

                        ->whereRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                        ->where('status','active')->findOrFail($Shop_id);
                    }else{
                       $Shop = Shop::findOrFail($Shop_id); 
                    }




                 //  for calculating total amount 
                // this is repeated code because of validation
                foreach ($CartItems as $Product) {
                    $tot_qty = $Product->quantity;
                    $tot_price += $Product->quantity * ProductPrice::where('product_id',$Product->product_id)->first()->price;
                    $tot_price_addons = 0;
                    if(count($Product->cart_addons)>0){
                        foreach($Product->cart_addons as $Cartaddon){

                           $tot_price_addons += $Cartaddon->quantity * $Cartaddon->addon_product->price; 
                        }
                    }
                    $tot_price += $tot_qty*$tot_price_addons; 
                    if($Product->promocode_id) {
                        $discount += $discount;
                    }

                     if($request->has('promocode_id')) {
                        $find_promo = Promocode::find($request->promocode_id);
                        $discount +=$find_promo->discount; 
                    }


                    //$Product->order_id = $Order->id;
                    /*$Product->save();
                    $Product->delete();*/
                }
                

                $net = $tot_price;
                if($Shop->offer_percent){
                    if($tot_price > $Shop->offer_min_amount){
                       //$discount = roundPrice(($tot_price*($Order->shop->offer_percent/100)));
                       $discount = ($tot_price*($Shop->offer_percent/100));
                       //if()
                       $net = $tot_price - $discount;
                    }
                }
                $total_wallet_balance = 0;
                $tax = ($net*Setting::get('tax')/100);
                $total_net = roundPrice($net+$tax+Setting::get('delivery_charge'));
                $payable = $total_net;

                 if($request->wallet){
                    if($request->user()->wallet_balance > $total_net){
                        $total_wallet_balance_left = $request->user()->wallet_balance - $total_net;
                        $request->user()->wallet_balance = $total_wallet_balance_left;
                        $request->user()->save();
                        $total_wallet_balance = $total_net;
                        $payable = 0;
                        $payment_status = 'success';
                        $request->payment_mode = 'wallet';
                         WalletPassbook::create([
                            'user_id' => $request->user()->id,
                            'amount' => $total_wallet_balance,
                            'status' => 'DEBITED',
                            'message' => trans('form.invoice.message',['price'=>$total_wallet_balance,'order_id' => ''])
                        ]);
                    }else{ 
                        //$total_net = $total_net - $request->user()->wallet_balance;
                        $total_wallet_balance = $request->user()->wallet_balance;
                        if($total_wallet_balance >0){
                            $request->user()->wallet_balance = 0;
                            $request->user()->save();
                            $payable = ($total_net - $total_wallet_balance);
                            WalletPassbook::create([
                            'user_id' => $request->user()->id,
                            'amount' => $request->user()->wallet_balance,
                            'status' => 'DEBITED',
                            'message' => trans('form.invoice.message',['price'=>$request->user()->wallet_balance,'order_id' => ''])
                        ]);

                        }
                    }
                }
               
            }catch(ModelNotFoundException $e){
                if($request->ajax()){
                    return response()->json(['message' => trans('order.address_out_of_range')], 422);
                }
                return back()->with('flash_failure',trans('order.address_out_of_range'));

            } catch (Exception $e) {
                return response()->json(['message' => trans('order.order_shop_not_found')], 404);
            }

            try{ 
                if($request->has('payment_mode')){
                    if($request->payment_mode=='stripe'){
                        if($request->card_id){
                            $Card = Card::where('user_id',Auth::user()->id)->where('id',$request->card_id)->firstorFail();
                        }else{
                            $Card = Card::where('user_id',Auth::user()->id)->where('is_default',1)->firstorFail();
                        }
                    }
                    if($request->payment_mode=='braintree'){
                        //if($request->payment_card!='PayPalAccount' || $request->payment_card!='CreditCard'){
                        if(!$request->has('payment_card')){
                            
                            if($request->has('card_id')){
                                $Card = Card::where('user_id',Auth::user()->id)->where('id',$request->card_id)->firstorFail();
                            }else{
                                $Card = Card::where('user_id',Auth::user()->id)->where('is_default',1)->firstorFail();
                            }
                        }
                    }
                }
            }catch(ModelNotFoundException $e){
                if($request->ajax()){
                    return response()->json(['error' => trans('order.card.no_card_exist')], 422);
                }
                return back()->with('flash_failure',trans('order.card.no_card_exist'));
            }

            try{  
                $payment_id=0;
                if($request->has('payment_mode')){
                    if($request->payment_mode=='stripe'){
                        $request->payable = $payable;
                        if($payable!=0){
                            $payment = (new PaymentController)->payment($request);
                            if(isset($payment['id'])){
                                $payment_id = $payment['id'];
                                $payment_status = 'success';
                                $total_pay_user = $payable;
                            }else{
                                if($request->ajax()){
                                    return response()->json(['error' => trans('order.payment.failed')], 422);
                                } else {
                                    return back()->with('flash_error', trans('order.payment.failed'));
                                }
                            }
                        }
                    }
                    if($request->payment_mode=='braintree'){
                        $request->payable = $payable;
                        if($payable!=0){
                            $payment = (new PaymentController)->payment($request);
                            if(isset($payment->id)){
                                $payment_id = $payment->id;
                                $payment_status = 'success';
                                $total_pay_user = $payable;
                            }else{
                                if($request->ajax()){
                                    return response()->json(['error' => trans('order.payment.failed')], 422);
                                } else {
                                    return back()->with('flash_error', trans('order.payment.failed'));
                                }
                            }
                        }

                        //exit;
                    }
                    if($request->payment_mode=='ripple'){
                        $request->payable = $payable;
                        if($payable!=0){
                            
                            if(isset($request->payment_id)){
                                $payment_id = $request->payment_id;
                                $payment_status = 'success';
                                $total_pay_user = $payable;
                                $ripple_price = $request->ripple_price;
                                $DestinationTag = $request->DestinationTag;
                            }else{
                                if($request->ajax()){
                                    return response()->json(['error' => trans('order.payment.failed')], 422);
                                } else {
                                    return back()->with('flash_error', trans('order.payment.failed'));
                                }
                            }
                        }

                        //exit;
                    }

                     if($request->payment_mode=='eather'){
                        $request->payable = $payable;
                        if($payable!=0){
                            
                            if(isset($request->payment_id)){
                                $payment_id = $request->payment_id;
                                $payment_status = 'success';
                                $total_pay_user = $payable;
                                $ripple_price = $request->amount;
                            }else{
                                if($request->ajax()){
                                    return response()->json(['error' => trans('order.payment.failed')], 422);
                                } else {
                                    return back()->with('flash_error', trans('order.payment.failed'));
                                }
                            }
                        }

                        exit;
                    }
                }
            }catch(Exception $e){
                if($request->ajax()){
                    return response()->json(['message' => trans('form.whoops')], 422);
                }
                return back()->with('flash_failure',trans('form.whoops'));
            }



            try{
            $details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$Shop->latitude.",".$Shop->longitude."&destination=".$Useraddress->latitude.",".$Useraddress->longitude."&mode=driving&key=".env('GOOGLE_MAP_KEY');
            $json = curl($details);
            $details = json_decode($json, TRUE);
            if(count($details['routes'])>0){
                $route_key = $details['routes'][0]['overview_polyline']['points'];
            }else{
                $route_key = '';
            }

            if($request->has('delivery_date')){

                $delivery_date = $request->delivery_date;
                if(Carbon::parse($delivery_date)->format('Y-m-d').' 00:00:00' == Carbon::today() ){
                    $schedule_status = 0;
                }else{
                    $schedule_status = 1;
                }
                
            }else{

                $delivery_date = date('Y-m-d H:i');
                $schedule_status = 0;
            }
            $newotp = rand(100000,999999);
            $Order = Order::create([
                'invoice_id' => Uuid::uuid4()->toString(),
                'user_id' => $User,
                'shop_id' => $Shop->id,
                'user_address_id' => $request->user_address_id,
                'route_key' => $route_key,
                'note' => $request->note,
                'schedule_status' => $schedule_status,
                'delivery_date' => $delivery_date,
                'order_otp' => $newotp
            ]);
            }catch(ModelNotFoundException $e){
                if($request->ajax()){
                    return response()->json(['error' => trans('order.card.no_card_exist')], 422);
                }
                return back()->with('flash_failure',trans('order.card.no_card_exist'));
            }catch(Exception $e){
                if($request->ajax()){
                    return response()->json(['error' => trans('order.not_created')], 422);
                }
                return back()->with('flash_failure',trans('order.not_created'));
            }


            try{
               
               
                if($Order->id && $tot_qty){
                    
                    $Order_invoice = OrderInvoice::create([
                        'order_id' => $Order->id,
                        'quantity' => $tot_qty,
                        'gross' => $tot_price,
                        'discount' => $discount,
                        'wallet_amount' => $total_wallet_balance,
                        'delivery_charge' => Setting::get('delivery_charge'),
                        'tax' => $tax,
                        'net'=> $total_net,
                        'payable' => $payable,
                        'paid' => ($payment_status=='success')?1:0,
                        'status' => $payment_status,
                        'payment_id' => $payment_id,
                        'total_pay' => $total_pay_user,
                        'ripple_price' => $ripple_price,
                        'payment_mode' => $request->payment_mode?$request->payment_mode:'cash',
                        'DestinationTag' => $DestinationTag
                    ]);
                    //site_sendmail($Order);
                }else{
                     $Order->delete();
                }

            }catch(ModelNotFoundException $e){
                if($request->ajax()){
                    return response()->json(['error' => trans('order.invoice_not_created')], 422);
                }
                return back()->with('flash_failure',trans('order.invoice_not_created'));
            }catch(Exception $e){
                if($request->ajax()){
                    return response()->json(['error' => trans('order.not_created')], 422);
                }
                return back()->with('flash_failure',trans('order.not_created'));
            }


            
            OrderTiming::create([
                    'order_id' => $Order->id,
                    'status' => 'ORDERED'
            ]);
            $push_message = trans('order.order_created',['id'=>$Order->id]);
            (new SendPushNotification)->sendPushToUser($User,$push_message);

            if($Order->id && $Order_invoice->id){
                foreach ($CartItems as $Product) {
                    $Product->order_id = $Order->id;
                    $Product->save();
                    $Product->delete();
                }
                // order otp push notification
                $push_message = trans('order.order_otp',['otp'=>$newotp]);
                (new SendPushNotification)->sendPushToUser($User,$push_message);
                $order = Order::find($Order->id);
                $order->admin = \App\Admin::find(1);
                site_sendmail($order,'invoice','Order Placed','order');
                site_sendmail($order,'order_status','Order Placed','order_shop');
                site_sendmail($order,'order_status','Order Placed','order_admin');
                if($request->ajax()){ 
                    return Order::find($Order->id);
                }
                return redirect('orders/'.$Order->id)->with('flash_success',trans('order.created'));
            }else{
                if($request->ajax()){
                    return response()->json(['message' => trans('form.whoops')], 422);
                 }
                return back()->with('flash_failure',trans('form.whoops'));
            }
        } else {
            if($request->ajax()){
                return response()->json(['message' => trans('form.order.cart_empty')], 422);
            }
            return back()->with('flash_failure',trans('form.whoops'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        try {
            $Order = Order::findOrFail($id);
            if($request->ajax()){ 
                return $Order;
            }
            return view('user.orders.confirm',compact('Order'));
        } catch (ModelNotFoundException $e) {
            if($request->ajax()){
                return response()->json(['message' => trans('order.invalid')], 422);
            }
            return back()->with('flash_failure',trans('form.whoops'));
        } catch (ModelNotFoundException $e) {

            if($request->ajax()){
                return response()->json(['message' => trans('order.invalid')], 422);
            }
            return back()->with('flash_failure',trans('form.whoops'));

        }
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
    public function destroy(Request $request, $id)
    {
        $Order = Order::findOrFail($id);
        if($Order->status=='ORDERED'){

            $Order->status = 'CANCELLED';
            $Order->reason = $request->reason;
        }
        $Order->save();
        OrderTiming::create([
                    'order_id' => $Order->id,
                    'status' => 'CANCELLED'
        ]);
        $order = Order::find($Order->id);
        $order->admin = \App\Admin::find(1);
        site_sendmail($order,'order_status','Order Cancelled','order');
        site_sendmail($order,'order_status','Order Cancelled','order_admin');
        return $Order;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function rate_review(Request $request) {
        $this->validate($request, [
                'order_id' => 'required|integer|exists:orders,id,user_id,'.Auth::user()->id,
                'rating' => 'required|integer|in:1,2,3,4,5',
                'comment' => 'max:255',
                'type' => 'required|in:shop,transporter',
            ]);
        $Order = Order::find($request->order_id);
        $OrderRequests = OrderInvoice::where('order_id' ,$request->order_id)
                ->where('status' ,'success')
                ->where('paid', 0)
                ->first();
        if ($OrderRequests) {
            if($request->ajax()){
                return response()->json(['error' => trans('order.not_paid')], 500);
            } else {
                return back()->with('flash_error', trans('order.not_paid'));
            }
        }
        try{
            $OrderRating = OrderRating::where('order_id',$request->order_id)->first();
            if(!$OrderRating) { 
                if($request->type == 'transporter'){
                    OrderRating::create([
                        'transporter_id' => $Order->transporter_id,
                        'order_id' => $Order->id,
                        'transporter_rating' => $request->rating,
                        'transporter_comment' => $request->comment,
                    ]);
                }else{
                    OrderRating::create([
                        'shop_id' => $Order->shop_id,
                        'order_id' => $Order->id,
                        'shop_rating' => $request->rating,
                        'shop_comment' => $request->comment,
                    ]);
                }
            } else {
                if($request->type == 'transporter'){
                    $OrderRating->transporter_id = $Order->transporter_id;
                    $OrderRating->transporter_rating = $request->rating;
                    $OrderRating->transporter_comment = $request->comment;
                    $OrderRating->save();  
                } else {
                    $OrderRating->shop_id = $Order->shop_id;
                    $OrderRating->shop_rating = $request->rating;
                    $OrderRating->shop_comment = $request->comment;
                    $OrderRating->save(); 
                } 
            }
            // Send Push Notification to Provider 
            if($request->ajax()){
                return response()->json(['message' => trans('form.rating.rating_success')]); 
            }else{
                return back()->with('flash_success', trans('form.rating.rating_success'));
            }
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')], 500);
            }else{
                return back()->with('flash_error', trans('form.whoops'));
            }
        }

    } 


    public function chatWithUser(Request $request){
        try{

            if($request->has('dispute_id')){
                $id = $request->dispute_id;
                $OrderDispute = OrderDispute::findOrFail($id);
                $Order = Order::findOrFail($OrderDispute->order_id);
            }
            if($request->has('order_id')){
                $id = $request->order_id;
                $OrderDispute =[] ;//OrderDispute::findOrFail($id);
                $Order = Order::findOrFail($id);
            }
            
            $dispute_manager = \App\Admin::role('Dispute Manager')->pluck('id','id')->toArray();
            

            return view('user.orders.chat',compact('OrderDispute','Order','dispute_manager'));
        } catch (ModelNotFoundException $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')]);
            }
            return back()->with('flash_error', trans('form.whoops'));
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')]);
            }
            return back()->with('flash_error', trans('form.whoops'));
        }
    }
}
