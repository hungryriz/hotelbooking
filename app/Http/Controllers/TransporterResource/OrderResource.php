<?php

namespace App\Http\Controllers\TransporterResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;
use App\Order;
use App\Transporter;
use App\OrderInvoice;
use App\OrderRating;
use App\OrderTiming;
use App\TransporterShift;
use Setting;
use Carbon\Carbon;
use App\Admin;
use App\Http\Controllers\SendPushNotification;
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
        $orders_before = Order::where('transporter_id',Auth::user()->id)->whereNotIn('status', ['CANCELLED','COMPLETED']);
        $orders_incoming = Order::with('incoming_requests')
            ->whereHas('incoming_requests', function ($query) {
            $query->where('provider_id',Auth::user()->id);
             })->where('status','SEARCHING')->whereIN('dispute',['RESOLVE','NODISPUTE']);
        $orders = $orders_before->union($orders_incoming)->get();
        if(count($orders)>0){
            $Timeout = Setting::get('transporter_response_time');

            $orders[0]->response_time = $Timeout - (time() - strtotime($orders[0]->updated_at));

            //Carbon::parse($orders[0]->updated_at)->addSeconds(Setting::get('transporter_response_time'))->toDateTimeString();;
            $orders[0]->dispute_manager = Admin::role('Dispute Manager')->get();
        }
        return $orders;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
        try{
            $Order = Order::orderBy('orders.updated_at','DESC');;
            $Order->where('orders.transporter_id',$request->user()->id);

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
            return $Order->pastorders();

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
        // 
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
        $this->validate($request, [
                'status' => 'required|in:REACHED,PICKEDUP,ARRIVED,COMPLETED,PROCESSING',
            ]);

        try {

            $Order = Order::findOrFail($id);
            if($request->status == 'COMPLETED')
            {   
               /* $this->validate($request, [      
                        'otp' => 'required'
                ]); 
                if($Order->order_otp != $request->otp){
                    return response()->json(['error' => trans('order.order_otp_mismatch')]);
                }*/

                $order_invoice = OrderInvoice::where('order_id',$id)->first();
                if($order_invoice->paid ==1 ){

                    $Transporter = Transporter::find($Order->transporter_id);
                    $Transporter->status = 'online';
                    $Transporter->save();
                    $TransporterShift = TransporterShift::where('transporter_id',$Order->transporter_id)->first();
                    $TransporterShift->total_order = $TransporterShift->total_order+1;
                    $TransporterShift->save();

                }else{

                    if($order_invoice->payable!=0){ 

                        $this->validate($request, [
                            'total_pay' => 'required|numeric|min:'.$Order->invoice->payable,
                            'tender_pay' => 'required|numeric|min:'.($request->total_pay-$Order->invoice->payable).'|max:'.($request->total_pay-$Order->invoice->payable),
                            'payment_mode' => 'required|in:cash,stripe,paypal,braintree',
                            'payment_status' => 'required|in:pending,processing,failed,success',
                            //'otp' => 'required'
                        ]);
                    }
                

                    $Transporter = Transporter::find($Order->transporter_id);
                    $Transporter->status = 'online';
                    $Transporter->save();
                    $TransporterShift = TransporterShift::where('transporter_id',$Order->transporter_id)->first();
                    $TransporterShift->total_order = $TransporterShift->total_order+1;
                    $TransporterShift->save();
                    
                    if($request->has('payment_mode')) {
                        
                        $order_invoice->payment_mode = $request->payment_mode;   
                    }
                    if($request->has('payment_status')) {
                        
                        $order_invoice->status = $request->payment_status;   
                    }
                    if($request->has('total_pay')) {  

                        $order_invoice->total_pay = $request->total_pay;    
                    }
                    if($request->has('tender_pay')) {
                        
                        $order_invoice->tender_pay = $request->tender_pay;   
                    }
                    if($order_invoice->payable==0){ 
                        $order_invoice->payment_mode = 'cash';
                        $order_invoice->status = 'success'; 
                        $order_invoice->total_pay = 0; 
                        $order_invoice->tender_pay = 0;
                    }

                    $order_invoice->paid = 1;
                    $order_invoice->save();

                }
                site_sendmail($order,'order_status','Order Delivered','order_shop');
            }
            if($request->status == 'PROCESSING')
            {    
                $TransporterShift = TransporterShift::where('transporter_id',$Order->transporter_id)->firstOrFail();  
                $Order->transporter_vehicle_id = $TransporterShift->transporter_vehicle_id;
                $Order->shift_id = $TransporterShift->id;
                $Transporter = Transporter::findOrFail($Order->transporter_id);
                $Transporter->status = 'riding';
                $Transporter->save(); 
                $push_message = trans('order.order_accept_deliveryboy',['id'=>$Order->id]);
                $order = Order::find($Order->id);
                site_sendmail($order,'order_status','Order Processed','order');
            }
            $Order->status = $request->status;
            $Order->save();
             OrderTiming::create([
                    'order_id' => $Order->id,
                    'status' => $Order->status
            ]);
             if($request->status != 'PROCESSING'){
                $push_message = trans('order.order_status',['id'=>$Order->id,'status'=> $request->status]);
             }
            
            (new SendPushNotification)->sendPushToUser($Order->user_id,$push_message);
            $Order->dispute_manager = Admin::role('Dispute Manager')->get();
            return $Order;

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('order.order_can_not_update')]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('form.whoops')]);
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function rate_review(Request $request) {
        $this->validate($request, [
                'order_id' => 'required|integer|exists:orders,id,transporter_id,'.Auth::user()->id,
                'rating' => 'required|integer|in:1,2,3,4,5',
                'comment' => 'max:255'
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
                OrderRating::create([
                    'user_id' => $Order->user_id,
                    'order_id' => $Order->id,
                    'user_rating' => $request->rating,
                    'user_comment' => $request->comment,
                ]);
            } else {
                $OrderRating->user_id = $Order->user_id;
                $OrderRating->user_rating = $request->rating;
                $OrderRating->user_comment = $request->comment;
                $OrderRating->save(); 
               
            }
            // Send Push Notification to Provider 
            if($request->ajax()){
                return response()->json(['message' => trans('form.rating.rating_success')]); 
            }else{
                return redirect('dashboard')->with('flash_success', trans('form.rating.rating_success'));
            }
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')], 500);
            }else{
                return back()->with('flash_error', trans('form.whoops'));
            }
        }

    } 

    public function providerRequest(Request $request){
        $this->validate($request, [
                'status' => 'required',
                'request_status' => 'required',
                'order_id' => 'required'   
        ]);
        try{
            $Order = Order::findOrFail($request->order_id);;
            if($request->request_status=='ACCEPT'){
                $RequestFilter = RequestFilter::where('request_id',$Order->id)->where('provider_id',Auth::user()->id)->first();
                if(count($RequestFilter)>0){
                    $RequestFilter = RequestFilter::where('request_id',$Order->id)->delete();
                    $Order->Transporter_id = Auth::user()->id;
                    $Order->save();
                    return  $this->update($request,$Order->id);
                }else{
                    return response()->json(['message' => 'Request Already taken']);
                }
            }else{
                $RequestFilter = RequestFilter::where('request_id',$Order->id)
                    ->where('provider_id',Auth::user()->id)->delete();
                return response()->json(['message' => 'Request Reject Successfully']);
            }
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')], 500);
            }else{
                return back()->with('flash_error', trans('form.whoops'));
            }
        }

    }
}
