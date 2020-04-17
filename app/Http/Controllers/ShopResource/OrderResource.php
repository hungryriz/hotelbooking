<?php

namespace App\Http\Controllers\ShopResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Route;
use Exception;

use App\Order;
use App\Transporter;
use App\OrderInvoice;
use App\OrderRating;
use App\TransporterShift;
use App\Usercart;
use App\OrderTiming;
use Auth;
use App\Http\Controllers\SendPushNotification;
use Carbon\Carbon;
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
            $Providers = Transporter::pluck('name','id');
           if($request->has('all')){ 
                $Order = Order::where('status','!=','COMPLETED');
                
            }else{
                $Order = Order::where('status','COMPLETED');
            }
            $Order->where('shop_id',Auth::user()->id);
           
           
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
            
            
            return view(Route::currentRouteName().'-list', compact('Orders','Providers'));
        }
        if($request->get('order_id')) {
            $Orders = Order::where('id',$request->get('order_id'))->where('shop_id',Auth::user('shop')->id)->get();
            if($request->ajax()){ 
                if($request->has('q')){
                    return $Orders;
                }
            }
            return view(Route::currentRouteName().'-search', compact('Orders'));
        }
        if($request->t=='ordered'){
            $Orders = Order::where('shop_id',Auth::user()->id)->whereIN('orders.status',['ORDERED'])
                ->orderBy('id','DESC')->get();;

        }else
        if($request->t=='processing'){
            $Orders = Order::where('shop_id',Auth::user()->id)->whereIN('orders.status',['RECEIVED',
                'PROCESSING',
                'ASSIGNED',
                'SEARCHING',
                'REACHED',
                'PICKEDUP',
                'ARRIVED',
                ])
                ->orderBy('id','DESC')->get();;

        }else
        if($request->t=='pending'){
            if($request->has('delivery_date')){ 
                $cur_date = \Carbon\Carbon::parse($request->delivery_date);
                $last_date = \Carbon\Carbon::parse($request->delivery_date)->addDay();
            $Orders = Order::where('shop_id',Auth::user()->id)->whereIN('orders.status',['ORDERED','RECEIVED'])
                ->whereBetween('delivery_date',[$cur_date,$last_date])->orderBy('id','DESC')->get();;
            }else{
            $Orders = Order::where('shop_id',Auth::user()->id)->whereIN('status',['ORDERED','RECEIVED'])->orderBy('id','DESC')->get();
            }

        } else if ($request->t=='accepted') {
            $Orders = Order::where('shop_id',Auth::user()->id)->whereIN('status', ['PROCESSING','ASSIGNED','READY'])->get();
        } else if ($request->t=='ongoing') {
            $Orders = Order::where('shop_id',Auth::user()->id)->whereIn('status', [
                'REACHED',
                'PICKEDUP',
                'ARRIVED',
            ])->get();
        } else if ($request->t=='cancelled') {
            $Orders = Order::where('shop_id',Auth::user()->id)->where('status', 'CANCELLED')->get();
        }else{
            $Orders = Order::where('shop_id',Auth::user()->id)->where('status', 'COMPLETED')->get();
        }
        $tot_incom_resp = Order::where('shop_id',Auth::user()->id)->where('status','ORDERED')->count();
        if($request->ajax()){ 
            return [
                'Orders' => $Orders,
                'tot_incom_resp' => $tot_incom_resp
            ];
        }
        return view(Route::currentRouteName(), compact('Orders','tot_incom_resp'));
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
            // dd($request->route()->getPrefix());

            $Transporters = Transporter::where('status','online')->get();
            $Carts= Usercart::with('product','product.prices','product.images','cart_addons')->where('order_id',$id)->withTrashed()->get();
            if($request->ajax()){
                return [
                'Order' => $Order,
                'Cart' => $Carts
                ];
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
                //'transporter_id' => 'required_without:status|exists:transporters,id',
                'status' => 'required_without:transporter_id|in:REACHED,PICKEDUP,ARRIVED,COMPLETED,RECEIVED,CANCELLED',
            ]);
        if($request->status=='RECEIVED'){
            $this->validate($request, [
                'order_ready_time' => 'required'   
            ]);
        }
        try {
            $Order = Order::findOrFail($id);
            if($request->status=='RECEIVED'){
                $Order->order_ready_time = $request->order_ready_time;
            }
            $Order->status = $request->status;
           
            $Order->save();
            OrderTiming::create([
                    'order_id' => $Order->id,
                    'status' => $Order->status
            ]);
            $push_message = trans('order.order_accept_shop',['id'=>$Order->id]);
            (new SendPushNotification)->sendPushToUser($Order->user_id,$push_message);
            $order = Order::find($Order->id);
            $order->admin = \App\Admin::find(1);
            if($request->status=='RECEIVED'){
                site_sendmail($order,'order_status','Order Confirmed','order');
            }
            if($request->status=='CANCELLED'){
                site_sendmail($order,'order_status','Order Cancelled','order');
                site_sendmail($order,'order_status','Order Cancelled','order_admin');
            }
            if($request->ajax()){
                return $Order;
            }
            // return redirect()->route('admin.orders.show', $Order->id);
            return back();
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function totalIncoming(Request $request)
    {
        try {
            $Orders = $request->user()->orders->where('status','ORDERED')->count();
            return $Orders;
        } catch (ModelNotFoundException $e) {
            
            return 0;
        } catch (Exception $e) {
            return 0;
        }
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
        try {
            $Orders_complete = Order::where('shop_id',Auth::user()->id)->whereIN('status',['COMPLETED']);
            $Orders_cancell = Order::where('shop_id',Auth::user()->id)->whereIN('status',['CANCELLED']);
            if($request->has('dp')){
                $Orders_complete->where('transporter_id',$request->dp);
                $Orders_cancell->where('transporter_id',$request->dp);
            }
            if($request->has('start_date') && $request->has('end_date')){
                 
                $Orders_complete->whereBetween('created_at',[Carbon::parse($request->start_date),Carbon::parse($request->end_date)]);
                $Orders_cancell->whereBetween('created_at',[Carbon::parse($request->start_date),Carbon::parse($request->end_date)]);
                
            }
            else if($request->has('start_date')){
                 
                $Orders_complete->whereBetween('created_at',[Carbon::parse($request->date),Carbon::parse($request->date)->addDay()]);
                $Orders_cancell->whereBetween('created_at',[Carbon::parse($request->date),Carbon::parse($request->date)->addDay()]);
            }
            else if($request->has('end_date')){
                 
                $Orders_complete->whereBetween('created_at',[Carbon::parse($request->date),Carbon::parse($request->date)->addDay()]);
                $Orders_cancell->whereBetween('created_at',[Carbon::parse($request->date),Carbon::parse($request->date)->addDay()]);
            }
            $Orders_complete_res = $Orders_complete->get();
            $Orders_cancell_res = $Orders_cancell->get();
            return [
                'COMPLETED' => $Orders_complete_res,
                'CANCELLED' => $Orders_cancell_res
            ];
        } catch (ModelNotFoundException $e) {
            
            return [];
        } catch (Exception $e) {
            return [];
        }
    }

    public function transporterlist(Request $request){
        try {
            $Orders_complete = Transporter::all();
            
            return $Orders_complete;
        } catch (ModelNotFoundException $e) {
            
            return [];
        } catch (Exception $e) {
            return [];
        }
    }
}
