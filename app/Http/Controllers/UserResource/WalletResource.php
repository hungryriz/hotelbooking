<?php

namespace App\Http\Controllers\UserResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Auth;
use Exception;

use App\Zone;
use App\Promocode;
use App\UserAddress;
use App\PromocodeUsage;
use App\WalletPassbook;
use Carbon\Carbon;
class WalletResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user()->wallet;
    }

    public function promocode(Request $request)
    {
        $promo = PromocodeUsage::where('user_id', $request->user()->id)->pluck('promocode_id');
        return Promocode::whereNotIn('id', $promo)->where('status', 'ADDED')->where('expiration','>=', Carbon::today())->get();
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
            'promocode_id' => 'exists:promocodes,id',
            'couponcode' => 'exists:promocodes,promo_code',
        ]);

        try{

            if($request->promocode_id=='') 
            $find_promo = Promocode::where('promo_code',$request->couponcode)->first();
            else
            $find_promo = Promocode::find($request->promocode_id);

            if($find_promo->status == 'EXPIRED' || (date("Y-m-d") > $find_promo->expiration)){

                if($request->ajax()){

                    return response()->json(['error' => trans('form.promocode.expired')], 422);
                } else {
                    return back()->with('flash_error', trans('form.promocode.expired'));
                }

            } elseif(PromocodeUsage::where('promocode_id', $find_promo->id)->where('user_id', $request->user()->id)->whereIN('status',['ADDED','USED'])->count() > 0){

                if($request->ajax()){

                    return response()->json(['error' => trans('form.promocode.already_in_use')], 422);

                }else{
                    return back()->with('flash_error', trans('form.promocode.already_in_use'));
                }

            } else {
                $request->user()->wallet_balance += Promocode::find($find_promo->id)->discount;
                $request->user()->save();

                WalletPassbook::create([
                    'user_id' => $request->user()->id,
                    'amount'  => Promocode::find($find_promo->id)->discount,
                    'status' => 'CREDITED',
                    'message' => trans('form.promocode.message',['promocode' => $find_promo->promo_code])
                ]);

                PromocodeUsage::create([
                    'user_id' => $request->user()->id,
                    'promocode_id' => $find_promo->id,
                    'status' => 'USED',
                ]);

                return ['wallet_balance' => $request->user()->wallet_balance];

                if($request->ajax()){

                    return response()->json([
                        'message' => trans('form.promocode.applied')
                    ]); 

                } else {
                    return back()->with('flash_success', trans('form.promocode.applied'));
                }
            }

        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')], 500);
            }else{
                return back()->with('flash_error', trans('form.whoops'));
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
    public function destroy($id)
    {
        //
    }
}
