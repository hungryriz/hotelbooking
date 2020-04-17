<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\User;
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
        $this->middleware('guest');
    }


     /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('user.auth.passwords.email');
    }
    /**
     * Forgot Password.
     *
     * @return \Illuminate\Http\Response
     */


    public function forgot_password(Request $request) {

        $this->validate($request, [
            'phone' => 'required|exists:users,phone',
        ]);

        try {
            $user = User::where('phone' , $request->phone)->first();

            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->save();

            //Notification::send($user, new ResetPasswordOTP($otp));
            $data['phone'] = $request->phone;
            $data['otp'] = $otp;
            $msg_data = send_sms($data);

            if($msg_data == null) {
                return response()->json([
                    'message' => 'OTP Sent!',
                    'user' => $user
                ]);
            }
            return response()->json(['error' => $msg_data], 422);
        } catch(Exception $e) {
            return response()->json([
                'error' => trans('form.whoops')
            ], 500);
        }
    }
}
