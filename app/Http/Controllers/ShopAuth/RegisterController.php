<?php

namespace App\Http\Controllers\ShopAuth;

use App\Shop;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Http\Controller\Resource\ShopResource;
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
    protected $redirectTo = '/shop/home';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:shops',
            'phone' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',
            'cuisine_id' => 'required|array',
            'day' => 'required|array',
            'phone' => 'required|numeric',
            'password' => 'required|string|min:6|confirmed',
            'maps_address' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'avatar' => 'required|image|max:2120'
        ]);


    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Shop
     */
    protected function create(array $data)
    {
        /*return Shop::create([
            'name' => $data['name'],
            //'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);*/
        $Shop = $data;
            if($data['avatar']) {
                $Shop['avatar'] = asset('storage/'.$data['avatar']->store('shops'));
            }
            if(@$data['default_banner']) {
                $Shop['default_banner'] = asset('storage/'.$data['default_banner']->store('shops'));
            }
            
           
            $Shop['password'] = bcrypt($Shop['password']);
            $Shop = \App\Shop::create($Shop);
            
            //Cuisine
            if($data['cuisine_id']) {
                foreach($data['cuisine_id'] as $cuisine){
                    $Shop->cuisines()->attach($cuisine);
                }
            }

            //ShopTimings
            if($data['day']) {
                $start_time = $data['hours_opening'];
                $end_time = $data['hours_closing'];
                foreach($data['day'] as $key => $day) 
                {  
                    $timing[] = [
                        'start_time' => $start_time[$day],
                        'end_time' => $end_time[$day],
                        'shop_id' => $Shop->id,
                        'day' => $day
                    ];
                }
                \App\ShopTiming::insert($timing); 
            }

            return $Shop;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('shop.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('shop');
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
        //event(new ShopResource)->store());

        $data = $this->guard('shop')->login($user);

        return $user;
    }

}
