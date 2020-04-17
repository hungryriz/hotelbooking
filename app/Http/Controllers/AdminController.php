<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;
use Setting;
use App\ShopBanner;
use App\Order;
use Carbon\Carbon;
use App\OrderInvoice;
use App\Restuarant;
use App\newsletter;
use App\EnquiryTransporter;
use Lang;
use App\CustomPush;
use App\User;
use App\Transporter;
use App\UserAddress;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $Order = new Order;
        $RecentOrders = $Order->where('status','RECEIVED')->orderBy('id','Desc')->take(5)->get();
        $DeliveryOrders = $Order->where('status','COMPLETED')->orderBy('id','Desc')->take(4)->get();
        $OrderReceivedToday = $Order->where('status','RECEIVED')->where('created_at', '>=', Carbon::today())->count();
        $OrderDeliveredToday = $Order->where('status','COMPLETED')->where('created_at', '>=', Carbon::today())->count();
        $OrderIncomeToday = OrderInvoice::withTrashed()->with('orders')
                    ->whereHas('orders', function ($q) {
                        $q->where('orders.status', 'COMPLETED');
                        $q->where('created_at', '>=', Carbon::today());
                    })->sum('net');;
        $now = Carbon::now();
        $start = $now->startOfMonth();
        $end = $now->endOfMonth();
        $OrderIncomeMonthly = OrderInvoice::withTrashed()->with('orders')
                    ->whereHas('orders', function ($q) use ($start,$end) {
                          $now = Carbon::now();
                          $now1 = Carbon::now();
                          $q->where('orders.status', 'COMPLETED');
                          $q->whereBetween('created_at',[$now->startOfMonth(),$now1->endOfMonth()]);
                        //$q->where('created_at', '>=', Carbon::now()->month);
                    })->sum('net');;
                   
        
        $complete_cancel =   \DB::select("SELECT t.`month`,SUM(CASE WHEN t1.`status` = 'COMPLETED' THEN 1 ELSE 0 END) AS `delivered`, SUM(CASE WHEN t1.`status` = 'CANCELLED' THEN 1 ELSE 0 END) AS `cancelled` FROM (SELECT DATE_FORMAT(NOW(),'%Y-01') AS `month` UNION SELECT DATE_FORMAT(NOW(),'%Y-02') AS `month` UNION SELECT DATE_FORMAT(NOW(),'%Y-03') AS `month` UNION SELECT DATE_FORMAT(NOW(),'%Y-04') AS `month` UNION SELECT DATE_FORMAT(NOW(),'%Y-05') AS `month` UNION SELECT DATE_FORMAT(NOW(),'%Y-06') AS `month` UNION SELECT DATE_FORMAT(NOW(),'%Y-07') AS `month` UNION SELECT DATE_FORMAT(NOW(),'%Y-08') AS `month` UNION SELECT DATE_FORMAT(NOW(),'%Y-09') AS `month` UNION SELECT DATE_FORMAT(NOW(),'%Y-10') AS `month` UNION SELECT DATE_FORMAT(NOW(),'%Y-11') AS `month` UNION SELECT DATE_FORMAT(NOW(),'%Y-12') AS `month` ) AS t LEFT JOIN orders t1 on(t.`month` =DATE_FORMAT(t1.`created_at`,'%Y-%m')) group by t.`month` ");

        
        $Order=[];
        //return $complete_cancel;
        return view('admin.home',compact('RecentOrders','DeliveryOrders','OrderReceivedToday','OrderDeliveredToday','OrderIncomeMonthly','OrderIncomeToday','Order','complete_cancel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
     * settings details.
     *
     * @param  $data[]
     * @return \Illuminate\Http\Response
     */
    public function settings(Request $request)
    {   
        $lang_path = resource_path('lang');
        $listlang = array_diff(scandir($lang_path), array('..', '.'));
        return view('admin.settings',compact('listlang'));
    }

    public function settings_store(Request $request)
    {   
        $this->validate($request,[
                'site_logo' => 'mimes:jpeg,jpg,bmp,png||max:5242880',
            ]);
        try {
            $settings = $request->all();
            unset($settings['_token']);
            foreach ($settings as $key => $setting) {
                $temp_setting = Settings::where('key', $key)->first();
                if($temp_setting){
                     if($temp_setting->key == 'RIPPLE_BARCODE') {
                        if($request->file('RIPPLE_BARCODE') == null) {
                            $logo = $temp_setting->value;
                        } else {
                            if($temp_setting->value) {
                                remove_image($temp_setting->value);
                            }
                            $logo = upload_image($request->file('RIPPLE_BARCODE'));
                        }
                        $temp_setting->value = $logo;

                    }
                    elseif($temp_setting->key == 'ETHER_BARCODE') {
                        if($request->file('ETHER_BARCODE') == null) {
                            $logo = $temp_setting->value;
                        } else {
                            if($temp_setting->value) {
                                remove_image($temp_setting->value);
                            }
                            $logo = upload_image($request->file('ETHER_BARCODE'));
                        }
                        $temp_setting->value = $logo;

                    }
                    elseif($temp_setting->key == 'site_favicon') {
                        if($request->file('site_favicon') == null) {
                            $logo = $temp_setting->value;
                        } else {
                            if($temp_setting->value) {
                                remove_image($temp_setting->value);
                            }
                            $logo = upload_image($request->file('site_favicon'));
                        }
                        $temp_setting->value = $logo;

                    }elseif($temp_setting->key == 'site_logo') {

                        if($request->file('site_logo') == null) {
                            $logo = $temp_setting->value;
                        } else {
                            if($temp_setting->value) {
                                remove_image($temp_setting->value);
                            }
                            $logo = upload_image($request->file('site_logo'));
                        }
                        $temp_setting->value = $logo;
                    }elseif ($temp_setting->key == 'currency') {
                       $product_price = \App\ProductPrice::query();
                        $product_price->update(['currency'=>$request->$key]);
                         $temp_setting->value = $request->$key; 
                    }elseif ($temp_setting->key == 'client_secret') {  
                        $client_secret = \DB::table('oauth_clients')->find(2)->secret;
                        
                        $temp_setting->value = $client_secret; 
                    }elseif ($temp_setting->key == 'payment_mode') { 
                        $payment_mode = implode(',', $request->payment_mode);
                        $temp_setting->value = $payment_mode; 
                    } else {
                        $temp_setting->value = $request->$key;               
                    } 
                    $temp_setting->save();
                }else{
                    Setting::set($key,$setting);
                    Setting::save();
                }  
                       
            }   
            return back()->with('flash_success',trans('form.resource.updated'));
        } catch(Exception $e) {
            return back()->with('flash_success','form.whoops');
        }
        
    }
    public function manageBanner(Request $request)
     {   
        $BannerImage = ShopBanner::with('shop')->get();
        return $BannerImage = ShopBanner::with('shop')->where('status','active')->get();
     }

   /* public function account_setting(Request $request){
        return view('admin.acc_setting');
    }*/

    public function AccountSettingStore(Request $request)
    {   
        try{
             Setting::set($request->key,$request->value);
             Setting::save();
            return back()->with('flash_success',trans('form.resource.updated'));
        } catch(Exception $e) {
            return back()->with('flash_danger','form.whoops');
        }  
    }

    public function pages(Request $request){
        $this->validate($request, [
                'page' => 'required|in:privacy,terms,faq,help,about,contact,refund,otherterms,queries',
                'content' => 'required',
            ]);

        Setting::set($request->page, $request->content);
        Setting::save();

        return back()->with('flash_success', 'Content Updated!');
    }

    public function privacy(){
        return view('admin.pages.privacy')
            ->with('title',"Privacy Page")
            ->with('page', "privacy");
    }

    public function faq(){
        return view('admin.pages.faq')
            ->with('title',"FAQ")
            ->with('page', "faq");
    }
    public function terms(){
        return view('admin.pages.terms')
            ->with('title',"Terms and Condition")
            ->with('page', "terms");
    }

    public function help(){
        return view('admin.pages.help')
            ->with('title',"Help")
            ->with('page', "help");
    }

    public function refund(){
        return view('admin.pages.refund')
            ->with('title',"Refund")
            ->with('page', "refund");
    }

    public function otherterms(){
        return view('admin.pages.otherterms')
            ->with('title',"Other Terms")
            ->with('page', "otherterms");
    }

    public function queries(){
        return view('admin.pages.queries')
            ->with('title',"General Queries")
            ->with('page', "queries");
    }

    public function contact(){
        return view('admin.pages.contact')
            ->with('title',"Contact Us")
            ->with('page', "contact");
    }

    public function about(){
        return view('admin.pages.about')
            ->with('title',"About Us")
            ->with('page', "about");
    }


    public function restuarant_leads()
    { 
        $Restuarant = Restuarant::all();
        
        return view('admin.leads.restuarant',compact('Restuarant'));

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newsletter_leads()
    { 
          $Newsletter = newsletter::all();
          
          return view('admin.leads.newsletter',compact('Newsletter'));

    }

     public function enquiry_delivery()
    { 
          $enquiry_delivery = EnquiryTransporter::all();
          
          return view('admin.leads.enquiry_delivery',compact('enquiry_delivery'));

    }



     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function push(){

        try{
            $Pushes = CustomPush::orderBy('id','desc')->get();
            return view('admin.push',compact('Pushes'));
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }


    /**
     * pages.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function send_push(Request $request){

        $this->validate($request, [
                'send_to' => 'required|in:ALL,USERS,PROVIDERS',
                'user_condition' => 'required_if:send_to,USERS',
            'provider_condition' => 'required_if:send_to,PROVIDERS',
                'user_active' => ['required_if:user_condition,ACTIVE','in:HOUR,WEEK,MONTH'],
               'user_rides' => 'required_if:user_condition,RIDES',
               'user_location' => 'required_if:user_condition,LOCATION',
                'user_amount' => 'required_if:user_condition,AMOUNT',
               'provider_active' => ['required_if:provider_condition,ACTIVE','in:HOUR,WEEK,MONTH'],
               'provider_rides' => 'required_if:provider_condition,RIDES',
               'provider_location' => 'required_if:provider_condition,LOCATION',
               'provider_amount' => 'required_if:provider_condition,AMOUNT',
                'message' => 'required|max:100',
            ]);
       
        try{

            $CustomPush = new CustomPush;
            $CustomPush->send_to = $request->send_to;
            $CustomPush->message = $request->message;

            if($request->send_to == 'USERS'){

                $CustomPush->condition = $request->user_condition;

                if($request->user_condition == 'ACTIVE'){
                    $CustomPush->condition_data = $request->user_active;
                }elseif($request->user_condition == 'LOCATION'){
                    $CustomPush->condition_data = $request->user_location;
                }elseif($request->user_condition == 'RIDES'){
                    $CustomPush->condition_data = $request->user_rides;
                }elseif($request->user_condition == 'AMOUNT'){
                    $CustomPush->condition_data = $request->user_amount;
                }

            }elseif($request->send_to == 'PROVIDERS'){

                $CustomPush->condition = $request->provider_condition;

                if($request->provider_condition == 'ACTIVE'){
                    $CustomPush->condition_data = $request->provider_active;
                }elseif($request->provider_condition == 'LOCATION'){
                    $CustomPush->condition_data = $request->provider_location;
                }elseif($request->provider_condition == 'RIDES'){
                    $CustomPush->condition_data = $request->provider_rides;
                }elseif($request->provider_condition == 'AMOUNT'){
                    $CustomPush->condition_data = $request->provider_amount;
                }
            }

            if($request->has('schedule_date') && $request->has('schedule_time')){
                $CustomPush->schedule_at = date("Y-m-d H:i:s",strtotime("$request->schedule_date $request->schedule_time"));
            }

            $CustomPush->save();

            if($CustomPush->schedule_at == ''){
                $this->SendCustomPush($CustomPush->id);
            }

            return back()->with('flash_success', 'Message Sent to all '.$request->segment);
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }


    public function SendCustomPush($CustomPush){

        try{

            \Log::notice("Starting Custom Push");

            $Push = CustomPush::findOrFail($CustomPush);

            if($Push->send_to == 'USERS'){

                $Users = [];

                if($Push->condition == 'ACTIVE'){

                    if($Push->condition_data == 'HOUR'){

                        $Users = User::whereHas('orders', function($query) {
                            $query->where('created_at','>=',Carbon::now()->subHour());
                        })->get();
                        
                    }elseif($Push->condition_data == 'WEEK'){

                        $Users = User::whereHas('orders', function($query){
                            $query->where('created_at','>=',Carbon::now()->subWeek());
                        })->get();

                    }elseif($Push->condition_data == 'MONTH'){

                        $Users = User::whereHas('orders', function($query){
                            $query->where('created_at','>=',Carbon::now()->subMonth());
                        })->get();

                    }

                }elseif($Push->condition == 'RIDES'){

                    $Users = User::whereHas('orders', function($query) use ($Push){
                                $query->where('status','COMPLETED');
                                $query->groupBy('id');
                                $query->havingRaw('COUNT(*) >= '.$Push->condition_data);
                            })->get();


                }elseif($Push->condition == 'LOCATION'){

                    $Location = explode(',', $Push->condition_data);

                    $distance = Setting::get('provider_search_radius', '10');
                    $latitude = $Location[0];
                    $longitude = $Location[1];

                    $Users = UserAddress::whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                            ->get();

                }


                foreach ($Users as $key => $user) {
                    (new SendPushNotification)->sendPushToUser($user->user_id, $Push->message);
                }

            }elseif($Push->send_to == 'PROVIDERS'){


                $Providers = [];

                if($Push->condition == 'ACTIVE'){

                    if($Push->condition_data == 'HOUR'){

                        $Providers = Transporter::whereHas('orders', function($query){
                            $query->where('created_at','>=',Carbon::now()->subHour());
                        })->get();
                        
                    }elseif($Push->condition_data == 'WEEK'){

                        $Providers = Transporter::whereHas('orders', function($query){
                            $query->where('created_at','>=',Carbon::now()->subWeek());
                        })->get();

                    }elseif($Push->condition_data == 'MONTH'){

                        $Providers = Transporter::whereHas('orders', function($query){
                            $query->where('created_at','>=',Carbon::now()->subMonth());
                        })->get();

                    }

                }elseif($Push->condition == 'RIDES'){

                    $Providers = Transporter::whereHas('orders', function($query) use ($Push){
                               $query->where('status','COMPLETED');
                                $query->groupBy('id');
                                $query->havingRaw('COUNT(*) >= '.$Push->condition_data);
                            })->get();

                }elseif($Push->condition == 'LOCATION'){

                    $Location = explode(',', $Push->condition_data);

                    $distance = Setting::get('provider_search_radius', '10');
                    $latitude = $Location[0];
                    $longitude = $Location[1];

                    $Providers = Transporter::whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                            ->get();

                }


                foreach ($Providers as $key => $provider) {
                    (new SendPushNotification)->sendPushToProvider($provider->id, $Push->message);
                }

            }elseif($Push->send_to == 'ALL'){

                $Users = User::all();
                foreach ($Users as $key => $user) {
                    (new SendPushNotification)->sendPushToUser($user->id, $Push->message);
                }

                $Providers = Transporter::all();
                foreach ($Providers as $key => $provider) {
                    (new SendPushNotification)->sendPushToProvider($provider->id, $Push->message);
                }

            }
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

}
