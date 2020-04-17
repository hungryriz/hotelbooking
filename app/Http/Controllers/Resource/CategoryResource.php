<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Route;
use Setting;
use App\Product;
use App\Category;
use App\CategoryImage;
use App\AddonProduct;
class CategoryResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(Setting::get('SUB_CATEGORY',1)){
            $Categories = Category::where('parent_id','=','')->listwithsubcategory($request->shop , $request->user_id);
        }else{
            $Categories = Category::list($request->shop , $request->user_id);
        }
        $FeaturedProduct = Product::listfeatured_image($request->shop , $request->user_id);
        if($request->ajax()){
            return ['categories' => $Categories,
                    'featured_products' => $FeaturedProduct
                    ];
        }
        return view(Route::currentRouteName(), compact('Categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        $Categories = Category::where('shop_id',$request->shop)->where('parent_id','=','')->get();
        return view(Route::currentRouteName(), compact('Categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'name' => 'required|string|max:255',
                'description' => 'required|max:1000',
                'status' => 'required|in:enabled,disabled',
                'shop_id' => 'required'
            ]);

        try {
            $Category = $request->all();
            if($request->has('parent_id')){
                if($Category['parent_id'] != 0) {
                    $this->validate($request, [
                        'parent_id' => 'required|exists:categories,id',
                    ]);
                } else {
                    $Category['parent_id'] = 0;
                }
            }

            $Category = Category::create($Category);
            if($request->hasFile('image')){
                $CategoryImage = CategoryImage::create([
                    'category_id' => $Category->id,
                    'url' => asset('storage/'.$request->image->store('categories')),
                    'position' => 0,
                ]);
            }

            // return redirect()->route('admin.categories.index')->with('flash_success', 'Category added!');
            return back()->with('flash_success', 'Category added!');
        } catch (Exception $e) {
            // return redirect()->route('admin.categories.index')->with('flash_error', trans('form.whoops'));
            return back()->with('flash_error', trans('form.whoops'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $Category = Category::productList()->findOrFail($id);
            if($request->ajax()) {
                return $Category;
            }
            return view(Route::currentRouteName(), compact('Category'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Not Found!'], 404);
        } catch (Exception $e) {
            // return redirect()->route('admin.categories.index')->with('flash_error', trans('form.whoops'));
            return back()->with('flash_error', trans('form.whoops'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        try {
            $Category = Category::findOrFail($id);
            $Categories = Category::where('shop_id',$request->shop)->where('parent_id','=','')->get();

            return view(Route::currentRouteName(), compact('Category','Categories'));
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.categories.index')->with('flash_error', 'Category not found!');
            return back()->with('flash_error', trans('form.whoops'));
        } catch (Exception $e) {
            // return redirect()->route('admin.categories.index')->with('flash_error', trans('form.whoops'));
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
                'description' => 'required|max:1000',
                'status' => 'required|in:enabled,disabled'
            ]);

        try {
            $Category = Category::findOrFail($id);
            $Update = $request->all();
            if($request->has('parent_id')){
                if($Update['parent_id'] != 0) {
                    $this->validate($request, [
                        'parent_id' => 'required',
                    ]);
                } else {
                    $Update['parent_id'] = 0;
                }
            }


            $Category->update($Update);

            if($request->hasFile('image')) {
                if($Category->images->isEmpty()) {
                    CategoryImage::create([
                            'category_id' => $Category->id,
                            'url' => asset('storage/'.$request->image->store('categories')),
                            'position' => 0,
                        ]);
                } else {
                    $Category->images[0]->update(['url' => asset('storage/'.$request->image->store('categories'))]);
                }
            }
            // return redirect()->route('admin.categories.index')->with('flash_success', 'Category updated!');
            return back()->with('flash_success', 'Category updated!');
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.categories.index')->with('flash_error', 'Category not found!');
            return back()->with('flash_error', trans('form.whoops'));
        } catch (Exception $e) {
            // return redirect()->route('admin.categories.index')->with('flash_error', trans('form.whoops'));
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
            $Category = Category::findOrFail($id);
            $sid= $Category->shop_id;

            $prod_list  = $Category->products->pluck('id')->toArray();
            //dd($prod_list);
            //$addon_prod = AddonProduct::whereIn('product_id',$prod_list)->delete();
            //$addon_list = $Category->products->detach();
            $prod = Product::whereIN('id',$prod_list)->delete();
            
            // Need to delete subcategories or have them re-assigned
            $Category->delete();
            // return redirect()->route('admin.categories.index')->with('flash_success', 'Category updated!');
            return back()->with('flash_success', 'Category updated!');
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.categories.index')->with('flash_error', 'Category not found!');
            return back()->with('flash_error', trans('form.whoops'));
        } catch (Exception $e) {
            // return redirect()->route('admin.categories.index')->with('flash_error', trans('form.whoops'));
            return back()->with('flash_error', trans('form.whoops'));
        }
    }

    public function subcategory(Request $request){
        $Categories = Category::where('parent_id',$request->category)->list($request->shop , $request->user_id);
        if($request->ajax()){
            return $Categories;
        }
        return view('admin.categories.sub_category', compact('Categories'));
    }
}
