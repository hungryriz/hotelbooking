<?php

namespace App\Http\Controllers\Resource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cuisine;
use Route;
use Exception;
use App\Shop;

class CuisineResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $Cuisines = Cuisine::orderBy('name','ASC')->get();

            if($request->has('shop_id')){
                $Cuisines = Shop::find($request->shop_id)->cuisines()->get();
            }
            if($request->ajax())
                return $Cuisines;

            return view(Route::currentRouteName(), compact('Cuisines'));        
        } catch (ModelNotFoundException $e) {
            return $e->getMessages();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(Route::currentRouteName());
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
                'name' => 'required|string|max:255'
            ]);
        try {
            $Cuisine = Cuisine::create([
                    'name' => $request->name
                ]);     
            return redirect()->route('admin.cuisines.index')->with('flash_success', trans('form.resource.created'));
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
    public function show(Request $request,$id)
    {
        try {
            $Cuisine = Cuisine::findOrFail($id);
            if($request->ajax()){
                return $Cuisine;
            }
            return view(Route::currentRouteName(), compact('Cuisine'));
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
    public function edit($id)
    {
        try {
            $Cuisine = Cuisine::findOrFail($id);
            return view(Route::currentRouteName(), compact('Cuisine'));
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.products.index')->with('flash_error', 'Product not found!');
            return back()->with('flash_error', trans('form.whoops'));
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
                'name' => 'required|string|max:255'
            ]);
        try {
            $Cuisine = Cuisine::findOrFail($id);
            $Update = $request->all();
            $Cuisine->update($Update);
            return redirect()->route('admin.cuisines.index')->with('flash_success', trans('form.resource.updated'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.whoops'));
        } catch (Exception $e) {
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
            $Cuisine = Cuisine::findOrFail($id);
            // Need to delete Cusine 
            $Cuisine->delete();
            return redirect()->route('admin.cuisines.index')->with('flash_success', trans('form.resource.deleted'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.whoops'));
        } catch (Exception $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
    }
}
