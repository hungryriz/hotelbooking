<?php

namespace App\Http\Controllers\TransporterResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\TransporterVehicle;
use App\TransporterShift;
use App\Transporter;
use Setting;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $Transporter = $request->user();

        if($request->has('device_type')) {
            $Transporter->device_type = $request->device_type;
        }
        if($request->has('device_token')) {
            $Transporter->device_token = $request->device_token;
        }
        if($request->has('device_id')) {
            $Transporter->device_id = $request->device_id;
        }
        $Transporter->save();
        $Transporter->currency = Setting::get('currency');
        $Transporter->currency_code = Setting::get('currency_code');
        $Transporter->payment_mode = Setting::get('payment_mode');
        return $Transporter;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'avatar' => 'image|max:2120'//2mb
            ]);
        try{
            $Transporter = $request->user();
            $Transporter->name = $request->name;
            $Transporter->email = $request->email;
            if($request->hasFile('avatar')) {
                $Transporter->avatar = asset('storage/'.$request->avatar->store('transporter/profile'));
            }
            $Transporter->save();
            return $Transporter;
        } catch (Exception $e) {
            return response()->json(['error' => trans('form.whoops')], 500);
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

        $Transporter = $request->user();
        $Transporter->update($request->all());

        return $Transporter;
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

        $Transporter = $request->transporter();

        if(Hash::check($request->password_old, $Transporter->password))
        {
            $Transporter->password = bcrypt($request->password);
            $Transporter->save();

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

    public function logout(Request $request)
    {//dd($request->user()->id);
        try {
            Transporter::where('id', $request->user()->id)->update(['device_id'=> '', 'device_token' => '']);
            return response()->json(['message' => trans('form.logout_success')]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('form.whoops')], 500);
        }
    }    
}
