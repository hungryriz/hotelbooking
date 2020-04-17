<?php

namespace App\Http\Controllers\UserResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Log;
use Setting;
use Exception;
use Session;
use App\Order;
use App\UserCart;
use App\Promocode;
use App\Addon;
use App\CartAddon;
use App\Product;
class CartResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Products = UserCart::list($request->user()->id);
        $Cart = [
                'delivery_charges' => Setting::get('delivery_charge', 0),
                'delivery_free_minimum' => Setting::get('delivery_free_minimum', 0),
                'tax_percentage' => Setting::get('tax', 0),
                'carts' => $Products,
            ];
        return $Cart;
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
        $this->validate($request, [
                'product_id' => 'required|exists:products,id',
                'promocode' => 'max:255',
                'quantity' => 'integer|min:0',
            ]);
        Log::info($request->all());
        try {
            
            $Product = Product::find($request->product_id);
            if($Product->addon_status==1){
                if(!$request->has('product_addons')){
                    if($request->ajax()){
                        return response()->json(['message' => trans('inventory.addons.fixed')], 500);
                    }
                   return back()->with('flash_error',trans('inventory.addons.fixed'));
                }
            }

            // cart exist same product but we need same product different addons
            if($request->has('cart_id') && $request->has('new_cart')){
                 if($request->quantity > 0) {
                    $CartProduct = UserCart::create([
                        'user_id' => $request->user()->id,
                        'product_id' => $request->product_id,
                        'quantity' => $request->quantity,
                        'note' => $request->note
                    ]); 

                    if($request->has('product_addons')){
                        $product_addons = $request->product_addons;
                        $product_addons_qty = $request->addons_qty ;
                        $product_addons_price = $request->addons_price ;

                        foreach ($product_addons as $key => $value) {
                            CartAddon::create([
                                'addon_product_id' => $value,
                                'user_cart_id' => $CartProduct->id,
                                'quantity' => $product_addons_qty[$key],
                            ]); 
                        }
                    } 
                }
                 
            }elseif($request->has('cart_id')){
                // for edit cart item
                $CartProduct = UserCart::with('cart_addons')->where('id', $request->cart_id)
                    ->firstOrFail();
                    if($request->quantity > 0) {
                        $CartProduct->quantity = $request->quantity;
                        $CartProduct->note = $request->note;
                        $CartProduct->save();

                        if($request->has('product_addons')){
                                $product_addons = $request->product_addons;
                                $product_addons_qty = $request->addons_qty ;
                                $product_addons_price = $request->addons_price ;
                                if(count($CartProduct->cart_addons)>0){
                                    $alladdon_cart = $CartProduct->cart_addons
                                        ->pluck('addon_product_id','addon_product_id')->toArray();
                                    $extra_addons_rmv = array_diff($alladdon_cart, $product_addons);
                                    CartAddon::whereIn('addon_product_id',$extra_addons_rmv)->delete();
                                }

                                foreach ($product_addons as $key => $value) {
                                    $addon_cart = CartAddon::where('addon_product_id' , $value)
                                        ->where('user_cart_id', $CartProduct->id)
                                        ->first();
                                    if(count($addon_cart)>0){
                                        $addon_cart->quantity = $product_addons_qty[$key];
                                        $addon_cart->save();
                                    }else{
                                        CartAddon::create([
                                            'addon_product_id' => $value,
                                            'user_cart_id' => $CartProduct->id,
                                            'quantity' => $product_addons_qty[$key],
                                        ]); 
                                    }
                                }
                        }else{
                            if(count($CartProduct->cart_addons)>0){
                                    $alladdon_cart = $CartProduct->cart_addons
                                        ->pluck('id','id')->toArray();
                                    
                                    CartAddon::whereIn('id',$alladdon_cart)->delete();
                                }
                        } 

                    } else {
                        if($request->has('addon_id')){ 
                            CartAddon::where('user_cart_id',$request->addon_id)->delete();
                        }else{ 
                           UserCart::where('id',$CartProduct->id)->delete();
                            CartAddon::where('user_cart_id',$CartProduct->id)->delete();
                        }
                            
                    }
            }else{
                // create new item
                if($request->quantity > 0) {
                    $CartProduct = UserCart::create([
                        'user_id' => $request->user()->id,
                        'product_id' => $request->product_id,
                        'quantity' => $request->quantity,
                        'note' => $request->note
                    ]); 

                    if($request->has('product_addons')){
                        $product_addons = $request->product_addons;
                        $product_addons_qty = $request->addons_qty ;
                        $product_addons_price = $request->addons_price ;

                        foreach ($product_addons as $key => $value) {
                            CartAddon::create([
                                'addon_product_id' => $value,
                                'user_cart_id' => $CartProduct->id,
                                'quantity' => $product_addons_qty[$key],
                            ]); 
                        }
                    } 
                }
            }
           
        } catch (ModelNotFoundException $e) {
            if($request->quantity > 0) {
                    $CartProduct = UserCart::create([
                        'user_id' => $request->user()->id,
                        'product_id' => $request->product_id,
                        'quantity' => $request->quantity,
                        'note' => $request->note
                    ]); 

                    if($request->has('product_addons')){
                        $product_addons = $request->product_addons;
                        $product_addons_qty = $request->addons_qty ;
                        $product_addons_price = $request->addons_price ;

                        foreach ($product_addons as $key => $value) {
                            CartAddon::create([
                                'addon_product_id' => $value,
                                'user_cart_id' => $CartProduct->id,
                                'quantity' => $product_addons_qty[$key],
                            ]); 
                        }
                    } 
            }
        }
        if($request->ajax()){
            return $this->index($request);
        }
        if($request->addons_details){
            return redirect('restaurant/details?name='.$request->shop_name)->with('flash_success',trans('form.resource.updated'));
        }else{
            return back()->with('flash_success',trans('form.resource.updated'));
        }
        
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
        try {
            if($request->has('addon_id')){
                $Item = CartAddon::findOrFail($request->has('addon_id'));
                $Item->delete();

            }else{
                $Item = UserCart::findOrFail($id);
                $Item->delete();
                CartAddon::where('user_cart_id',$id)->delete();
            }
            return response()->json(['message' => 'Product was removed from your cart.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => trans('form.whoops')], 500);
        }
    }


    /**
     * Checkout items in the cart and place an Order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request)
    {   

        try{
            $shop = Session::get('shop');
            if(count($shop[$request->shop_id])>0){
                if(isset($shop[$request->shop_id][$request->product_id])){
                    if($request->quantity == 0){ 
                        unset($shop[$request->shop_id][$request->product_id]);
                        if(count($shop[$request->shop_id])==0){
                            Session::pull('shop');
                            return back()->with('flash_success',trans('form.resource.updated'));
                        }
                    }else{ 
                        $item=$shop[$request->shop_id][$request->product_id];
                        $item['quantity'] = $request->quantity;
                        $item['note'] = $request->note; 
                        if($request->has('product_addons')){
                            $product_addons = $request->product_addons;
                            $product_addons_qty = $request->addons_qty ;
                            $product_addons_price = $request->addons_price ;
                            $product_addons_name = $request->addons_name ;
                            foreach ($product_addons as $key => $value) {
                                $all_addons[$value] =[ 
                                    'addon_product_id' => $value,
                                    'price' => $product_addons_price[$key],
                                    'quantity' => $product_addons_qty[$key],
                                    'name' => $product_addons_name[$key]
                                ]; 
                            }
                        }else{
                            $all_addons = [];
                        }
                        $item['addons'] = $all_addons; 

                        $shop[$request->shop_id][$request->product_id] = $item;
                    }   
                }else{ 

                    if($request->has('product_addons')){
                        $product_addons = $request->product_addons;
                        $product_addons_qty = $request->addons_qty ;
                        $product_addons_price = $request->addons_price ;
                        $product_addons_name = $request->addons_name ;
                        foreach ($product_addons as $key => $value) {
                            $all_addons[$value] =[ 
                                'addon_product_id' => $value,
                                'price' => $product_addons_price[$key],
                                'quantity' => $product_addons_qty[$key],
                                'name' => $product_addons_name[$key]
                            ]; 
                        }
                    }else{
                        $all_addons = [];
                    }

                    $shop[$request->shop_id][$request->product_id] = [
                        'product_id' => $request->product_id,
                        'quantity' => $request->quantity,
                        'name' => $request->name,
                        'price' => $request->price,
                        'note' => $request->note,
                        'addons' => $all_addons
                    ]; 
                }      
            }else{
                Session::pull('shop');
                    if($request->has('product_addons')){
                        $product_addons = $request->product_addons;
                        $product_addons_qty = $request->addons_qty ;
                        $product_addons_price = $request->addons_price ;
                        $product_addons_name = $request->addons_name ;
                        foreach ($product_addons as $key => $value) {
                            $all_addons[$value] =[ 
                                'addon_product_id' => $value,
                                'price' => $product_addons_price[$key],
                                'quantity' => $product_addons_qty[$key],
                                'name' => $product_addons_name[$key]
                            ]; 
                        }
                    }else{
                        $all_addons = [];
                    }

                        
                $shop[$request->shop_id][$request->product_id] = [
                        'product_id' => $request->product_id,
                        'quantity' => $request->quantity,
                        'name' => $request->name,
                        'price' => $request->price,
                        'note' => $request->note,
                        'addons' => $all_addons
                ];
            }

            Session::put('shop',$shop);
             //print_r($request->all());exit;
            if($request->ajax()){
                return Session::get('shop');
            }
            if($request->addons_details){
                return redirect('restaurant/details?name='.$request->shop_name)->with('flash_success',trans('form.resource.updated'));
            }else{
                return back()->with('flash_success',trans('form.resource.updated'));
            }
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')], 500);
            }
            return back()->with('flash_failure',trans('form.whoops'));
        }
        
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clearCart(Request $request)
    {
        try {
            $shop = Session::get('shop');
            if($shop){
                Session::pull('shop'); 
            }else{
                $Carts = UserCart::list($request->user()->id)->pluck('id');
                $Item = UserCart::destroy($Carts->toArray());
            }   
            if($request->ajax()){
            return response()->json(['message' => 'Product was removed from your cart.']);
            }
            return back()->with('flash_success','Product was removed from your cart.');
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => trans('form.whoops')], 500);
        }
    }
   
}
