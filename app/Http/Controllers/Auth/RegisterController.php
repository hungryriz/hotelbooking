<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\CommonController;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Twilio;
use Session;
use App\Http\Controllers\SocialLoginController;
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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   
        if(isset($data['login_by'])){
            return Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|unique:users|min:6',
                'accessToken'=>'required',
                'login_by' => 'required|in:manual,facebook,google'
            ]);
        }else{
            return Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|unique:users|min:6',
                'password' => 'required|string|min:6|confirmed',
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {   
        $social_data = [];
        if(isset($data['login_by'])){
            $social_data = (new SocialLoginController)->getSocialId($data);
        }
        $User = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => isset($data['password'])?bcrypt($data['password']):bcrypt('123456'),
            'login_by' => isset($data['login_by'])?$data['login_by']:'manual',
            'social_unique_id' => isset($data['accessToken'])?@$social_data->id:''
        ]);
        
        /*if(isset($data['login_by'])){
            $userToken = $User->createToken('socialLogin');
                return response()->json([
                    "status" => true,
                    "token_type" => "Bearer",
                    "access_token" => $userToken->accessToken
                ]);
        }else{*/
            return $User;
        //}
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('user.auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apiregister(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $user;
    }

    /**
     * Handle a OTP request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function OTP(Request $request)
    {   
        if($request->has('login_by')){
            $this->validate($request, [
                'phone' => 'required|unique:users|min:6',
                'login_by' => 'required',
                'accessToken' => 'required'
            ]);  
        }else{
            $this->validate($request, [
                'phone' => 'required|unique:users|min:6'
            ]); 

        }  
        try {
            $data = $request->all();
            if($request->has('login_by')){
                $social_data = (new SocialLoginController)->checkSocialLogin($request);
                //dd($social_data);
                if($social_data){
                    return response()->json([
                    'error' => trans('form.socialuser_exist'),
                ], 422); 
                }
            }
            elseif(User::where('phone',$data['phone'])->first()){
                return response()->json([
                    'error' => trans('form.mobile_exist'),
                ], 422); 
            }
            $newotp = 888555;//rand(100000,999999);
            $data['otp'] = $newotp;
            //$msg_data = send_sms($data);

            //if($msg_data == null){
                return response()->json([
                    'message' => 'OTP Sent',
                    'otp' => $newotp
                ]);
            //} 
            return response()->json(['error' => $msg_data], 422);
            
        } catch (Exception $e) {
            return response()->json(['error' => trans('form.whoops')], 500);
        }
    }
}
