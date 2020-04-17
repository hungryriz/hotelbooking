<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Route;
use Exception;
use Setting;
use App\Shop;
use App\Order;
use App\Transporter;
use App\OrderInvoice;
use App\OrderRating;
use App\TransporterShift;
use App\Usercart;
use App\OrderTiming;
use App\Http\Controllers\SendPushNotification;
use Carbon\Carbon;
use App\RequestFilter;
class OrderResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get('list')) {
            $Users = Shop::pluck('name','id');
            $Providers = Transporter::pluck('name','id');
            if($request->has('all')){ 
                $Order = Order::where('status','!=','COMPLETED');
                
            }else{
                $Order = Order::where('status','COMPLETED');
            }
            if($request->has('sp')){
                $Order->where('shop_id',$request->sp);
            }
            if($request->has('dp')){
                $Order->where('transporter_id',$request->dp);
            }
            if($request->has('start_date') && $request->has('end_date')){
                 
                $Order->whereBetween('created_at',[Carbon::parse($request->start_date),Carbon::parse($request->end_date)]);
            }
            else if($request->has('start_date')){
                 
                $Order->whereBetween('created_at',[Carbon::parse($request->date),Carbon::parse($request->date)->addDay()]);
            }
            else if($request->has('end_date')){
                 
                $Order->whereBetween('created_at',[Carbon::parse($request->date),Carbon::parse($request->date)->addDay()]);
            }

