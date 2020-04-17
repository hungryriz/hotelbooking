<?php

namespace App\Http\Controllers\ShopResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Route;
use Exception;
use App\Addon;
use App\AddonProduct;
use App\Product;
use App\Category;
use App\ProductImage;
use App\ProductPrice;
use Setting;
use Auth;
use App\Shop;
class ProductResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category = null)
    {
        try {
            $Category = Category::productList($request->user()->id)->findOrFail($category);
            return view(Route::currentRouteName(), compact('Category'));
        } catch (ModelNotFoundException $e) {
             $Products = Product::List($request->user()->id);
            if($request->ajax()){
                return $Products ;
            }
            return view(Route::currentRouteName(), compact('Products'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try{
            if(Setting::get('PRODUCT_ADDONS')==1){
                $Addons = Addon::where('shop_id',Auth::user('shop')->id)->get();
            }else{
                $Addons = [];
            }
            $Cuisines = Shop::with('cuisines')->where('id',Auth::user('shop')->id)->first();
            return view(Route::currentRouteName(),compact('Addons','Cuisines'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }catch(Exception $e){
            return back()->with('flash_error', trans('form.whoops'));
        }
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
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'required',
                'image.*' => 'image|mimes:jpeg,jpg,png|max:5120',
                'category' => 'required',
                'price' => 'required',
                'product_position' => 'required'
            ]);
        try {
            if($request->has('featured')) {
                $request->featured_position = $request->featured_position?$request->featured_position:1;
            }
            $Product = Product::create([
                    'shop_id' => $request->shop,
                    'name' => $request->name,
                    'description' => $request->description,
                    'featured' => $request->featured?$request->featured_position:0,
                    'position' => $request->product_position,
                    'cuisine_id' => $request->cuisine_id,
                ]);

            
            $Product->categories()->attach($request->category);
            

            foreach($request->image as $key =>$img){
                ProductImage::create([
                    'product_id' => $Product->id,
                    'url' => asset('storage/'.$img->store('products')),
                    'position' => 0,
                ]);
            }

            if($request->hasFile('featured_image')) {
               
                ProductImage::create([
                    'product_id' => $Product->id,
                    'url' => asset('storage/'.$request->featured_image->store('products')),
                    'position' => 1,
                ]);
            }

            ProductPrice::create([
                    'product_id' => $Product->id,
                    'price' => $request->price,
                    'currency' => Setting::get('currency'),
                    'discount' => $request->discount,
                    'discount_type' => $request->discount_type,
                ]);


            if($request->has('addons')){
                $addons = $request->addons;
                $addons_price = $request->addons_price;
                foreach($addons as $key=>$val){
                    AddonProduct::create([
                        'addon_id' => $val,
                        'product_id' => $Product->id,
                        'price' => $addons_price[$key]
                        ]);
                    //$Product->addons()->attach($val,['price' => $addons_price[$val]]);
                    //$Shop->cuisines()->attach($cuisine);
                }
            }


            if($request->ajax()){
                return Product::with('productcuisines','images','featured_images', 'prices','categories','addons')->findOrFail($Product->id) ;
                //return Product::Search($request->user()->id)->where('id',$Product->id)->first() ;
            }
            return back()->with('flash_success', 'Product Added');
        } catch (ModelNotFoundException $e) {
            if($request->ajax()){
                return response()->json(['error' => $e->getMessage()], 500);
            }
            // return redirect()->route('admin.products.index')->with('flash_error', 'Product not found!');
            return back()->with('flash_error', 'Product not found!');
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('flash_error', trans('form.whoops'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category, $id)
    {
        try {
            $Product = Product::with('variants')->findOrFail($id);
            return view(Route::currentRouteName(), compact('Product'));
        } catch (Exception $e) {
            if($request->ajax()) {
                return response()->json(['message' => 'Not Found!'], 404);
            }
            // return redirect()->route('admin.products.index', $category)->with('flash_error', 'Not Found!');            
            return back()->with('flash_error', 'Not Found!');            
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        try {
            $Product = Product::with('addons')->findOrFail($id);
            if(Setting::get('PRODUCT_ADDONS')==1){
                $Addons = Addon::where('shop_id',Auth::user('shop')->id)->get();
            }else{
                $Addons = [];
            }
            $Cuisines = Shop::with('cuisines')->where('id',Auth::user('shop')->id)->first();
            return view(Route::currentRouteName(), compact('Product','Addons','Cuisines'));
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.products.index')->with('flash_error', 'Product not found!');
            return back()->with('flash_error', 'Product not found!');
        } catch (Exception $e) {
            // return redirect()->route('admin.products.index')->with('flash_error', trans('form.whoops'));
            return back()->with('flash_error', trans('form.whoops'));
        }
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
        $this->validate($request, [
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                //'position' => 'required|integer',
                'image.*' => 'image|mimes:jpeg,jpg,png|max:5120',
                'category' => 'required',
                'price' => 'required',
                'product_position' => 'required'
            ]);

        try {
            $Product = Product::findOrFail($id);

            $Update = $request->all();
            if($request->has('featured')) {
                $Update['featured'] = $Update['featured_position']?:1;
            }else{
                $Update['featured'] = 0;
            }
            if($request->has('product_position')) {
                $Update['position'] = $Update['product_position']?:'';
            }
            if($request->has('addon_status')) {
                $Update['addon_status'] = 1;
            }else{
                $Update['addon_status'] = 0;
            }
            $Product->update($Update);

                $Product->prices->update([
                    'price' => $request->price,
                    'currency' => Setting::get('currency'),
                    'discount' => $request->discount,
                    'discount_type' => $request->discount_type,
                ]);       

            $Product->categories()->detach();
            if($request->has('category')) {
                $Product->categories()->attach($request->category);
            }

            if($request->hasFile('image')) {
                foreach($request->image as $key =>$img){
                    ProductImage::create([
                            'product_id' => $Product->id,
                            'url' => asset('storage/'.$img->store('products')),
                            'position' => 0,
                        ]);
                }
            }

            if($request->hasFile('featured_image')) {
                if($product_image = ProductImage::where('product_id',$Product->id)->where('position',1)->first()){
                    $product_image->update(['url' => asset('storage/'.$request->featured_image->store('products'))]);
                }else{
                    ProductImage::create([
                            'product_id' => $Product->id,
                            'url' => asset('storage/'.$request->featured_image->store('products')),
                            'position' => 1,
                    ]);
                }
            }


            if($request->has('addons')){
                $addons = $request->addons;
                $addons_price = $request->addons_price;
               // $Product->addons()->detach();

                $add_prod_all =AddonProduct::where('product_id',$Product->id)->pluck('addon_id','addon_id')->toArray();
                $remove_addons =array_diff($add_prod_all,$addons);
                if(count($remove_addons)>0){
                    sort($remove_addons);
                    AddonProduct::whereIn('addon_id',$remove_addons)->delete();
                }

                //print_r($remove_addons); exit;
                $product_addon = array();
                foreach($addons as $key=>$val){
                    $product_addon = AddonProduct::where('product_id',$Product->id)->where('addon_id',$val)->first();

                    if(count($product_addon)>0){
                        $product_addon->price = $addons_price[$key];
                        $product_addon->save();
                    }else{
                        AddonProduct::create([
                            'addon_id' => $val,
                            'product_id' => $Product->id,
                            'price' => $addons_price[$key]
                        ]);
                    }
                    //$Shop->cuisines()->attach($cuisine);
                }
            }
            if($request->ajax()){

                return Product::with('productcuisines','images','featured_images', 'prices','categories','addons')->findOrFail($id) ;
            }
            // return redirect()->route('admin.products.index')->with('flash_success', 'Product updated!');
            return back()->with('flash_success', 'Product updated!');
        } catch (ModelNotFoundException $e) {
            if($request->ajax()){
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('flash_error', 'Product not found!');
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('flash_error', trans('form.whoops'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        try {
            $Product = Product::findOrFail($id);
            // Need to delete variants or have them re-assigned
            $Product->delete();
            if($request->ajax()) {
                return response()->json(['message' => 'Product deleted!'], 200);
            }
            return back()->with('flash_success', 'Product deleted!');
        } catch (ModelNotFoundException $e) {
           if($request->ajax()){
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('flash_error', 'Product not found!');
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('flash_error', trans('form.whoops'));
        }
    }
}
