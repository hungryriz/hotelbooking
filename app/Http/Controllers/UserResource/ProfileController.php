<?php

namespace App\Http\Controllers\UserResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Setting;
use Hash;
use App\User;
use App\Notification;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $User = $request->user();

        if($request->has('device_type')){
            $User->device_type = $request->device_type;
        }
        if($request->has('device_token')){
            $User->device_token = $request->device_token;
        }
        if($request->has('device_id')){
            $User->device_id = $request->device_id;
        }
        $User->save();
        $User = $request->user()->profile($User->id);
        $User->currency = Setting::get('currency');
        $User->payment_mode = explode(',',Setting::get('payment_mode'));
        if($request->ajax()){
            return $User;
        }
        return view('user.profile');
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
       /* $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'avatar' => 'image|max:2120',
            ]);*/
        try{
            $msg = trans('form.resource.updated');
            $User = $request->user();
            if($request->has('name')){
            $User->name = $request->name;
            }
            if($request->has('email')){
            $User->email = $request->email;
            }
            if($request->has('phone')){
            $User->phone = $request->phone;
            }
            if($request->has('password')){
             $User->password = bcrypt($request->password);
             $msg = trans('form.profile.updated');
            }
            
            if($request->hasFile('avatar')) {
                $User->avatar = asset('storage/'.$request->avatar->store('user/profile'));
            }
            $User->save();
            if($request->ajax()){
                return $User;
            }
             return back()->with('flash_success',$msg);
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')], 500);
            }
            return back()->with('flash_failure',trans('form.whoops'));
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

        $User = $request->user();

        if(Hash::check($request->password_old, $User->password))
        {
            $User->password = bcrypt($request->password);
            $User->save();

            if($request->ajax()) {
                return response()->json(['message' => trans('Password Updated')]);
            } else {
                return back()->with('flash_success', 'Password Updated');
            }

        } else {
            if($request->ajax()) {
                return response()->json(['error' => trans('Incorrect Password')], 500);
            }
            return back()->with('flash_failure', 'Incorrect Password');
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
    {
        try {
            User::where('id', $request->user()->id)->update(['device_id'=> '', 'device_token' => '']);
            return response()->json(['message' => trans('form.logout_success')]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('form.whoops')], 500);
        }
    }

    public function notifications(Request $request){
        return Notification::where('user_id',$request->user()->id)->orderBy('id','DESC')->get();
    }

    public function changepassword(Request $request){
        return view('user.auth.change_password');
    }
}
