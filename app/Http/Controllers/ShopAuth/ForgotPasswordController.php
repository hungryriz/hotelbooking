<?php

namespace App\Http\Controllers\ShopAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use DB;
use Log;
use Auth;
use Hash;
use Storage;
use Setting;
use Exception;
use Notification;

use Carbon\Carbon;
use App\Http\Controllers\SendPushNotification;
use App\Notifications\ResetPasswordOTP;
use App\Helpers\Helper;
use App\Shop;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('shop.guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('shop.auth.passwords.email');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('shops');
    }


     /**
     * Forgot Password.
     *
     * @return \Illuminate\Http\Response
     */


    public function forgot_password(Request $request) {

        $this->validate($request, [
                'email' => 'required|email|exists:shops,email',
            ]);

        try{  
            
            $user = \App\Shop::where('email' , $request->email)->first();
            $otp = mt_rand(100000, 999999);

            $user->otp = $otp;
            $user->save();
            $data['email'] = $user->email;
            $data['phone'] = $user->phone;
            $data['otp'] = $otp;
            $phone_number = substr(trim($data['phone']),3);
            $data['phonenumber'] = $phone_number;
            
            forgot_passwordmail_otp($data,'shop');
            //$msg_data = send_sms($data);
            //if($msg_data == 1) {
                return response()->json([
                    'message' => 'OTP Sent!',
                    'user' => $user
                ]);
            //}
            return response()->json(['error' => $msg_data], 422);

            /*return response()->json([
                'message' => 'OTP sent!',
                'user' => $user
            ]);*/

        }catch(Exception $e){
                return response()->json(['error' => $e->message()], 500);
        }
    }

     /**
     * Handle a OTP request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function CHECK_OTP(Request $request)
    {   
        //if($request->has('forgot')){
            $this->validate($request, [
                'email' => 'required|exists:shops,email',
                'otp' => 'required'
            ]); 
            
        /*}else{
            $this->validate($request, [
                'phone' => 'required|unique:users',
                'otp' => 'required'
            ]);  
        }*/
        try {
            $user = Shop::where('email','=',$request->email)->first();
            $data = $request->all();
            if($user->otp==$request->otp){
                return response()->json([
                    'message' => 'OTP match Successfully',
                    'user' => $user
                ]);
            }
            return response()->json(['error' => 'otp not match!'], 422);

        }catch (Exception $e) {
            return response()->json(['error' => trans('form.whoops')], 500);
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

}
