<?php

namespace App\Http\Controllers\TransporterResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TransporterShift;
use App\TransporterShiftTiming;
use App\TransporterVehicle;
use Carbon\Carbon;
use App\Order;
use App\OrderInvoice;
class ShiftResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {	
        try {
            $Transporter = $request->user();
            $TransporterShift = TransporterShift::List($Transporter->id);
            if(count($TransporterShift) > 0){
                $id = $TransporterShift[0]->id;
                $Order_total_amount = OrderInvoice::withTrashed()->with('orders')
                    ->whereHas('orders', function ($q) use ($id) {
                        $q->where('orders.shift_id', $id);
                        $q->where('orders.status', 'COMPLETED');
                    })->sum('net');;
                $Order_total_amount_cash = OrderInvoice::withTrashed()
                    ->where('payment_mode','cash')
                    ->with('orders')
                    ->whereHas('orders', function ($q) use ($id) {
                        $q->where('orders.shift_id', $id);
                        $q->where('orders.status', 'COMPLETED');
                    })->sum('payable');;
                $TransporterShift[0]->total_amount = (int)$Order_total_amount; 
                $TransporterShift[0]->total_amount_pay = (int)$Order_total_amount_cash;   
            }
            return $TransporterShift;
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('form.whoops')], 500);
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
                'vehicle_no' => 'required'
        ]);
        try {

            $Transporter = $request->user();
            $transporter_shift = TransporterShift::where('transporter_id', $Transporter->id)->first();
            $vehicle = TransporterVehicle::where('transporter_id', $Transporter->id)->where('vehicle_no', $request->vehicle_no)->first();
            
            if(!$transporter_shift) {
                if(!$vehicle) {
                    $vehicle = TransporterVehicle::create([
                        'transporter_id' => $Transporter->id,
                        'vehicle_no' => $request->vehicle_no
                    ]);
                }
                TransporterShift::create([
                    'transporter_id' => $Transporter->id,
                    'transporter_vehicle_id' => $vehicle->id,
                    'start_time' => Carbon::now()
                ]);
                $Transporter->status = 'online';
                $Transporter->save();
            } else {        
                if(!$vehicle) {
                    $vehicle = TransporterVehicle::create([
                        'transporter_id' => $Transporter->id,
                        'vehicle_no' => $request->vehicle_no
                    ]);
                } 
                TransporterShift::where('transporter_id', $Transporter->id)->update([
                    'transporter_vehicle_id' => $vehicle->id
                ]);
            }
            $TransporterShift = TransporterShift::List($Transporter->id);
            if(count($TransporterShift) > 0){
                $id = $TransporterShift[0]->id;
                $Order_total_amount = OrderInvoice::withTrashed()->with('orders')
                    ->whereHas('orders', function ($q) use ($id) {
                        $q->where('orders.shift_id', $id);
                        $q->where('orders.status', 'COMPLETED');
                    })->sum('net');;
                $TransporterShift[0]->total_amount = (int)$Order_total_amount;   
            }
            return $TransporterShift;
        } catch (Exception $e) {
            return response()->json(['error' => trans('form.whoops')], 500);
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
    /*public function update(Request $request, $id)
    {	
        // no need but mobile user may face problem so it be as it is
        try {
            $Transporter = $request->user();
            $transporter_shift_time = TransporterShiftTiming::where('transporter_shift_id',$id)->first();
            if(!$transporter_shift_time){
            	$transporter_shift = TransporterShift::findOrFail($id);
            $now = Carbon::now();
            $Order_total_amount = OrderInvoice::withTrashed()->with('orders')
            ->whereHas('orders', function ($q) use ($id) {
                $q->where('orders.shift_id', $id);
                $q->where('orders.status', 'COMPLETED');
            })->sum('net');
                    //if($transporter_shift->paid==1) {.net
                $transporter_shift->end_time = Carbon::now();
                $transporter_shift->save();
                // soft remove
                //$transporter_shift->delete();
                $Transporter->status = 'unsettled';
                $Transporter->save();
                        $data = TransporterShift::List($Transporter->id); 
                        $data[0]->total_amount = $Order_total_amount;
                        return $data;
                  
            }
            return response()->json(['error' => trans('form.shift.shift_end_error')], 403);
	        
        } catch (ModelNotFoundException $e) {
        	return response()->json(['error' => trans('form.whoops')], 500);
        }
        
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $Transporter = $request->user();
            if($Transporter->status == 'riding'){
               return response()->json(['error' => trans('transporter.shift.shift_end_error')], 422); 
            }
            $transporter_shift_time = TransporterShiftTiming::where('transporter_shift_id',$id)->first();
            if(!$transporter_shift_time){
                $transporter_shift = TransporterShift::findOrFail($id);
            $now = Carbon::now();
            $Order_total_amount = OrderInvoice::withTrashed()->where('payment_mode','cash')->with('orders')
            ->whereHas('orders', function ($q) use ($id) {
                $q->where('orders.shift_id', $id);
                $q->where('orders.status', 'COMPLETED');
            })->sum('net');
             $Order_total_amount_cash = OrderInvoice::withTrashed()
                    ->where('payment_mode','cash')
                    ->with('orders')
                    ->whereHas('orders', function ($q) use ($id) {
                        $q->where('orders.shift_id', $id);
                        $q->where('orders.status', 'COMPLETED');
                    })->sum('payable');;
                    //if($transporter_shift->paid==1) {.net
                $transporter_shift->end_time = Carbon::now();
                // soft remove
                //$transporter_shift->delete();
                if($Order_total_amount==0){
                    $Transporter->status = 'offline';
                    $Transporter->save();
                    $transporter_shift->delete();
                    return [];
                }else{
                    $Transporter->status = 'unsettled';
                    $Transporter->save();
                    $transporter_shift->save();
                    $data = TransporterShift::List($Transporter->id); 
                    $data[0]->total_amount = $Order_total_amount;
                    $data[0]->total_amount_pay = $Order_total_amount_cash;
                    return $data;
                }
                       
                       
                   /* }
                return response()->json(['message' => 'First Clear Your Todays Order Amount'], 200);*/
            }
            return response()->json(['error' => trans('transporter.shift.shift_end_error')], 422);
            
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('form.whoops')], 500);
        }
    }

    /**
     * show all the vehicle details of user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function vehicles(Request $request)
    {
        return $request->user()->vehicles;
    }
}
