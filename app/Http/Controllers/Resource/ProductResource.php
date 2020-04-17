<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Image;
use Route;
use Exception;
use App\Addon;
use App\Product;
use App\Category;
use App\ProductImage;
use App\ProductPrice;
use Setting;
use App\AddonProduct;
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
            $Category = Category::productList($request->shop)->findOrFail($category);
            return view(Route::currentRouteName(), compact('Category'));
        } catch (ModelNotFoundException $e) {
            $Products = Product::list($request->shop);
            if($request->ajax()){
                return $Products;
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

            if(Setting::get('PRODUCT_ADDONS',1)){
                $Addons = Addon::where('shop_id',$request->shop)->get();
            }else{
                $Addons = [];
            }
            if(Setting::get('SUB_CATEGORY',1)){
                $Categories = Category::where('shop_id',$request->shop)->where('parent_id','=','0')->get();
            }else{
                $Categories = Category::where('shop_id',$request->shop)->get(); 
            }
             return view(Route::currentRouteName(),compact('Addons','Categories'));
            
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
                'category' => 'required',
                'food_type' => 'required',
                'price' => 'required',
                'product_position' => 'required'
            ]);
        try {

            if($request->has('featured')) {
                $request->featured_position = $request->featured_position?$request->featured_position:1;
            }
            if($request->has('discount')) {

                if($request->discount_type=='percentage'){
                    $orignal_price = $request->price-($request->price*($request->discount/100));
                }else{
                    $orignal_price = $request->price-$request->discount;
                }

            }else{
                $orignal_price = $request->price;
            }

            $Product = Product::create([
                    'shop_id' => $request->shop,
                    'name' => $request->name,
                    'description' => $request->description,
                    'featured' => $request->featured?$request->featured_position:0,
                    'food_type' => $request->food_type,
                    'parent_id' => $request->parent_id,
                    'position' => $request->product_position,
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
                    'orignal_price' => $orignal_price
                ]);
            if($request->has('addons')){
                $addons = $request->addons;
                $addons_price = $request->addons_price;
                foreach($addons as $key=>$val){
                    AddonProduct::create([
                        'addon_id' => $val,
                        'product_id' => $Product->id,
                        'price' => $addons_price[$val]
                        ]);
                    //$Product->addons()->attach($val,['price' => $addons_price[$val]]);
                    //$Shop->cuisines()->attach($cuisine);
                }
            }

            // return redirect()->route('admin.products.show', $request->category)->with('flash_success', 'Product Added');
            return back()->with('flash_success', 'Product Added');
        } catch (Exception $e) {
            // return redirect()->route('admin.products.index')->with('flash_error', trans('form.whoops'));
            return back()->with('flash_error', trans('form.whoops'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id,$category = NULL)
    {
        try {
            $Product = Product::with('prices','images','addons','cart')->findOrFail($id);
            if($request->ajax()){
                return $Product;
            }
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
            //dd($Product);
            if(Setting::get('PRODUCT_ADDONS',1)){
                $Addons = Addon::where('shop_id',$request->shop)->get();
            }else{
                $Addons = [];
            }
            if(Setting::get('SUB_CATEGORY',1)){
               $Categories = Category::with('subcategories')->where('shop_id',$request->shop)->where('parent_id','=','0')->get();
            }else{
                $Categories = Category::where('shop_id',$request->shop)->get(); 
            }
            
            //dd($Categories);
            return view(Route::currentRouteName(), compact('Product','Addons','Categories'));
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
                //'image' => 'image',
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
            if($request->has('discount')) {

                if($request->discount_type=='percentage'){
                    $orignal_price = $request->price-($request->price*($request->discount/100));
                }else{
                    $orignal_price = $request->price-$request->discount;
                }

            }else{
                $orignal_price = $request->price;
            }
                $Product->prices->update([
                    'price' => $request->price,
                    'currency' => Setting::get('currency'),
                    'discount' => $request->discount,
                    'discount_type' => $request->discount_type,
                    'orignal_price' => $orignal_price
                ]);       

            $Product->categories()->detach();
            if($request->has('category')) {
                $Product->categories()->attach($request->category);
            }

            if($request->hasFile('image')) {
                //if($Product->images->isEmpty()) {
                foreach($request->image as $key =>$img){
                    //$thumb_url = Image::make($img)->resize(50, 50)->save(storage('products/thumb/' . $img->name));
                    ProductImage::create([
                            'product_id' => $Product->id,
                            'url' => asset('storage/'.$img->store('products')),
                            //'thumb_url' => asset($thumb_url),
                            'position' => 0,
                        ]);
                }
                /*} else {
                    $Product->images[0]->update(['url' => asset('storage/'.$request->image->store('products'))]);
                }*/
            }

            if($request->hasFile('featured_image')) {
                //if($Product->images->isEmpty()) {
                if($product_image = ProductImage::where('product_id',$Product->id)->where('position',1)->first()){
                    $product_image->update(['url' => asset('storage/'.$request->featured_image->store('products'))]);
                }else{
                    ProductImage::create([
                            'product_id' => $Product->id,
                            'url' => asset('storage/'.$request->featured_image->store('products')),
                            'position' => 1,
                    ]);
                }
                /*} else {
                    $Product->images[0]->update(['url' => asset('storage/'.$request->image->store('products'))]);
                }*/
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
                foreach($addons as $key=>$val){
                    $product_addon = AddonProduct::where('product_id',$Product->id)->where('addon_id',$val)->first();
                    if(count($product_addon)>0){
                        $product_addon->price = $addons_price[$val];
                        $product_addon->save();
                    }else{
                        AddonProduct::create([
                            'addon_id' => $val,
                            'product_id' => $Product->id,
                            'price' => $addons_price[$val]
                        ]);
                    }
                    //$Shop->cuisines()->attach($cuisine);
                }
            }else{
                $add_prod_all =AddonProduct::where('product_id',$Product->id)->pluck('addon_id','addon_id')->toArray();
                 if(count($add_prod_all)>0){
                    AddonProduct::whereIn('addon_id',$add_prod_all)->delete();
                }
            }


            // return redirect()->route('admin.products.index')->with('flash_success', 'Product updated!');
            return back()->with('flash_success', 'Product updated!');
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.products.index')->with('flash_error', 'Product not found!');
            return back()->with('flash_error', 'Product not found!');
        } catch (Exception $e) {
            dd($e);
            // return redirect()->route('admin.products.index')->with('flash_error', trans('form.whoops'));
            return back()->with('flash_error', trans('form.whoops'));
        }
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
            $Product = Product::findOrFail($id);
            //$addon_prod = AddonProduct::where('product_id',$id)->delete();
            // Need to delete variants or have them re-assigned
            $Product->delete();
            // return redirect()->route('admin.products.index')->with('flash_success', 'Product deleted!');
            return back()->with('flash_success', 'Product deleted!');
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.products.index')->with('flash_error', 'Product not found!');
            return back()->with('flash_error', 'Product not found!');
        } catch (Exception $e) {
            // return redirect()->route('admin.products.index')->with('flash_error', trans('form.whoops'));
            return back()->with('flash_error', trans('form.whoops'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function imagedestroy($id)
    {
        try {
            $Product = ProductImage::findOrFail($id);
            // Need to delete variants or have them re-assigned
            $Product->delete();
            // return redirect()->route('admin.products.index')->with('flash_success', 'Product deleted!');
            return back()->with('flash_success', 'Image deleted!');
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.products.index')->with('flash_error', 'Product not found!');
            return back()->with('flash_error', 'Image not found!');
        } catch (Exception $e) {
            // return redirect()->route('admin.products.index')->with('flash_error', trans('form.whoops'));
            return back()->with('flash_error', trans('form.whoops'));
        }
    }
}