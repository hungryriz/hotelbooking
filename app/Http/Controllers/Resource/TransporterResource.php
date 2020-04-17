<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Route;
use Exception;
use App\TransporterShift;
use App\Transporter;
use App\Order;
use App\TransporterShiftTiming;
use App\Http\Controllers\SendPushNotification;
use Carbon\Carbon;
use App\OrderInvoice;
class TransporterResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Users = Transporter::all();
        return view(Route::currentRouteName(), compact('Users'));
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
        $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|unique:transporters|email|max:255',
                'phone' => 'required|unique:transporters|string|max:255',
                'photo' => 'mimes:jpeg,bmp,png|max:2120',
                'address' => 'required',
                'password' => 'required|min:6|confirmed',
                'country_code' => 'required',
                'phone_number' => 'required'
            ]);
        try {
            $User = $request->all();
            $User['password'] = bcrypt($request->password);
            if($request->hasFile('avatar')) {
                $User['avatar'] = asset('storage/'.$request->avatar->store('transporter/profile'));
            }
            $User['latitude'] = $request->latitude;
            $User['longitude'] = $request->longitude;
            $User['address'] = $request->address;
            $User = Transporter::create($User);

            // return redirect()->route('admin.transporters.index')->with('flash_success', 'Transporter added successfully');
            return back()->with('flash_success', trans('transporter.created_success',['name'=>$User->name]));
        } catch (Exception $e) {
            // return redirect()->route('admin.transporters.index')->with('flash_error', 'Whoops! something went wrong.');
            return back()->with('flash_error', 'Whoops! something went wrong.');
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
        try {
            $User = Transporter::findOrFail($id);
            return view(Route::currentRouteName(), compact('User'));
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.transporters.index')->with('flash_error', 'Whoops! something went wrong.');
            return back()->with('flash_error', 'Whoops! something went wrong.');
        }
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
        if($request->has('settle')){
            $this->validate($request, [
                'settle' => 'required|max:255'
            ]);

        }else{
            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:255',
                'avatar' => 'mimes:jpeg,bmp,png|max:2120',
                'address' => 'required'
            ]);
        }
        try {
            $User = Transporter::findOrFail($id);
            if($request->has('settle')){
                $Update['status'] = 'offline';
                $TransporterShift = TransporterShift::where('Transporter_id',$User->id)->first();
                if($TransporterShift){
                    $TransporterShift->delete();
                }   
                $User->update($Update);
                $push_message = trans('order.order_settled_by_admin');
                (new SendPushNotification)->sendPushToProvider($User->id,$push_message);
                return back()->with('flash_success', trans('transporter.shift_settle',['name'=>$User->name]));
            }else{
                $Update['name'] = $request->name;
                $Update['email'] = $request->email;
                $Update['rating'] = $request->rating;
                $Update['phone'] = $request->phone;
                if($request->has('latitude')) {
                    $Update['latitude'] = $request->latitude;
                }
                if($request->has('longitude')) {
                   $Update['longitude'] = $request->longitude;
                }
                $Update['address'] = $request->address;
                if($request->password) {
                    $Update['password'] = bcrypt($request->password);
                }
                if($request->has('status')) {
                    $Update['status'] = $request->status;
                    if($request->status == 'offline'){
                        $TransporterShift = TransporterShift::where('Transporter_id',$User->id)->first();
                        if($TransporterShift){
                            $TransporterShift->delete();
                        }
                    }
                }
                if($request->hasFile('avatar')) {
                    $Update['avatar'] = asset('storage/'.$request->avatar->store('transporter/profile'));
                }
                $User->update($Update);
            }
            // return redirect()->route('admin.transporters.index')->with('flash_success', 'Transporter details updated!');
            return back()->with('flash_success', trans('transporter.updated_success',['name'=>$User->name]));
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.transporters.index')->with('flash_error', 'Whoops! something went wrong.');
            return back()->with('flash_error', 'Whoops! something went wrong.');
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
        try {
            $User = Transporter::findOrFail($id);
            $User->phone = $User->phone.'-'.uniqid();
            $User->email = $User->email.'-'.uniqid();
            $User->save();
            $User->delete();

            return back()->with('flash_success','Delivery Boy has been deactivated!');
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Whoops! something went wrong.');
        }
    }

    public function shiftdetails(Request $request){
        try {
            $User = Transporter::pluck('name','id');
            $Orders = [];
            $TransporterShifts = [];
            $TransporterShift = [];
            if($request->has('delivery')){
                $TransporterShift = TransporterShift::with('orders','shiftbreaktimes')->withTrashed();
                $TransporterShift->where('Transporter_id',$request->delivery);
            
            if($request->has('date')){
                $TransporterShift->where('start_time','>=',Carbon::parse($request->date));
            }
                $TransporterShift = $TransporterShift->orderBy('id','DESC')->get();
                //dd($TransporterShift);
                foreach($TransporterShift as $key=>$val){
                    $Orders[$val->start_time]=$val;
                    $id = $val->id;
                    $Order_total_amount = OrderInvoice::withTrashed()->with('orders')
                    ->whereHas('orders', function ($q) use ($id) {
                        $q->where('orders.shift_id', $id);
                        $q->where('orders.status', 'COMPLETED');
                    })->sum('net');;
                    $val->total = currencydecimal($Order_total_amount);
                        foreach($val->orders as $kyy=>$vall){ //dd($vall);
                            $OrderStatus = $vall->ordertiming->where('status','ASSIGNED')->first()->toArray();
                            if(count($OrderStatus)>0){ 
                               $Orders[$OrderStatus['created_at']]=$vall; 
                            }
                        }
                        foreach($val->shiftbreaktimes as $kyy=>$vall){
                               $Orders[$vall->start_time]=$vall;    
                        }
                     ksort($Orders);
                     $TransporterShifts[]=$Orders;
                }
                //dd($TransporterShifts);
            }
            return view('admin.transporters.index-list',compact('User','TransporterShifts'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Whoops! something went wrong.');
        }catch(Exception $e){
            return back()->with('flash_error', 'Whoops! something went wrong.');
        }

    }
}
