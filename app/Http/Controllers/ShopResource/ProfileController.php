<?php

namespace App\Http\Controllers\ShopResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Route;
use Exception;
use GuzzleHttp\Client;
use App\ShopTiming;
use App\Shop;
use Setting;
use Auth;
use App\ShopImage;
use Hash;
class ProfileController extends Controller
{
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $Days = [
            'ALL' => 'Everyday',
            'SUN' => 'Sunday',
            'MON' => 'Monday',
            'TUE' => 'Tuesday',
            'WED' => 'Wednesday',
            'THU' => 'Thursday',
            'FRI' => 'Friday',
            'SAT' => 'Saturday'
        ];
        try {
            $Shop = Shop::with('cuisines','timings')->findOrFail($request->user()->id);
            if($request->has('device_token')){
                $Shop->device_token = $request->device_token;
            }
            if($request->has('device_id')){
                $Shop->device_id = $request->device_id;
            }
            if($request->has('device_type')){
                $Shop->device_type = $request->device_type;
            }
            $Shop->save();
            if($request->ajax()){
                $Shop->currency = Setting::get('currency');
                return $Shop;
            }
            return view('shop.shops.edit', compact('Shop','Days'));
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.shops.index')->with('flash_error', 'Shop not found!');
            return back()->with('flash_error', 'Shop not found!');
        } catch (Exception $e) {
            // return redirect()->route('admin.shops.index')->with('flash_error', trans('form.whoops'));
            return back()->with('flash_error', trans('form.whoops'));
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

        if($request->ajax()){
            if($request->day){

                $this->validate($request, [
                    
                    'day' => 'required|array'
                ]);

            }else{

                $this->validate($request, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255',
                    'phone' => 'required|string|max:255',
                    'cuisine_id' => 'required|array',
                    //'day' => 'required|array',
                    'latitude' => 'required|string|max:255',
                    'longitude' => 'required|string|max:255',
                    'phone' => 'required|numeric',
                    'maps_address' => 'required|string|max:255',
                    'address' => 'required|string|max:255',
                    'avatar' => 'mimes:jpeg,jpg,png | max:1000'
                ]);

            }




        }else{


        $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone' => 'required|string|max:255',
                'cuisine_id' => 'required|array',
                'day' => 'required|array',
                'latitude' => 'required|string|max:255',
                'longitude' => 'required|string|max:255',
                'phone' => 'required|numeric',
                'maps_address' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'avatar' => 'image|max:5120',
            ]);
        }

        try {
            $Shop = Shop::with('cuisines','timings')->findOrFail($id);
            $Update = $request->all();
            if($request->hasFile('avatar')) {
                $Update['avatar'] = asset('storage/'.$request->avatar->store('shops'));
            } else {
                unset($Update['avatar']);
            }
            if($request->hasFile('default_banner')) {
                $Update['default_banner'] = asset('storage/'.$request->default_banner->store('shops'));
            } else {
                unset($Update['default_banner']);
            }
            if($request->has('password')) {
                $Update['password'] = bcrypt($request->password);
            } else {
                unset($Update['password']);
            }
            if($request->has('pure_veg')) {
                $Update['pure_veg'] = $request->pure_veg == 'no'?0:1;
            }
            if($request->has('popular')) {
                $Update['popular'] = $request->popular == 'no'?0:1;
            }
            
            $Shop->update($Update);

            if($request->has('cuisine_id')) {
                //Cuisine
                $Shop->cuisines()->detach();
                if(count($request->cuisine_id)>0) {
                    foreach($request->cuisine_id as $cuisionk){
                        $Shop->cuisines()->attach($cuisionk);
                    }
                }
            }
            //ShopTimings
            if($request->has('day')) {
                $start_time = $request->hours_opening;
                $end_time = $request->hours_closing;
                ShopTiming::where('shop_id',$id)->delete();
                foreach($request->day as $key => $day) 
                {  
                    $timing[] = [
                        'start_time' => $start_time[$day],
                        'end_time' => $end_time[$day],
                        'shop_id' => $Shop->id,
                        'day' => $day
                        ];
                }
                ShopTiming::insert($timing);   
            }
            if($request->ajax()){
                $Shop = Shop::with('cuisines','timings')->findOrFail($id);
                return $Shop;
            }
            return back()->with('flash_success', trans('form.resource.updated'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.not_found'));
        } catch (Exception $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request)
    {
        $this->validate($request, [
                'password' => 'required|confirmed|min:6',
                'password_old' => 'required',
            ]);

        $Shop = $request->user();

        if(Hash::check($request->password_old, $Shop->password))
        {
            $Shop->password = bcrypt($request->password);
            $Shop->save();

            if($request->ajax()) {
                return response()->json(['message' => trans('api.user.password_updated')]);
            } else {
                return back()->with('flash_success', 'Password Updated');
            }

        } else {
            return response()->json(['error' => trans('api.user.incorrect_password')], 500);
        }
    }

     /**
     * Update the location of Transporter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function location(Request $request)
    {
        $this->validate($request, [
                'latitude' => 'required|string|max:255',
                'longitude' => 'required|string|max:255',
            ]);

        $Shop = $request->user();
        $Shop->update($request->all());

        return $Shop;
    }

    public function logout(Request $request)
    {//dd($request->user()->id);
        try {
            Shop::where('id', $request->user()->id)->update(['device_id'=> '', 'device_token' => '']);
            return response()->json(['message' => trans('form.logout_success')]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('form.whoops')], 500);
        }
    }    
}
