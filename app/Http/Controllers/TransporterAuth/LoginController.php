<?php

namespace App\Http\Controllers\TransporterAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;
use App\Transporter;
use Hash;
use Session;
use Redirect;
use Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/transporter/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('transporter.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('transporter.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('transporter');
    }

    public function username()
    {         
            return 'phone';  
    }
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username()); 
    }

     /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required'
        ]);
    }

    /**
     * Handle Send OTP for login of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        try {
            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            $field = 'phone';
            $phone = $request->phone;
                       
            if($user = Transporter::where('phone',$phone)->first()) {

                if ($user->phone == $phone) {

                    $newotp = '123456';//rand(100000,999999);
                    
                    $user->otp = Hash::make($newotp);
                    $user->save();
                    Session::put('phone',$user->phone);
                    $sms_data['phone'] = $user->phone;
                    $sms_data['otp'] = $newotp;
                    //$msg_data=send_sms($sms_data);   
                    if($request->ajax()) {
                        //if($msg_data == null) {
                            return response()->json(['message' => 'OTP Sent','otp' => $newotp]);
                       // }
                       // return response()->json(['error' => $msg_data], 422);
                    } else {
                      //  if($msg_data == null) {
                            return Redirect::to('transporter/otplogin');
                        //}
                        //return back()->with('flash_error',$msg_data);
                    }
                }  
            }

            return $this->sendFailedLoginResponse($request);

        } catch(Exception $e) {
            return $e->getMessage();
        }

    }

     /**
     * Show the application otppage.
     *
     * @return \Illuminate\Http\Response
     */
     public function OtpLogin(Request $request)
    { 
        if(Session::get('phone')) {
            return view('transporter.auth.login_otp');
        }
        return Redirect::to('transporter/login');
    }

    /**
     * Show the application resend otp .
     *
     * @return \Illuminate\Http\Response
     */
     public function ResendOtp(Request $request)
    { 
        try{
            $phone = Session::get('phone');
            $newotp = rand(100000,999999);
            $user = User::where('phone',$phone)->firstOrFail();
            $user->otp = Hash::make($newotp);
            $user->save();
            $sms_data['phone'] = $user->phone;
            $sms_data['otp'] = $newotp;
            $msg_data = send_sms($user);

            if($request->ajax()) {
                if($msg_data == null){
                    return response()->json(['message' => 'Otp send to your mobile successfully ','otp'=>$newotp]);
                } else {     
                    return response()->json(['error' => $msg_data], 500);  
                }
            } else {
                if($msg_data==null){
                    return back()->with('flash_success','OTP send your mobile please check! ');
                }else{                                             
                    return back()->with('flash_error', $msg_data);
                }
            }
                  
        } catch(Exception $e) {
            return $e->getMessage();
        }    
    
    }
    /**
     * Handle Match the Otp and login of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */

    public function UserLogin(Request $request)
    { // dd('ddhddh');
        $validator = Validator::make($request->all(),[
            'otp' => 'required',
            'phone' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        try{

            $phone = $request->ajax()?$request->phone:Session::get('phone');

            $transporter = Transporter::where('phone',$phone)->firstOrFail();
          //  dd($transporter->phone);
            if(Hash::check($request->otp, $transporter->otp)){
                $transporter->otp = '0';
                $transporter->save();

                if($request->ajax()){
                    $token = $transporter->createToken($transporter->id.'transporter')->accessToken;
                    $refresh_token = $transporter->refreshToken;
                    $data=[
                        'token_type' => 'Bearer',
                        'access_token' => $token ,
                        'refresh_token' => $refresh_token
                    ];
                    return $data;
                }
                if (Auth::guard('transporter')->loginUsingId($transporter->id)){
                        return Redirect::to('transporter/home');
                }
                
            } else {

                if($request->ajax()){
                    return response()->json(['error' => 'Invalid OTP Entered! or Phone No.'], 500);
                }
                return back()->with('flash_error','Invalid OTP Entered!');
            }
        }catch(ModelNotFoundException $e){
              return $e->getMessage();
        }

     }

}
