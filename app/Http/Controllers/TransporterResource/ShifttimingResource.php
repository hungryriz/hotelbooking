<?php

namespace App\Http\Controllers\TransporterResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TransporterShift;
use App\TransporterVehicle;
use App\TransporterShiftTiming;
use Carbon\Carbon;
use App\OrderInvoice;
class ShifttimingResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //return TransporterShiftTiming::all()->sum('total_order');
        try {
            $Transporter = $request->user();
            if($Transporter->status == 'riding'){
                return response()->json(['error' => trans('form.shift.shift_start_error')],422);
            } else {
                $transporter_shift = TransporterShift::where('transporter_id', $Transporter->id)->first();
                if($transporter_shift) {
                    $transporter_shift_breaktime = TransporterShiftTiming::where('transporter_shift_id', $transporter_shift->id)->first();
                    if(!$transporter_shift_breaktime){
                        TransporterShiftTiming::create([
                            'transporter_shift_id' => $transporter_shift->id,
                            'start_time' => Carbon::now(),
                            'order_count' => ($transporter_shift->total_order - TransporterShiftTiming::withTrashed()->where('transporter_shift_id',$transporter_shift->id)->sum('order_count'))
                        ]);

                        $Transporter->status = 'offline';
                        $Transporter->save();
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
                }
            }
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
        try {
            $Transporter = $request->user();
            $transporter_shift_time = TransporterShiftTiming::findOrFail($id);
            $transporter_shift_time->end_time = Carbon::now();
            $transporter_shift_time->save();

            $Transporter->status = 'online';
            $Transporter->save();

            $transporter_shift_time->delete();

            return TransporterShift::List($Transporter->id);
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
            $transporter_shift_time = TransporterShiftTiming::findOrFail($id);
            $transporter_shift_time->end_time = Carbon::now();
            $transporter_shift_time->save();

            $Transporter->status = 'online';
            $Transporter->save();

            $transporter_shift_time->delete();

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
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('form.whoops')], 500);
        }
    }
}
