<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\EnquiryTransporter;
use App\User;
use App\Order;
use App\newsletter;
use Session;
use App\Http\Controllers\Resource\ShopResource;
class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {   

        
        
        $Shop = Shop::take(4)->get();
        $shop_total = Shop::count();
        $user_total = User::count();
        $order_total = Order::where('status','COMPLETED')->count();
        //dd($Shop);
        return view('welcome',compact('Shop','shop_total','user_total','order_total'));
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function faq(Request $request)
    {   
        if($request->ajax()){
            $static = 1;
        }
       return view('faq',compact('static'));
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutus()
    {   
       return view('aboutus');
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function termcondition(Request $request)
    {   
        $static = 0;
        if($request->has('static')){
            $static = 1;
        }
       return view('term_condition',compact('static'));
    }

    public function newsletter(Request $request)
    {  

        
             $this->validate($request, [
               
                'email_newsletter_2' => 'required|email',
               
             ]);
         try {
             
              newsletter::create([
                'email' => $request->email_newsletter_2
              ]);
            return back()->with('flash_success',trans('home.delivery_boy.created'));

         } catch (Exception $e) {

              return back()->with('flash_error',trans('form.whoops'));
         }

    }
    public function search(Request $request){
        $Shops = [];
        $url = url()->previous();
        $url_segment = explode('/', $url);
        
        if($request->segment(1)!=$url_segment[3]){
            Session::put('search_return_url',$url);
        }
        if($request->has('q')){
            $request->request->add(['prodname',$request->q]);
            $shops = (new ShopResource)->filter($request);
            $shops->map(function ($shops) {
                $shops['shopstatus'] = (new ShopResource)->shoptime($shops);;
                $shops['shopopenstatus'] = (new ShopResource)->shoptiming($shops);;
                return $shops;
            });
            foreach($shops as $val){
                if (preg_match("/".$request->q."/i", $val->name, $matches)) {
                    $Shops[$val->id] = $val;
                }else{
                    // foreach($val->categories as $valcat){
                    //     if(count($valcat->products)>0){
                    //         $Shops[$val->id] = $val;
                    //     }
                    // }
                }
            }
            //dd($Shops);
        }

        return view('search',compact('Shops'));
    }
}
