<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use auth;
use App\ShopBanner;
use App\Shop;
use App\Product;
use Exception;
class ShopBannerResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        try {
            $BannerImage = ShopBanner::all();
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
        
        return view('admin.banner.index',compact('BannerImage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $Resturants = Shop::all();
        return view('admin.banner.create', compact('Resturants'));
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
                'shop_id' => 'required',
                'product_id' => 'required',
                'image' => 'image|max:5120',
            ]);
        try {
            $Banner = ShopBanner::create([
                'shop_id' => $request->shop_id,
                'product_id' => $request->product_id,
                'url' => asset('storage/'.$request->image->store('shops/banner')),
                'status' => $request->status,
                'position' => $request->position
                ]);
            return back()->with('flash_success', trans('form.resource.created'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.not_found'));
        } catch (Exception $e) {
            return back()->with('flash_error', trans('form.whoops'));
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
        $Banner = ShopBanner::findOrFail($id);
        $Resturants = Shop::all();
        $Products = Product::where('shop_id',$Banner->shop_id)->get();
        return view('admin.banner.edit', compact('Banner','Resturants','Products'));
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
                'status' => 'required',
                'shop_id' => 'required',
                'product_id' => 'required',
            ]);

        try {
            $BannerImage = ShopBanner::findOrFail($id);
            
            if($request->hasFile('image')) {
                $Update['url'] = asset('storage/'.$request->image->store('shops/banner'));
            }
            if($request->has('status')) {
                $Update['status'] = $request->status;
            }
            if($request->has('shop_id')) {
                $Update['shop_id'] = $request->shop_id;
            }
             if($request->has('product_id')) {
                $Update['product_id'] = $request->product_id;
            }
            if($request->has('position')) {
                $Update['position'] = $request->position;
            }
            
            $BannerImage->update($Update);

            // return redirect()->route('admin.products.index')->with('flash_success', 'Product updated!');
            return back()->with('flash_success',  trans('form.resource.updated'));
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
    public function destroy($id)
    {
        try {
            $Banner = ShopBanner::findOrFail($id);
            // Need to delete variants or have them re-assigned
            $Banner->delete();
            return back()->with('flash_success', trans('form.resource.deleted'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'data not found!');
        } catch (Exception $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
    }
}