            $Orders = $Order->get();
            return view(Route::currentRouteName().'-list', compact('Orders','Users','Providers'));
        }
        if($request->get('order_id')) {
            $Orders = Order::where('id',$request->get('order_id'))->get();
            if($request->has('q')){
                return $Orders;
            }
            return view(Route::currentRouteName().'-search', compact('Orders'));
        }

        $Orders = new Order;
        if($request->ajax()){

            $all_orders_received = $Orders->whereIn('status',['ASSIGNED','ORDERED','SEARCHING','RECEIVED'])->whereIN('dispute',['NODISPUTE','RESOLVE'])->get();
            if(count($all_orders_received)>0){
                foreach($all_orders_received as $ka => $va){
                    $Order = $va;
                    //if($Order->dispute!='CREATED'){
                        if($Order->status=='ASSIGNED'){
                            $dispute_time = Setting::get('transporter_response_time');
                            $receive_date_st = OrderTiming::where('order_id',$Order->id)->where('status','ASSIGNED')->orderBy('id','DESC')->first()->created_at;
                            $message = 'No Delivery receive request';
                            $p_user = 'transporter';
                            $push_message = 'Dispute created';
                            
                        }
                        if($Order->status=='ORDERED'){

                          $dispute_time = Setting::get('resturant_response_time');
                          $receive_date_st = OrderTiming::where('order_id',$Order->id)->where('status','ORDERED')->orderBy('id','DESC')->first()->created_at;
                           $message = 'Restaurant not received'; 
                           $p_user = 'shop'; 
                            $push_message = 'Dispute created';
                            
                        }
                        if($Order->status=='SEARCHING'){

                          $dispute_time = Setting::get('transporter_response_time');
                          $receive_date_st = OrderTiming::where('order_id',$Order->id)->where('status','SEARCHING')->orderBy('id','DESC')->first()->created_at;
                           $message = 'No Delivery receive request'; 
                           $p_user = 'shop'; 
                            $push_message = 'Dispute created';
                            
                        }
                         if($Order->status=='RECEIVED'){

                          $dispute_time = ($Order->order_ready_time*60)+Setting::get('resturant_response_time');
                          $receive_date_st = OrderTiming::where('order_id',$Order->id)->where('status','RECEIVED')->orderBy('id','DESC')->first()->created_at;
                           $message = 'No Delivery people available'; 
                           $p_user = 'shop'; 
                        }
                    
                       
                        $receive_date = \Carbon\Carbon::parse($receive_date_st)->addSeconds($dispute_time); 
                        $cur_date=\Carbon\Carbon::now();
                        if($receive_date<=$cur_date){
                            $dispute['order_id'] = $Order->id;
                            $dispute['status'] = 'CREATED';
                            $dispute['description'] = $message;
                            $dispute['dispute_type'] = 'COMPLAINED';
                            $dispute['created_by'] = $p_user;
                            $dispute['created_to'] = $p_user;
                            $request->merge($dispute);
                            $dispute1 = (new DisputeResource)->store($request);
                            (new SendPushNotification)->sendPushToShop($Order->shop->id,$push_message);
                            if($Order->status=='SEARCHING'){  
                            $Filter = RequestFilter::where('request_id',$Order->id)->delete();
                                $Order->status='RECEIVED';
                                $Order->save();
                            }
                            if($Order->status=='ASSIGNED'){  
                            $Transporter = Transporter::where('id',$Order->transporter_id)->first();
                                $Transporter->status='online';
                                $Transporter->save();
                            }
                        }
                    //}
                }
            }

            if($request->has('p')){
                $all_orders_process = $Orders->whereIN('status',['PROCESSING','REACHED'])->where('order_ready_status','0')->get(); 
                        if(count($all_orders_process)>0){
                            foreach($all_orders_process as $kk=>$vv){ 
                                $Order = $vv;
                                 
                                    $half_order_time = $Order->order_ready_time;
                                    $receive_date_st = OrderTiming::where('order_id',$Order->id)->where('status','RECEIVED')->orderBy('id','DESC')->first()->created_at;
                                    $receive_date = \Carbon\Carbon::parse($receive_date_st)->addMinutes($half_order_time); 
                                    $cur_date=\Carbon\Carbon::now();
                                    if($receive_date<=$cur_date){
                                        $Order->order_ready_status = 1;
                                        $Order->save();
                                        $push_message = trans('order.order_ready_user_shop',['id'=>$Order->id]);
                                        (new SendPushNotification)->sendPushToUser($Order->user_id,$push_message);
                                        $push_message = trans('order.order_ready_transporter_shop',['id'=>$Order->id]);
                                        (new SendPushNotification)->sendPushToProvider($Order->transporter_id,$push_message);
                                        
                                    }

                               
                            }
                        }
                
            if(Setting::get('manual_assign')==1){
                    /*$search_order = $Orders->where('status','SEARCHING')->whereIN('dispute',['NODISPUTE','RESOLVE'])->first(); 
                   
                    if(count($search_order)>0){
                        return $Orders->get();
                    }else{*/

                      
                        $all_orders = $Orders->where('status','RECEIVED')->whereIN('dispute',['NODISPUTE','RESOLVE'])
                        //->take(1)
                        ->get(); 
                       //dd($all_orders);
                        if(count($all_orders)>0){
                            foreach($all_orders as $kk=>$vv){ 
                                $Order = $vv;
                                if($vv->dispute != 'CREATED'){
                                    if($Order->schedule_status==1){ 
                                        $delivery_time = \Carbon\Carbon::parse($vv->delivery_date)->subMinutes($Order->order_ready_time); 
                                        $cur_date=\Carbon\Carbon::now();//exit;*/
                                        if($delivery_time<=$cur_date){
                                            $half_order_time = round($Order->order_ready_time/2);
                                            $receive_date_st = OrderTiming::where('order_id',$Order->id)->where('status','RECEIVED')->orderBy('id','DESC')->first()->created_at;//exit;
                                            $receive_date = \Carbon\Carbon::parse($receive_date_st)->addMinutes($half_order_time); 
                                            $cur_date=\Carbon\Carbon::now();//exit;*/
                                            if($receive_date<=$cur_date){
                                            $this->show($request,$vv->id);
                                            }
                                        }
                                    }else{
                                         $half_order_time = round($Order->order_ready_time/2);
                                         $receive_date_st = OrderTiming::where('order_id',$Order->id)->where('status','RECEIVED')->orderBy('id','DESC')->first()->created_at;//exit;
                                        $receive_date = \Carbon\Carbon::parse($receive_date_st)->addMinutes($half_order_time); 
                                        $cur_date=\Carbon\Carbon::now();//exit;*/
                                        if($receive_date<=$cur_date){
                                        $this->show($request,$vv->id);
                                        }
                                    }                              
                                }
                            }
                        }
                        
                        return $Orders->orderBy('id','DESC')->get();
                   // }
                }
                

            }else{

                if($request->has('delivery_date')){
                        $cur_date=\Carbon\Carbon::parse($request->delivery_date);
                        $last_date=\Carbon\Carbon::parse($request->delivery_date)->addDay();  
                        $dataorder = $Orders->whereBetween('delivery_date',[$cur_date,$last_date])->orderBy('delivery_date','ASC')->incoming();
                }else{  
                        if($request->t=='pending'){
                        $dataorder = $Orders->orderBy('id','DESC')->incoming();
                        }
                        if($request->t=='accepted'){
                        $dataorder = $Orders->orderBy('id','DESC')->assigned();
                        }
                        if($request->t=='ongoing'){
                        $dataorder = $Orders->orderBy('id','DESC')->ongoing();
                        }
                        if($request->t=='cancelled'){
                        $dataorder = $Orders->orderBy('id','DESC')->cancelled();
                        }
                }
                return $dataorder;
            }
        }
        return view(Route::currentRouteName(), compact('Orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(Route::currentRouteName());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $Order = Order::findOrFail($id);
            $distance = Setting::get('search_distance', '10');
            $longitude = $Order->shop->longitude;
            $latitude = $Order->shop->latitude; 
            if(Setting::get('search_distance')>0){
                $Transporters = Transporter::where('status','online')
                ->select('*')
                ->selectRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance")
                ->whereRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")->orderBy('distance','ASC') ->get();
            }else{
                $Transporters = Transporter::where('status','online')->get(); 
            }
            $Carts= Usercart::with('product','product.prices','product.images','cart_addons')->where('order_id',$id)->withTrashed()->get();
            if($request->ajax()){
                  //  automatic order assign
                if($request->has('p')){
                //if(Setting::get('manual_assign')==1){  
                    if(count($Transporters)>0){ 
                       
                        //if($receive_date<=$cur_date){
                            
                            foreach($Transporters as $Provider){ 
                                $assign=0;
                                $provider_exist = RequestFilter::where('provider_id',$Provider->id)->count();
                                if($provider_exist ==0){
                                    $assign =1 ;
                                    $Filter = new RequestFilter;
                                    // Send push notifications to the first provider
                                    // incoming request push to provider
                                
                                    $Filter->request_id = $id;
                                    $Filter->provider_id = $Provider->id; 
                                    $Filter->save();
                                    $push_message = trans('order.incoming_request',['id'=>$Order->id]);
                                    (new SendPushNotification)->sendPushToProvider($Provider->id,$push_message);
                                }
                            }
                            if($assign==1){
                                $Order->status = 'SEARCHING';
                                $Order->save();
                                 OrderTiming::create([
                                        'order_id' => $Order->id,
                                        'status' => $Order->status
                                ]); 
                            }
                    }
                    /*if(count($Transporters)>0){ 
                       
                        //if($receive_date<=$cur_date){
                            $Order->status = 'SEARCHING';
                            $Order->save();
                             OrderTiming::create([
                                    'order_id' => $Order->id,
                                    'status' => $Order->status
                            ]); 
                            foreach($Transporters as $Provider){ 
                                $provider_exist = RequestFilter::where('provider_id',$Provider->id)->count();
                                if($provider_exist ==0){
                                    $Filter = new RequestFilter;
                                    // Send push notifications to the first provider
                                    // incoming request push to provider
                                
                                    $Filter->request_id = $id;
                                    $Filter->provider_id = $Provider->id; 
                                    $Filter->save();
                                    $push_message = trans('order.incoming_request',['id'=>$Order->id]);
                                    (new SendPushNotification)->sendPushToProvider($Provider->id,$push_message);
                                }
                            }
                    }*/
                }
                 //  automatic order assign
                return [
                'Order' => $Order,
                'Cart' => $Carts
                ];
            }
            if(@$request->get('p')){
                if(count($Transporters)==0){
                   return redirect()->route('admin.orders.index',['t'=>'pending'])->with('flash_error', trans('order.no_delivary_boy')); 
                }
            }
            return view(Route::currentRouteName(), compact('Order', 'Transporters'));
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.orders.index')->with('flash_error', 'Order not found!');
            return back()->with('flash_error', 'Order not found!');
        } catch (Exception $e) {
            // return redirect()->route('admin.orders.index')->with('flash_error', trans('form.whoops'));
            return back()->with('flash_error', trans('form.whoops'));
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
        return view(Route::currentRouteName());
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
        $this->validate($request, [
                'transporter_id' => 'required_without:status|exists:transporters,id',
                'status' => 'required_without:transporter_id|in:REACHED,PICKEDUP,ARRIVED,COMPLETED,RECEIVED,ASSIGNED,CANCELLED',
            ]);

        try {
            $Order = Order::findOrFail($id);
            if($request->status == 'CANCELLED'){
                if($Order->transporter_id){
                    $Transporter = Transporter::findOrFail($Order->transporter_id);
                    $Transporter->status = 'online';
                    $Transporter->save(); 
                }
                $Order->status = $request->status;
                $push_message = trans('order.order_status',['id'=>$Order->id]);
            }else if($Order->status == 'RECEIVED') {
                $Order->status = 'ASSIGNED';
                $Order->transporter_id = $request->transporter_id;
                $Transporter = Transporter::findOrFail($Order->transporter_id);
                $Transporter->status = 'riding';
                $Transporter->save(); 
                $Filter = RequestFilter::where('request_id',$Order->id)->delete();
                $push_message = trans('order.order_assigned_deliveryboy',['id'=>$Order->id]);
                (new SendPushNotification)->sendPushToProvider($Order->transporter_id,$push_message);
                 $push_message = trans('order.order_assigned_deliveryboy_user',['id'=>$Order->id]);
            } else if($request->status == 'COMPLETED') {
                $Order->status = $request->status;
                $Transporter = Transporter::find($Order->transporter_id);
                $Transporter->status = 'online';
                $Transporter->save();
            }else {
                $Order->status = $request->status;
            }
            $Order->save();
            OrderTiming::create([
                    'order_id' => $Order->id,
                    'status' => $Order->status
            ]);
            (new SendPushNotification)->sendPushToUser($Order->user_id,$push_message);
            if($request->status=='CANCELLED'){
                site_sendmail($order,'order_status','Order Cancelled','order');
            }
            //$push_message = 'Dispute created';
            //(new SendPushNotification)->sendPushToShop($Order->shop->id,$push_message);
             return redirect('/admin/orders?t=pending');
            //return back();
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.orders.index')->with('flash_error', 'Order not found!');
            return back()->with('flash_error', 'Order not found!');
        } catch (Exception $e) {
            // return redirect()->route('admin.orders.index')->with('flash_error', trans('form.whoops'));
            return back()->with('flash_error', trans('form.whoops'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function autoassign(Request $request){

        $request->request->add(['p'=>'auto','t'=>'pending','q'=>1,'ajax'=>1]);
        //print_r($request->all()); exit;
         if(Setting::get('manual_assign')==1){ 
            
            $Orders = new Order;
            $all_orders_received = $Orders->whereIn('status',['ASSIGNED','ORDERED','SEARCHING','RECEIVED'])->whereIN('dispute',['NODISPUTE','RESOLVE'])->get();
            
            if(count($all_orders_received)>0){
                foreach($all_orders_received as $ka => $va){
                    $Order = $va;
                   // if($Order->dispute!='CREATED'){
                        if($Order->status=='ASSIGNED'){
                            $dispute_time = Setting::get('transporter_response_time');
                            $receive_date_st = OrderTiming::where('order_id',$Order->id)->where('status','ASSIGNED')->orderBy('id','DESC')->first()->created_at;
                            $message = 'No Delivery receive request';
                            $p_user = 'transporter';
                            $push_message = 'Dispute created';
                            
                        }
                        if($Order->status=='ORDERED'){

                          $dispute_time = Setting::get('resturant_response_time');
                          $receive_date_st = OrderTiming::where('order_id',$Order->id)->where('status','ORDERED')->orderBy('id','DESC')->first()->created_at;
                           $message = 'Restaurant not received'; 
                           $p_user = 'shop';
                           $push_message = 'Dispute created';
                            
                        }
                        if($Order->status=='SEARCHING'){

                          $dispute_time = Setting::get('transporter_response_time');
                          $receive_date_st = OrderTiming::where('order_id',$Order->id)->where('status','SEARCHING')->orderBy('id','DESC')->first()->created_at;
                           $message = 'No Delivery receive request'; 
                           $p_user = 'shop'; 
                           $push_message = 'Dispute created';
                            
                        }
                        if($Order->status=='RECEIVED'){

                          $dispute_time = ($Order->order_ready_time*60)+Setting::get('resturant_response_time');
                          $receive_date_st = OrderTiming::where('order_id',$Order->id)->where('status','RECEIVED')->orderBy('id','DESC')->first()->created_at;
                           $message = 'No Delivery people available'; 
                           $p_user = 'shop'; 
                        }
                    
                       
                        $receive_date = \Carbon\Carbon::parse($receive_date_st)->addSeconds($dispute_time); 
                        $cur_date=\Carbon\Carbon::now();
                        if($receive_date<=$cur_date){
                            $dispute['order_id'] = $Order->id;
                            $dispute['status'] = 'CREATED';
                            $dispute['description'] = $message;
                            $dispute['dispute_type'] = 'COMPLAINED';
                            $dispute['created_by'] = $p_user;
                            $dispute['created_to'] = $p_user;
                            $request->merge($dispute);
                            $dispute = (new DisputeResource)->store($request);
                            (new SendPushNotification)->sendPushToShop($Order->shop->id,$push_message);
                            if($Order->status=='SEARCHING'){  
                                $Filter = RequestFilter::where('request_id',$Order->id)->delete();
                                $Order->status='RECEIVED';
                                $Order->save();
                            }
                            if($Order->status=='ASSIGNED'){  
                            $Transporter = Transporter::where('id',$Order->transporter_id)->first();
                                $Transporter->status='online';
                                $Transporter->save();
                            }
                        }
                   // }
                }
            }



            $all_orders = Order::where('status','RECEIVED')->whereIN('dispute',['NODISPUTE','RESOLVE'])
            //->take(1)
            ->get();
            
            if(count($all_orders)>0){ 
                foreach($all_orders as $kk=>$vv){ 
                    $Order = $vv;
                    if($vv->dispute != 'CREATED'){
                        if($Order->schedule_status==1){ return 1;
                            $delivery_time = \Carbon\Carbon::parse($vv->delivery_date)->subMinutes($Order->order_ready_time); 
                            $cur_date=\Carbon\Carbon::now();//exit;*/
                            if($delivery_time<=$cur_date){
                                $half_order_time = round($Order->order_ready_time/2);
                                $receive_date_st = OrderTiming::where('order_id',$Order->id)->where('status','RECEIVED')->orderBy('id','DESC')->first()->created_at;//exit;
                                $receive_date = \Carbon\Carbon::parse($receive_date_st)->addMinutes($half_order_time); 
                                $cur_date=\Carbon\Carbon::now();//exit;*/
                                if($receive_date<=$cur_date){
                                $this->show($request,$vv->id);
                                }
                            }
                        }else{
                             $half_order_time = round($Order->order_ready_time/2);
                             $receive_date_st = OrderTiming::where('order_id',$Order->id)->where('status','RECEIVED')->orderBy('id','DESC')->first()->created_at;//exit;
                            $receive_date = \Carbon\Carbon::parse($receive_date_st)->addMinutes($half_order_time); 
                            $cur_date=\Carbon\Carbon::now();//exit;*/
                            if($receive_date<=$cur_date){
                            $this->show($request,$vv->id);
                            }
                        }                              
                    }
                }
            }

        }
    }

    function test($id){

        $Order = Order::findOrFail($id);
            $distance = Setting::get('search_distance', '10');
            $longitude = $Order->shop->longitude;
            $latitude = $Order->shop->latitude; 
            if(Setting::get('search_distance')>0){
                $Transporters = Transporter::where('status','online')
                ->select('*')
                ->selectRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance")
                ->whereRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")->orderBy('distance','ASC') ->get();
            }else{
                $Transporters = Transporter::where('status','online')->get(); 
            }
            $Carts= Usercart::with('product','product.prices','product.images','cart_addons')->where('order_id',$id)->withTrashed()->get();
           
                //if(Setting::get('manual_assign')==1){  
                    if(count($Transporters)>0){ 
                       
                        //if($receive_date<=$cur_date){
                            
                            foreach($Transporters as $Provider){ 
                                $assign=0;
                                $provider_exist = RequestFilter::where('provider_id',$Provider->id)->count();
                                if($provider_exist ==0){
                                    $assign =1 ;
                                    $Filter = new RequestFilter;
                                    // Send push notifications to the first provider
                                    // incoming request push to provider
                                
                                    $Filter->request_id = $id;
                                    $Filter->provider_id = $Provider->id; 
                                    $Filter->save();
                                    $push_message = trans('order.incoming_request',['id'=>$Order->id]);
                                    (new SendPushNotification)->sendPushToProvider($Provider->id,$push_message);
                                }
                            }
                            if($assign==1){
                                $Order->status = 'SEARCHING';
                                $Order->save();
                                 OrderTiming::create([
                                        'order_id' => $Order->id,
                                        'status' => $Order->status
                                ]); 
                            }
                    }
    }
}
