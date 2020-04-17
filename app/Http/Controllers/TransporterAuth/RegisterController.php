<?php

namespace App\Http\Controllers\TransporterAuth;

use Auth;
use App\Transporter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Hash;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/transporter/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('transporter.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:transporters',
            'phone' => 'required|unique:transporters',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Transporter
     */
    protected function create(array $data)
    {
        return Transporter::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('transporter.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('transporter');
    }

    /**
     * Handle registration send otp  request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function OTP(Request $request){

        $this->validator($request->all(), [
            'phone' => 'required|unique:transporters'
        ]);
        try {
            $data=$request->all();
            if(Transporter::where('phone',$data['phone'])->first()){
                return response()->json([
                    'phone' => 'this mobile is already exist!',
                                
                    ]);
             }

            $newotp=rand(100000,999999);
            $data['otp'] = $newotp;
            $msg_data=send_sms($data);

            if($msg_data == null)
                return response()->json([
                    'message' => 'Otp sent to your mobile successfully ',
                    'otp' => $newotp
                    ]); 

                return response()->json(['error' => $msg_data], 422);
        } catch (Exception $e){
                return $e->getMessage();
        }
    }
}
