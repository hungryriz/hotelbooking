<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

use Socialite;
use Setting;
use Exception;
use Validator;
use App\User;
use App\Transpoter;
use Redirect;

class SocialLoginController extends Controller
{
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }


    public function checkSocialLogin(Request $request){

        if($request->has('login_by')){
            if($request->login_by=='facebook'){
                $driver = 'facebook';
            }else{
                $driver = 'google';
            }
            $user = Socialite::driver($driver)->stateless();
            $SocialDrive = $user->userFromToken( $request->accessToken);
            $SocialSql = User::where('social_unique_id',$SocialDrive->id);
            /*if($FacebookDrive->email !=""){
                $FacebookSql->orWhere('email',$FacebookDrive->email);
            }*/
            return $AuthUser = $SocialSql->first();

        }

    }

    public function getSocialId($data){
            if($data['login_by']=='facebook'){
                $driver = 'facebook';
            }else{
                $driver = 'google';
            }
            $user = Socialite::driver($driver)->stateless();
            $SocialDrive = $user->userFromToken( $data['accessToken']);
            return $SocialDrive;
    }

    public function loginWithSocial(Request $request){
           $login_user = $this->checkSocialLogin($request);
          // dd($login_user);
            if($login_user){
               $userToken = $login_user->createToken('socialLogin')->accessToken;
                if($request->ajax()){
                    if($request->login_type){
                         return Auth::guard()->loginUsingId($login_user->id);
                    }else{
                        return response()->json([
                            "status" => true,
                            "token_type" => "Bearer",
                            "access_token" => $userToken
                        ]);
                    }
                }
           }else{
                if($request->ajax()){
                    return response()->json(['error' => trans('form.socialuser_notexist')],422);
                }
           }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function facebookViaAPI(Request $request) { 

        $user = Socialite::driver('facebook')->stateless();
        $FacebookDrive = $user->userFromToken( $request->accessToken);
       
        try{

        	$FacebookSql = User::where('social_unique_id',$FacebookDrive->id);
            if($FacebookDrive->email !=""){
                $FacebookSql->orWhere('email',$FacebookDrive->email);
            }
            $AuthUser = $FacebookSql->first();
            if($AuthUser){
                $AuthUser->social_unique_id=$FacebookDrive->id; 
            	$AuthUser->device_type=$request->device_type;
                $AuthUser->device_token=$request->device_token;
                $AuthUser->device_id=$request->device_id;
                $AuthUser->login_by="facebook";
                $AuthUser->save();  
            }else{   
                $AuthUser=new User();
                $AuthUser->email=$FacebookDrive->email;
               // $name = explode(' ', $FacebookDrive->name, 2);
                $AuthUser->name=$FacebookDrive->name;
                //$AuthUser->last_name= isset($name[1]) ? $name[1] : '';
                $AuthUser->password=bcrypt($FacebookDrive->id);
                $AuthUser->social_unique_id=$FacebookDrive->id;
                $AuthUser->device_type=$request->device_type;
                $AuthUser->device_token=$request->device_token;
                $AuthUser->device_id=$request->device_id;
                $AuthUser->phone=$request->phone;
                $AuthUser->avatar=$FacebookDrive->avatar;
                $AuthUser->login_by="facebook";
                $AuthUser->save();
            }    
            if($AuthUser){
                $userToken = $AuthUser->token()?:$AuthUser->createToken('socialLogin');
                return response()->json([
                        "status" => true,
                        "token_type" => "Bearer",
                        "access_token" => $userToken->accessToken
                        ]);
            }else{
                return response()->json(['status'=>false,'message' => "Invalid credentials!"]);
            }  
        } catch (Exception $e) {
            return response()->json(['status'=>false,'message' => trans('api.something_went_wrong')]);
        }
    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function providerToGoogle(){
        return Socialite::driver('google')->with(['state' => 'provider'])->redirect();
    }

    public function handleGoogleCallback(){
        try{
            $google = Socialite::driver('google')->user();
            if($google){
                $guard = request()->input('state');
                if($guard == 'provider') {
                    if($google->id){
                        $GoogleSql = Provider::where('social_unique_id',$google->id);
                        if($google->email !=""){
                            $GoogleSql->orWhere('email',$google->email);
                        }
                        $AuthUser = $GoogleSql->first();
                        if($AuthUser){ 
                            $AuthUser->social_unique_id=$google->id;
                            $AuthUser->save();  
                            Auth::guard('provider')->loginUsingId($AuthUser->id);
                            return redirect()->to('provider');
                        }else{   
                            $new=new Provider();
                            $new->email=$google->email;
                            $name = explode(' ', $google->name, 2);
                            $new->first_name=$name[0];
                            $new->last_name= isset($name[1]) ? $name[1] : '';
                            $new->password=bcrypt($google->id);
                            $new->social_unique_id=$google->id;
                            //$new->mobile=$google->mobile;
                            $new->avatar=$google->avatar;
                            $new->login_by="google";
                            $new->save();

                            if(Setting::get('demo_mode', 0) == 1) {
                                $new->update(['status' => 'approved']);
                                ProviderService::create([
                                    'provider_id' => $new->id,
                                    'service_type_id' => '1',
                                    'status' => 'active',
                                    'service_number' => '4pp03ets',
                                    'service_model' => 'Audi R8',
                                ]);
                            }
                            Auth::guard('provider')->loginUsingId($new->id);
                            return redirect()->route('provider');
                        }
                    }else{
                        return redirect()->route('provider');
                    }
                } else {
                    if($google->id){
                        $GoogleSql = User::where('social_unique_id',$google->id);
                        if($google->email !=""){
                            $GoogleSql->orWhere('email',$google->email);
                        }
                        $AuthUser = $GoogleSql->first();
                        if($AuthUser){ 
                            $AuthUser->social_unique_id=$google->id;
                            $AuthUser->save();  
                            Auth::loginUsingId($AuthUser->id);
                            return redirect()->to('dashboard');
                        }else{   
                            $new=new User();
                            $new->email=$google->email;
                            $name = explode(' ', $google->name, 2);
                            $new->first_name=$name[0];
                            $new->last_name= isset($name[1]) ? $name[1] : '';
                            $new->password=bcrypt($google->id);
                            $new->social_unique_id=$google->id;
                            //$new->mobile=$google->mobile;
                            $new->picture=$google->avatar;
                            $new->login_by="google";
                            $new->save();
                            Auth::loginUsingId($new->id);
                            return redirect()->route('dashboard');
                        }
                    }else{
                        return redirect()->route('dashboard');
                    }
                }
            }else{
               return redirect()->url('register');
            }

        } catch (Exception $e) {
            return back()->with('flash_errors', 'Google driver not found');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function googleViaAPI(Request $request) { 

        $user = Socialite::driver('google')->stateless();
        $GoogleDrive = $user->userFromToken( $request->accessToken);
        //try{
            $GoogleSql = User::where('social_unique_id',$GoogleDrive->id);
            if($GoogleDrive->email !=""){
                $GoogleSql->orWhere('email',$GoogleDrive->email);
            }
            $AuthUser = $GoogleSql->first();
            if($AuthUser){
                $AuthUser->social_unique_id=$GoogleDrive->id; 
              	$AuthUser->device_type=$request->device_type;
                $AuthUser->device_token=$request->device_token;
                $AuthUser->device_id=$request->device_id;
                $AuthUser->login_by="google";
                $AuthUser->save();
            }else{   
                $AuthUser=new User();
                $AuthUser->email=$GoogleDrive->email;
                $AuthUser->name=$GoogleDrive->name;
                $AuthUser->password=bcrypt($GoogleDrive->id);
                $AuthUser->social_unique_id=$GoogleDrive->id;
                $AuthUser->device_type=$request->device_type;
                $AuthUser->device_token=$request->device_token;
                $AuthUser->device_id=$request->device_id;
                $AuthUser->phone=$request->phone;
                $AuthUser->avatar=$GoogleDrive->avatar;
                $AuthUser->login_by="google";
                $AuthUser->save();
            }    
            if($AuthUser){     
                $userToken = $AuthUser->token()?:$AuthUser->createToken('socialLogin');
                return response()->json([
                        "status" => true,
                        "token_type" => "Bearer",
                        "access_token" => $userToken->accessToken
                        ]);
            }else{
                return response()->json(['status'=>false,'message' => "Invalid credentials!"]);
            }  
        /*} catch (Exception $e) {
            return response()->json(['status'=>false,'message' => trans('api.something_went_wrong')]);
        }*/
    }


    public function account_kit(Request $request){

        // Initialize variables
        $app_id = env('FB_APP_ID');
        $secret = env('FB_APP_SECRET');
        $version = env('FB_APP_VERSION'); // 'v1.1' for example

        // Method to send Get request to url
        function doCurl($url) {
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $data = json_decode(curl_exec($ch), true);
          curl_close($ch);
          return $data;
        }

        // Exchange authorization code for access token
        $token_exchange_url = 'https://graph.accountkit.com/'.$version.'/access_token?'.
          'grant_type=authorization_code'.
          '&code='.$request->code.
          "&access_token=AA|$app_id|$secret";

        $data = doCurl($token_exchange_url);
        $user_id = $data['id'];
        $user_access_token = $data['access_token'];
        $refresh_interval = $data['token_refresh_interval_sec'];

        // Get Account Kit information
        $me_endpoint_url = 'https://graph.accountkit.com/'.$version.'/me?'.
          'access_token='.$user_access_token;
        $data = doCurl($me_endpoint_url);

        return $data;

    }

}
