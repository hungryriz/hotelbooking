<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Route;
use Exception;
use Auth;
use App\Order;
use App\Transporter;
use App\OrderInvoice;
use App\OrderRating;
use App\TransporterShift;
use App\Usercart;
use App\OrderTiming;;
use App\OrderDispute;
use App\OrderDisputeComment;
use App\WalletPassbook;
use App\OrderDisputeHelp;
use App\User;
use App\Http\Controllers\SendPushNotification;
class DisputeResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$user = NULL)
    {   
        try{
            if($request->ajax()){
                return $request->user()->disputes;
            }
            if(in_array($user,['shop','user','deliverypeople'])){
                $user = ($user=='deliverypeople')?'transporter':$user;
                $OrderDispute = OrderDispute::List()->where('created_by',$user)->where('status','CREATED');
                if($request->has('order_id')){
                    $OrderDispute->where('order_id',$request->order_id);
                }
                $OrderDispute = $OrderDispute->get();
                //dd($OrderDispute);
                return view('admin.dispute.home', compact('OrderDispute'));  
            }else{
                return redirect('/admin/alldisputes/user')->with('flash_error', trans('form.whoops'));
            }

        } catch (ModelNotFoundException $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')]);
            }
            return redirect('/admin/alldisputes/user')->with('flash_error', trans('form.whoops'));
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')]);
            }
            return redirect('/admin/alldisputes/user')->with('flash_error', trans('form.whoops'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if($request->has('disputehelp_id')){
            $this->validate($request, [
                'order_id' => 'required_without:status|exists:orders,id',
                'disputehelp_id' => 'required'
            ]);
        }else{
            $this->validate($request, [
                'order_id' => 'required_without:status|exists:orders,id',
                'status' => 'required_without:order_id|in:CREATED',
                'description' => 'required',
                'dispute_type' => 'required|in:CANCELLED,COMPLAINED,REFUND,REASSIGN',
                'created_by' => 'required|in:user,shop,transporter',
                'created_to' => 'required|in:user,shop,transporter,dispatcher'
            ]);
        }
        try {
            $Order = Order::findOrFail($request->order_id);

            if($request->has('disputehelp_id')){
                $Disputehelp = OrderDisputeHelp::findOrFail($request->disputehelp_id);
                $user_id = $shop_id = $transporter_id = 0;
               
                if( $request->segment(2) == 'transporter'){
                    $transporter_id = $Order->transporter_id;
                    $user = 'transporter';
                }
                if( $request->segment(2) == 'user'){
                    $user_id = $Order->user_id;
                    $user = 'user';
                }
                if($request->has('description')){
                    $description = $request->description;
                }else{
                    $description = $Disputehelp->name;
                }
                $OrderDispute = OrderDispute::create([
                    'order_id' => $request->order_id,
                    'order_disputehelp_id' => $Disputehelp->id,
                    'status' => $request->status?:'CREATED',
                    'user_id' => $user_id,
                    'shop_id' => $shop_id,
                    'transporter_id' => $transporter_id,
                    'created_by' => $user,
                    'created_to' => $user,
                    'description' => $description,
                    'type' => $request->dispute_type,
                ]);

            }else{ 

                $OrderDispute = OrderDispute::create([
                    'order_id' => $request->order_id,
                    'status' => $request->status?:'CREATED',
                    'user_id' => ($request->created_to=='user')?$Order->user_id:'0',
                    'shop_id' => ($request->created_to=='shop')?$Order->shop_id:'0',
                    'transporter_id' => ($request->created_to=='transporter')?$Order->transporter_id:'0',
                    'created_by' => $request->created_by,
                    'created_to' => $request->created_to,
                    'description' => $request->description,
                    'type' => $request->dispute_type
                ]);
            }
            $Order->dispute = 'CREATED';
            $Order->save();
            if($request->dispute_type == 'CANCELLED'){
                if(isset($Order->transporter_id)){
                    $Transporter = Transporter::findOrFail($Order->transporter_id);
                    $Transporter->status = 'online';
                    $Transporter->save();
                }

            }
            $push_message = trans('order.dispute_created',['id'=>$Order->id]);
            (new SendPushNotification)->sendPushToUser($Order->user_id,$push_message);
            if($Order->transporter_id){
                $push_message = trans('order.dispute_created',['id'=>$Order->id]);
                (new SendPushNotification)->sendPushToProvider($Order->transporter_id,$push_message);
            }
            if($request->ajax()){
                return $Order;
            }
            return back()->with('flash_success',trans('form.dispute.created'));
            
        } catch (ModelNotFoundException $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')]);
            }
            return back()->with('flash_error', trans('form.whoops')); 
        } catch(Exception $e){
             if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')]);
            }
            return back()->with('flash_error', trans('form.whoops')); 
        }
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
            $OrderDispute = OrderDispute::list()->find($id);
            if($request->ajax()){
                return $OrderDispute?:[];
            }
            return view(Route::currentRouteName(), compact('OrderDispute'));
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
       try {
            $OrderDispute = OrderDispute::findOrFail($id);
            $Order = Order::findOrFail($OrderDispute->order_id);
            $User = User::findOrFail($Order->user_id);
            if($request->has('dispute_status')){
                $OrderDispute->status = 'RESOLVED';
                $description = trans('form.dispute.messages.status',['order_id' => $OrderDispute->order_id]);
                $Order->dispute = 'RESOLVE';
                $Order->save();
                OrderTiming::create([
                    'order_id' => $Order->id,
                    'status' => $Order->status
                ]);
            $push_message = trans('order.dispute_resolved',['id'=>$Order->id]);
            (new SendPushNotification)->sendPushToUser($Order->user_id,$push_message);
                if($Order->transporter_id){
                    (new SendPushNotification)->sendPushToProvider($Order->transporter_id,$push_message);
                }
            }

            if($request->has('price')){
                $price = $request->price;
                $description = trans('form.dispute.price',['price' => $price]);
                WalletPassbook::create([
                    'user_id' => $Order->user_id,
                    'amount' => $price,
                    'status' => 'CREDITED',
                    'message' => trans('form.dispute.messages.price',['price'=>$price,'order_id' => $OrderDispute->order_id])
                ]);
                $User->wallet_balance = $User->wallet_balance+$price;
                $User->save();
                $OrderDispute->status = 'RESOLVED';
                $description = trans('form.dispute.messages.status',['order_id' => $OrderDispute->order_id]);
                $Order->status = 'CANCELLED';
                $Order->dispute = 'RESOLVE';
                $Order->save();
                if($Order->transporter_id){
                    $Order->transporter->status = 'online';
                    $Order->transporter->save();
                    (new SendPushNotification)->sendPushToProvider($Order->transporter_id,$description);
                }
                OrderTiming::create([
                    'order_id' => $Order->id,
                    'status' => 'CANCELLED'
                ]);
            $push_message = trans('order.dispute_resolved',['id'=>$Order->id]);
            (new SendPushNotification)->sendPushToUser($Order->user_id,$push_message);
                if($Order->transporter_id){
                    (new SendPushNotification)->sendPushToProvider($Order->transporter_id,$push_message);
                }
            }


            if($request->has('status')){
                $Order->status = $request->status;
                $Order->save();
                $description = trans('form.dispute.messages.order_status',['order_id' => $OrderDispute->order_id,'status' => $request->status ]);
                if($request->status == 'CANCELLED'){
                    if($Order->transporter_id){
                        $Order->transporter->status = 'online';
                        $Order->transporter->save();
                        (new SendPushNotification)->sendPushToProvider($Order->transporter_id,$description);
                    }
                }
                OrderTiming::create([
                    'order_id' => $Order->id,
                    'status' => $request->status
                ]);
            }

            if($request->has('description')){
                $description = $request->description;
            } 
            $OrderDispute->save();
            $OrderDispute_comment = OrderDisputeComment::create([
                    'admin_id' => Auth::user()->id,
                    'order_dispute_id' => $id,
                    'description' => $description
                ]);



            return back()->with('flash_success', trans('form.dispute.updated'));
          
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
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
            

            return view('admin.dispute.chat',compact('OrderDispute','Order'));
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
